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
use Filament\Forms\Set;
use Illuminate\Support\Facades\Log;

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
                    ->maxSize(200000),
                MarkdownEditor::make('content')
                    ->toolbarButtons([]),
                Checkbox::make('is_sms')
                    ->label(fn($state): string => $state ? 'SMS is Enabled' : 'Enable SMS Notification')
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {

                        // Prepare AI response only if used
                        $sms_Ai = app(smsai::class);
                        $content = $sms_Ai->ask($state);
                        if($content)
                        {
                        $set('content', $content);
                        Notification::make()
                            ->title($state ? 'SMS Notifications Enabled' : 'SMS Notifications Disabled')
                            ->body($state
                                ? 'You’ll now receive updates via SMS.'
                                : 'SMS alerts have been turned off.')
                            ->success()
                            ->send();
                        }
                    })
                    ->live(),
                Textarea::make('sms_message')
                    ->label('SMS Message Content')
                    ->rows(3)
                    ->visible(fn($get) => $get('is_sms') === true)
                    ->required(fn($get) => $get('is_sms') === true),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Announcement::query()->where('created_by', Auth::id())->latest())
            ->columns([
                Tables\Columns\TextColumn::make('images')
                    ->label('Media')
                    ->formatStateUsing(function ($state) {
                        if (!$state || empty($state)) {
                            return 'No media';
                        }

                        // Convert comma-separated string to array
                        $filesArray = explode(',', $state);
                        $firstFile = trim($filesArray[0]);
                        $fileUrl = 'https://irosincentralschool.com/storage/' . $firstFile;

                        // Check if it's a video file
                        if (Str::endsWith(strtolower($firstFile), '.mp4')) {
                            return '<img src="/video.jpg" alt="Media" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">';
                        }

                        // For image files, show thumbnail
                        return '<img src="' . $fileUrl . '" alt="Media" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">';
                    })
                    ->html()
                    ->size(50)
                    ->placeholder('No media'),
                Tables\Columns\TextColumn::make('title')->searchable()->label('Title')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime(),
                Tables\Columns\TextColumn::make('content')->label('Content')->limit(100),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form(function () {
                        $audienceService = app(AudienceService::class);

                        return [
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
                                // ->imageCropAspectRatio('16:9')
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
                                ->maxSize(200000),
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
                                ->required(fn($get) => $get('is_sms') === true),
                        ];
                    })
                    ->mutateFormDataUsing(function (array $data, $record): array {
                        // Handle existing images if no new images are uploaded
                        if (empty($data['images'])) {
                            $data['images'] = $record?->images ?? [];
                        }
                        return $data;
                    }),
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


        // $fcm = app(FirebaseNotificationService::class);

        // Reorder media
        $media = collect($data['images'] ?? []);
        $orderedImages = $media->sortBy(fn($file) => Str::endsWith($file, '.mp4') ? 0 : 1)->values();

        $users = $data['users'] ?? [];
        $groups = $data['groups'] ?? [];
        $isPublic = !empty($data['post_public']);

        $tags = $isPublic ? [] : array_merge($users, $groups);

        if (empty($tags)) {
            $tags = User::pluck('id')->toArray();
        }

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
                'numbers' => json_encode($numbers),
                'Content' => "Announcement From Irosin Central School\n\n{$data['sms_message']}",
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

