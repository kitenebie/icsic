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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use App\Models\Group;
use App\Models\User;
use App\Models\Sms;
use App\Services\AudienceService;
use App\Services\smsai;
use App\Services\XSSai;
use App\Models\Notification as CustomNotification;
use Filament\Forms\Components\Textarea;
use App\Services\FirebaseNotificationService;

class Announcements extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithForms;

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
                    ->label(fn($state): string => $state ? 'SMS is Enabled with AI generated text 🤖' : 'Enable SMS Notification')
                    ->reactive()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) use ($smsai) {
                        if ($state) {
                            // Only generate if content is non-empty and changed
                            $content = $get('content');
                            if (!empty($content)) {
                                $this->smsMessage = $smsai->ask($content);
                                $set('sms_message', $this->smsMessage);
                            }
                        }
                    }),

                Checkbox::make('is_web')
                    ->label(fn($state): string => $state ? 'Web is Enabled with AI generated text 🤖' : 'Enable Web Notification')
                    ->reactive()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $get) use ($smsai) {
                        if ($state && empty($this->smsMessage)) {
                            $content = $get('content');
                            if (!empty($content)) {
                                $this->smsMessage = $smsai->ask($content);
                            }
                        }
                    })
                    ->default(false),

                Textarea::make('sms_message')
                    ->label('SMS Message Content (Ai Generated)')
                    ->rows(3)
                    ->visible(fn($get) => $get('is_sms') === true)
                    ->required(fn($get) => $get('is_sms') === true)
                    ->maxLength(200),
            ])
            ->statePath('data');
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

        $fcm->sendNotificationToAll(
            json_encode($tags),
            Str::limit($data['title'], 100),
            Str::limit($this->smsMessage, 200),
            $announcement
        );

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
    public static function table(Table $table): Table
    {
        return $table
            ->query(Announcement::query()->orderByDesc('id'))->poll('10s')
            ->columns([
                TextColumn::make('title')
                    ->label('Post Title')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('post_public')
                    ->boolean()
                    ->label('Public')
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger'),

                TextColumn::make('users')
                    ->label('Tagged Users')
                    // ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : '-')
                    ->toggleable(),

                TextColumn::make('groups')
                    ->label('Tagged Groups')
                    // ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : '-')
                    ->toggleable(),

                ImageColumn::make('images')
                    ->label('Media')
                    ->circular()
                    ->limit(3),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->modalHeading('View announcement')
                    ->modalSubmitAction(false) // Hide submit button
                    ->modalCancelActionLabel('Close')
                    ->fillForm(fn(Announcement $record): array => [
                        // dd($record);
                        'title' => $record->title,
                        'content' => $record->content,
                        'images' => $record->images ?? [],
                        'post_public' => $record->post_public ?? true,
                        'users' => $record->tags_user ?? [],
                        'groups' => $record->tags_group ?? [],
                    ])
                    ->form([
                        Section::make('Audience Visibility')
                            ->schema([
                                Toggle::make('post_public')->label('Public')->disabled(),
                                TextInput::make('users')->label('Tagged Users')->disabled(),
                                TextInput::make('groups')->label('Tagged Groups')->disabled(),
                            ]),
                        TextInput::make('title')->disabled(),
                        FileUpload::make('images')
                            ->multiple()
                            ->imageEditor()
                            ->disabled(),
                        MarkdownEditor::make('content')->disabled(),
                    ]),
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit announcement')
                    ->modalCancelActionLabel('Close')
                    ->fillForm(fn(Announcement $record): array => [
                        'title' => $record->title,
                        'content' => $record->content,
                        'images' => $record->images ?? [],
                        'post_public' => $record->post_public ?? true,
                        'users' => $record->tags_user ?? [],
                        'groups' => $record->tags_group ?? [],
                    ])
                    ->form([
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
                                        Checkbox::make('user')->reactive()->label("Tag Specific users"),
                                        Checkbox::make('group')->reactive()->label("Tag Specific groups"),
                                        CheckboxList::make('tags_user')
                                            ->hidden(fn(callable $get) => ! $get('user'))
                                            ->label('Tag your audience [Users]')
                                            ->noSearchResultsMessage('No users found.')
                                            ->searchPrompt('Search for a audience')
                                            ->searchable()
                                            ->bulkToggleable()
                                            ->columns(1)
                                            ->options([
                                                'Carl Martes',
                                                'John Doe',
                                                'Edward Swite',
                                                'Anne Brezee',
                                            ]),
                                        CheckboxList::make('tags_group')
                                            ->hidden(fn(callable $get) => ! $get('group'))
                                            ->label('Tag your audience [Groups]')
                                            ->noSearchResultsMessage('No groups found.')
                                            ->searchPrompt('Search for a audience')
                                            ->searchable()
                                            ->bulkToggleable()
                                            ->columns(1)
                                            ->options([
                                                'Grade 1 - Charity',
                                                'Grade 1 - Prarents',
                                                'Faculty Members',
                                                'PTA Members',
                                                'Parents',
                                            ]),
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
                    ]),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public function render(): View
    {
        return view('livewire.announcements', [
            'Announcements' => Announcement::orderBy('updated_at', 'desc')->get()
        ]);
    }
}
