<?php

namespace App\Livewire;

use Livewire\Component;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Fieldset;
use App\Models\Announcement as Announcement;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use App\Models\Group;
use App\Models\User;
use App\Models\Sms;
use App\Services\AudienceService;
use App\Services\smsai;
use App\Services\XSSai;
use App\Models\Notification as CustomNotification;
use Filament\Forms\Components\Textarea;
use App\Services\FirebaseNotificationService;

class Announcements extends Component implements HasForms, HasActions, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    public ?array $data = [];
    public $modalData = [];
    public $smsMessage = "";

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        $audienceService = app(AudienceService::class);
        $smsai = app(smsai::class);

        return $form
            ->extraAttributes([
                'x-data' => '{}',
                'x-init' => "
                let saved = JSON.parse(localStorage.getItem('announcementDraft') ?? '{}');
                
                if (Object.keys(saved).length > 0) {
                    if (confirm('A saved draft was found. Do you want to restore it?')) {
                        for (let key in saved) {
                            if (saved[key] !== null && saved[key] !== undefined) {
                                \$wire.set('data.' + key, saved[key]);
                            }
                        }
                    } else {
                        localStorage.removeItem('announcementDraft');
                    }
                }

                \$watch('\$wire.data', value => {
                    localStorage.setItem('announcementDraft', JSON.stringify(value));
                });
            ",
            ])
            ->schema([
                Section::make('Audience Visibility')
                    ->description('Control who can view this post by tagging specific users or groups')
                    ->schema([
                        Toggle::make('post_public')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true)
                            ->reactive(),
                        Fieldset::make('private')
                            ->hidden(fn(callable $get) => $get('post_public'))
                            ->schema([
                                Checkbox::make('user_toggle')->reactive()->label("Tag Specific Users"),
                                Checkbox::make('group_toggle')->reactive()->label("Tag Specific Groups"),

                                CheckboxList::make('users')
                                    ->hidden(fn(callable $get) => ! $get('user_toggle'))
                                    ->label('Tag your audience [Users]')
                                    ->searchable()
                                    ->columns(1)
                                    ->noSearchResultsMessage('No users match your search.')
                                    ->options(fn() => $audienceService->getVisibleUsers()),

                                CheckboxList::make('groups')
                                    ->hidden(fn(callable $get) => ! $get('group_toggle'))
                                    ->label('Tag your audience [Groups]')
                                    ->searchable()
                                    ->columns(1)
                                    ->noSearchResultsMessage('No groups match your search.')
                                    ->options(fn() => $audienceService->getVisibleGroups()),
                            ])
                    ]),
                TextInput::make('title')
                    ->required(),
                FileUpload::make('images')
                    ->acceptedFileTypes([
                        'image/png',
                        'image/jpeg',
                        'image/gif',
                        'video/mp4',
                    ])
                    ->imageCropAspectRatio('16:9')
                    ->multiple()
                    ->imageEditor()
                    ->imageEditorEmptyFillColor('Green')
                    ->loadingIndicatorPosition('left')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->panelLayout('grid')
                    ->reorderable()
                    ->appendFiles()
                    ->openable()
                    ->uploadingMessage('Uploading Images...')
                    ->minFiles(0)
                    ->maxFiles(15)
                    ->maxSize(50000),
                MarkdownEditor::make('content')
                    ->toolbarButtons([]),
                Checkbox::make('is_sms')
                    ->label(fn($state): string => $state ? 'SMS is Enabled' : 'Enable SMS Notification')
                    ->reactive()
                    ->live(),
                Textarea::make('sms_message')
                    ->label('SMS Message Content')
                    ->rows(3)
                    ->visible(fn($get) => $get('is_sms') === true)
                    ->required(fn($get) => $get('is_sms') === true)
                    ->maxLength(200),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Announcement::query()->where('created_by', Auth::id())->latest())
            ->columns([
                Tables\Columns\ImageColumn::make('images')->label('Image')->getStateUsing(function ($record) {
                    return $record->images ? asset('storage/' . $record->images[0]) : null;
                })->size(50),
                Tables\Columns\TextColumn::make('title')->searchable()->label('Title')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime(),
                Tables\Columns\TextColumn::make('content')->label('Content')->limit(100),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public bool $isLoading = false;

    public function create(): void
    {
        $this->isLoading = true;

        $data = $this->form->getState();

        // Prepare AI response only if used
        $XSSai = app(XSSai::class);
        $XSSai->ask($data['content']); // If you use this result, store it

        $fcm = app(FirebaseNotificationService::class);

        // Reorder media
        $media = collect($data['images'] ?? []);
        $orderedImages = $media->sortBy(fn($file) => Str::endsWith($file, '.mp4') ? 0 : 1)->values();

        $users = $data['users'] ?? [];
        $groups = $data['groups'] ?? [];
        $isPublic = !empty($data['post_public']);

        $tags = $isPublic ? [] : array_merge($users, $groups);

        $announcement = Announcement::create([
            'title' => $data['title'],
            'images' => $orderedImages,
            'content' => $data['content'],
            'users' => $users,
            'groups' => $groups,
            'tags' => $tags,
            'created_by' => Auth::id(),
        ]);

        // Fetch SMS numbers only when needed
        if (!empty($data['is_sms']) && !empty($data['sms_message'])) {
            $numbers = collect();

            if ($isPublic) {
                $numbers = User::pluck('contact');
            } elseif (!empty($users)) {
                $numbers = User::whereIn('id', $users)->pluck('contact');
            }

            if (!empty($groups)) {
                $groupContacts = User::whereIn('user_group', $groups)->pluck('contact');
                $numbers = $numbers->merge($groupContacts);
            }

            $numbers = $numbers->filter()->unique()->values();

            Sms::create([
                'numbers' => $numbers->toJson(),
                'Content' => $this->smsMessage,
                'status' => 'created',
            ]);
        }

        // Cache user to reduce repeat calls
        $auth = Auth::user();
        $authorName = $auth->LastName . ', ' . $auth->FirstName . ' ' . ($auth->MiddleName ?? '') ?: 'System';
        $authorProfile = $auth->profile_picture ?? '/images/default-profile.png';

        CustomNotification::create([
            'category' => 'Announcement',
            'descriptions' => $data['title'] . ": " . $data['content'],
            'user_id_who_already_viewed' => json_encode([]),
            'user_id_who_can_viewed' => json_encode($tags),
            'author_name' => $authorName,
            'author_profile' => $authorProfile,
            'link' => $announcement->id,
        ]);

        // $fcm->sendNotificationToAll(
        //     json_encode($tags),
        //     Str::limit($data['title'], 100),
        //     Str::limit($this->smsMessage, 200),
        //     $announcement
        // );

        $this->form->fill([]);
        $this->isLoading = false;

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }



    public function readMore($id)
    {
        $this->modalData = Announcement::where('id', $id)->get();
        dd($this->modalData);
    }

    public function render(): View
    {
        return view('livewire.announcements');
    }
}
