<?php

namespace App\Livewire;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Forms\Components\TagsInput;
use App\Models\NewsPage as NewsDB;
use Filament\Notifications\Notification;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Wizard;
use Filament\Tables\Enums\ActionsPosition;
use App\Services\AudienceService;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Fieldset;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class News extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public ?array $data = [];

    public $categories = [
        "School Announcements",
        "Teacher Updates",
        "Student Achievements",
        "Curriculum Changes",
        "School Events",
        "DEPED Policies",
        "Educational Resources",
        "Parent Involvement",
        "School Safety",
        "Academic Programs",
        "Extracurricular Activities",
        "School Administration",
        "Teacher Training",
        "Student Welfare",
        "Educational Technology",
        "School Facilities",
        "Graduation News",
        "Enrollment Information",
        "Scholarship Opportunities",
        "Educational Reforms",
        "School Supplies",
        "Teacher Recruitment",
        "Student Discipline",
        "School Budget",
        "Educational Partnerships",
        "Online Learning",
        "Special Education",
        "School Feeding Program",
        "DepEd Orders",
        "School Calendar"
    ];

    public function mount(): void
    {
        $this->form->fill();
    }


    public function form(Form $form): Form
    {

        $audienceService = app(AudienceService::class);
        return $form
            ->extraAttributes([
                'x-data' => '{}',
                'x-init' => "
                let saved = JSON.parse(localStorage.getItem('NewsDraft') ?? '{}');
                
                if (Object.keys(saved).length > 0) {
                    if (confirm('A saved draft was found. Do you want to restore it?')) {
                        for (let key in saved) {
                            if (saved[key] !== null && saved[key] !== undefined) {
                                \$wire.set('data.' + key, saved[key]);
                            }
                        }
                    } else {
                        localStorage.removeItem('NewsDraft');
                    }
                }

                \$watch('\$wire.data', value => {
                    localStorage.setItem('NewsDraft', JSON.stringify(value));
                });
            ",
            ])
            ->schema([
                Wizard::make([
                    Wizard\Step::make('News Topic')
                        ->schema([
                            FileUpload::make('image')
                                ->acceptedFileTypes([
                                    'image/png',
                                    'image/jpeg',
                                    'image/gif',
                                    'video/mp4',
                                ])
                                ->imageEditor()
                                ->imageEditorEmptyFillColor('Green')
                                ->loadingIndicatorPosition('left')
                                ->removeUploadedFileButtonPosition('right')
                                ->uploadButtonPosition('left')
                                ->uploadProgressIndicatorPosition('left')
                                ->openable()
                                ->uploadingMessage('Uploading Images...')
                                ->minFiles(1)
                                ->maxFiles(1)
                                ->maxSize(50000)
                                ->required(true),
                            Select::make('topic_category')->label('Main Topic')
                                ->required(true)
                                ->options($this->categories),
                            TagsInput::make('relevant_topic')
                                ->reorderable()
                                ->required(true)
                                ->placeholder('New Categories')
                                ->suggestions($this->categories)
                                ->separator(',')
                                ->color('primary'),
                        ]),
                    Wizard\Step::make('News Title & Authors')
                        ->schema([
                            TextInput::make('title')
                                ->required(true),
                            TextInput::make('author')
                                ->required(true),
                            RichEditor::make('author_description')
                                ->toolbarButtons([]),
                            TextInput::make('read_duration')
                                ->numeric()
                                ->required(true),
                            Select::make('remarks')->label('Remark')
                                ->required(true)
                                ->options([
                                    'Normal' => 'Normal',
                                    'Featured' => 'Featured'
                                ]),
                        ]),
                    Wizard\Step::make('News Content')
                        ->schema([
                            Repeater::make('content')
                                ->schema([
                                    TextInput::make('subject'),
                                    Repeater::make('Paragraph')
                                        ->schema([
                                            RichEditor::make('content')->required(true)
                                                ->toolbarButtons([]),
                                        ]),
                                    Repeater::make('Quote')
                                        ->schema([
                                            RichEditor::make('Quote')->required(true)
                                                ->toolbarButtons([]),
                                        ])
                                ])->collapsible()->minItems(1)
                        ]),
                ])
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        try {
            $data = $this->form->getState();

            // Create the news record directly without XSSai validation
            NewsDB::create($data);

            $this->form->fill([]);
            Notification::make()
                ->title('Saved successfully')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Log::error('Error creating news: ' . $e->getMessage());

            Notification::make()
                ->title('Error saving news')
                ->body('An error occurred while saving the news: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(NewsDB::query()->orderByDesc('id'))->poll('10s')
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Image')->size(50),
                Tables\Columns\TextColumn::make('title')->searchable()->label('Title')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime(),
                Tables\Columns\TextColumn::make('topic_category')->label('Categories')
                    ->formatStateUsing(fn($state) => $this->categories[$state] ?? 'Unknown'),
                Tables\Columns\TextColumn::make('content')->label('Content')->limit(100),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('topic_category')->options($this->categories),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->form([
                        Wizard::make([
                            Wizard\Step::make('News Topic')
                                ->schema([
                                    FileUpload::make('image')
                                        ->acceptedFileTypes([
                                            'image/png',
                                            'image/jpeg',
                                            'image/gif',
                                            'video/mp4',
                                        ])
                                        ->imageEditor()
                                        ->imageEditorEmptyFillColor('Green')
                                        ->loadingIndicatorPosition('left')
                                        ->removeUploadedFileButtonPosition('right')
                                        ->uploadButtonPosition('left')
                                        ->uploadProgressIndicatorPosition('left')
                                        ->openable()
                                        ->uploadingMessage('Uploading Images...')
                                        ->minFiles(1)
                                        ->maxFiles(1)
                                        ->maxSize(50000)
                                        ->required(true),
                                    Select::make('topic_category')->label('Main Topic')
                                        ->required(true)
                                        ->options($this->categories),
                                    TagsInput::make('relevant_topic')
                                        ->reorderable()
                                        ->required(true)
                                        ->placeholder('New Categories')
                                        ->suggestions($this->categories)
                                        ->separator(',')
                                        ->color('primary'),
                                ]),
                            Wizard\Step::make('News Title & Authors')
                                ->schema([
                                    TextInput::make('title')
                                        ->required(true),
                                    TextInput::make('author')
                                        ->required(true),
                                    RichEditor::make('author_description')
                                        ->toolbarButtons([]),
                                    TextInput::make('read_duration')
                                        ->numeric()
                                        ->required(true),
                                    Select::make('remarks')->label('Remark')
                                        ->required(true)
                                        ->options([
                                            'Normal' => 'Normal',
                                            'Featured' => 'Featured'
                                        ]),
                                ]),
                            Wizard\Step::make('News Content')
                                ->schema([
                                    Repeater::make('content')
                                        ->schema([
                                            TextInput::make('subject'),
                                            Repeater::make('Paragraph')
                                                ->schema([
                                                    RichEditor::make('content')
                                                        ->toolbarButtons([]),
                                                ]),
                                            Repeater::make('Quote')
                                                ->schema([
                                                    RichEditor::make('Quote')
                                                        ->toolbarButtons([]),
                                                ])
                                        ])->collapsible()->minItems(1)
                                ]),
                        ])
                    ])
                    ->fillForm(function (NewsDB $record): array {
                        return [
                            'image' => $record->image,
                            'topic_category' => $record->topic_category,
                            'relevant_topic' => $record->relevant_topic,
                            'title' => $record->title,
                            'author' => $record->author,
                            'author_description' => $record->author_description,
                            'read_duration' => $record->read_duration,
                            'remarks' => $record->remarks,
                            'topic_category' => $record->topic_category,
                            'relevant_topic' => $record->relevant_topic,
                            'content' => collect($record->content)->map(function ($item) {
                                return [
                                    'subject' => $item['subject'] ?? '',
                                    'Paragraph' => collect($item['Paragraph'] ?? [])->map(fn($p) => [
                                        'content' => $p['content'] ?? '',
                                    ])->toArray(),
                                    'Quote' => collect($item['Quote'] ?? [])->map(fn($q) => [
                                        'Quote' => $q['Quote'] ?? '',
                                    ])->toArray(),
                                ];
                            })->toArray(),
                        ];
                    })
                    ->action(function (NewsDB $record, array $data): void {
                        $record->update($data);

                        Notification::make()
                            ->title('News updated successfully')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Delete Selected News'),
            ]);
    }


    public function render()
    {
        return view('livewire.news');
    }
}
