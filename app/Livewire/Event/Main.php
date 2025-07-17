<?php

namespace App\Livewire\Event;

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
use Filament\Forms\Components\Select;
use App\Models\event as event;
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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Notification as Notify;
use App\Notifications\EventCreated;
use App\Models\Notification as CustomNotification;
use App\Models\User;

class Main extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }
    public function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 1,
                'xl' => 2,
                '2xl' => 2,
            ])
            ->schema([
                TextInput::make('event_name')->required(),
                Select::make('event_category')
                    ->label('Event Category')
                    ->options([
                        "Exams & Quizzes" => "Exams & Quizzes",
                        "Science Fair" => "Science Fair",
                        "Math Olympiad" => "Math Olympiad",
                        "Spelling Bee" => "Spelling Bee",
                        "Debate/Essay Contests" => "Debate/Essay Contests",
                        "Parent-Teacher Conferences" => "Parent-Teacher Conferences",
                        "Report Card Distribution" => "Report Card Distribution",
                        "Clubs (e.g., Journalism, Robotics)" => "Clubs (e.g., Journalism, Robotics)",
                        "Student Council Elections" => "Student Council Elections",
                        "Leadership Training" => "Leadership Training",
                        "Educational Field Trips" => "Educational Field Trips",
                        "Intramurals" => "Intramurals",
                        "Sports Fest" => "Sports Fest",
                        "Tryouts and Practice Sessions" => "Tryouts and Practice Sessions",
                        "Cheerleading Competitions" => "Cheerleading Competitions",
                        "P.E. Demonstrations" => "P.E. Demonstrations",
                        "Foundation Day" => "Foundation Day",
                        "Linggo ng Wika" => "Linggo ng Wika",
                        "Buwan ng Sining" => "Buwan ng Sining",
                        "Christmas Program" => "Christmas Program",
                        "School Play or Musical" => "School Play or Musical",
                        "Art Exhibits" => "Art Exhibits",
                        "Cultural Shows" => "Cultural Shows",
                        "Mass or Worship Services" => "Mass or Worship Services",
                        "Retreats & Recollections" => "Retreats & Recollections",
                        "Religious Holidays" => "Religious Holidays",
                        "Moral Instruction Sessions" => "Moral Instruction Sessions",
                        "Medical/Dental Missions" => "Medical/Dental Missions",
                        "Mental Health Week" => "Mental Health Week",
                        "Anti-Bullying Campaigns" => "Anti-Bullying Campaigns",
                        "Nutrition Month" => "Nutrition Month",
                        "Blood Donation Drives" => "Blood Donation Drives",
                        "Tree Planting" => "Tree Planting",
                        "Community Clean-Up Drives" => "Community Clean-Up Drives",
                        "Charity Events" => "Charity Events",
                        "School Caravan" => "School Caravan",
                        "Brigada Eskwela" => "Brigada Eskwela",
                        "General Assembly" => "General Assembly",
                        "Faculty Development" => "Faculty Development",
                        "Student/Parent Orientation" => "Student/Parent Orientation",
                        "Enrollment Days" => "Enrollment Days",
                        "Accreditation Visits" => "Accreditation Visits",
                        "Awarding Ceremonies" => "Awarding Ceremonies",
                        "Recognition Day" => "Recognition Day",
                        "Graduation/Moving-Up" => "Graduation/Moving-Up",
                        "Inter-School Competitions" => "Inter-School Competitions",
                        "Other" => "Other", // important for triggering the custom input
                    ])
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive(),

                TextInput::make('custom_event_category')
                    ->label('Other Category')
                    ->placeholder('Enter your custom category')
                    ->visible(fn($get) => $get('event_category') === 'Other')
                    ->required(fn($get) => $get('event_category') === 'Other'),
                TextInput::make('event_location')->required(),
                DatePicker::make('event_date')->required()->minDate(now()),
                TimePicker::make('event_time')->required(),
                TextInput::make('event_duration')->required(),
                MarkdownEditor::make('event_discription')
                    ->toolbarButtons([
                        'bulletList',
                        'orderedList',
                    ])->required()->columnSpanFull(),
            ])
            ->statePath('data');
    }
    public function create(): void
    {
        $validatedData = $this->form->getState();

        // Save to the database
        $event  = event::create([
            'event_name'        => $validatedData['event_name'],
            'event_category'    => $validatedData['event_category'],
            'event_date'        => $validatedData['event_date'],
            'event_time'        => $validatedData['event_time'],
            'event_duration'    => $validatedData['event_duration'],
            'event_discription' => $validatedData['event_discription'],
            'event_location'    => $validatedData['event_location'],
            // 'created_by'        => Auth::id(), // optional: track creator
        ]);
        // Create custom notification
        CustomNotification::create([
            'category' => 'Event',
            'descriptions' => $event->event_name,
            'user_id_who_already_viewed' => json_encode([]),// initially no users have viewed this notification
            'user_id_who_can_viewed' => json_encode([]),//allow all users to view this notification
            'author_name' => Auth::user()->LastName . ', ' . Auth::user()->FirstName . ' ' . Auth::user()->MiddleName ?? 'System',
            'author_profile' => Auth::user()->profile_picture ?? '/images/default-profile.png',
        ]);
        // Send database notification to all users
        // $users = User::all();
        // Notify::send($users, new EventCreated($event));
        // Optional: reset form
        $this->form->fill([]);
        Notification::make()
            ->title('Event saved successfully!')
            ->success()
            ->send();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(event::query()->latest())
            ->columns([
                TextColumn::make('event_name')->label('Event Name')->searchable()->sortable(),
                TextColumn::make('event_category')->label('Category')->sortable(),
                TextColumn::make('event_date')->label('Date')->date()->sortable(),
                TextColumn::make('event_time')->label('Time'),
                TextColumn::make('event_duration')->label('Duration'),
                TextColumn::make('event_location')->label('Location')->searchable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('event_category')
                    ->label('Filter by Category')
                    ->searchable()
                    ->preload()
                    ->options(
                        collect([
                            "Exams & Quizzes",
                            "Science Fair",
                            "Math Olympiad",
                            "Spelling Bee",
                            "Debate/Essay Contests",
                            "Parent-Teacher Conferences",
                            "Report Card Distribution",
                            "Clubs (e.g., Journalism, Robotics)",
                            "Student Council Elections",
                            "Leadership Training",
                            "Educational Field Trips",
                            "Intramurals",
                            "Sports Fest",
                            "Tryouts and Practice Sessions",
                            "Cheerleading Competitions",
                            "P.E. Demonstrations",
                            "Foundation Day",
                            "Linggo ng Wika",
                            "Buwan ng Sining",
                            "Christmas Program",
                            "School Play or Musical",
                            "Art Exhibits",
                            "Cultural Shows",
                            "Mass or Worship Services",
                            "Retreats & Recollections",
                            "Religious Holidays",
                            "Moral Instruction Sessions",
                            "Medical/Dental Missions",
                            "Mental Health Week",
                            "Anti-Bullying Campaigns",
                            "Nutrition Month",
                            "Blood Donation Drives",
                            "Tree Planting",
                            "Community Clean-Up Drives",
                            "Charity Events",
                            "School Caravan",
                            "Brigada Eskwela",
                            "General Assembly",
                            "Faculty Development",
                            "Student/Parent Orientation",
                            "Enrollment Days",
                            "Accreditation Visits",
                            "Awarding Ceremonies",
                            "Recognition Day",
                            "Graduation/Moving-Up",
                            "Inter-School Competitions"
                        ])->mapWithKeys(fn($item) => [$item => $item])
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->form(function ($record) {
                        return [
                            Grid::make(2)  // 2 columns grid
                                ->schema([
                                    TextInput::make('event_name')
                                        ->label('Event Name')
                                        ->disabled()
                                        ->default($record->event_name),
                                    Select::make('event_category')
                                        ->label('Category')
                                        ->options(
                                            collect([
                                                "Exams & Quizzes",
                                                "Science Fair",
                                                "Math Olympiad",
                                                "Spelling Bee",
                                                "Debate/Essay Contests",
                                                "Parent-Teacher Conferences",
                                                "Report Card Distribution",
                                                "Clubs (e.g., Journalism, Robotics)",
                                                "Student Council Elections",
                                                "Leadership Training",
                                                "Educational Field Trips",
                                                "Intramurals",
                                                "Sports Fest",
                                                "Tryouts and Practice Sessions",
                                                "Cheerleading Competitions",
                                                "P.E. Demonstrations",
                                                "Foundation Day",
                                                "Linggo ng Wika",
                                                "Buwan ng Sining",
                                                "Christmas Program",
                                                "School Play or Musical",
                                                "Art Exhibits",
                                                "Cultural Shows",
                                                "Mass or Worship Services",
                                                "Retreats & Recollections",
                                                "Religious Holidays",
                                                "Moral Instruction Sessions",
                                                "Medical/Dental Missions",
                                                "Mental Health Week",
                                                "Anti-Bullying Campaigns",
                                                "Nutrition Month",
                                                "Blood Donation Drives",
                                                "Tree Planting",
                                                "Community Clean-Up Drives",
                                                "Charity Events",
                                                "School Caravan",
                                                "Brigada Eskwela",
                                                "General Assembly",
                                                "Faculty Development",
                                                "Student/Parent Orientation",
                                                "Enrollment Days",
                                                "Accreditation Visits",
                                                "Awarding Ceremonies",
                                                "Recognition Day",
                                                "Graduation/Moving-Up",
                                                "Inter-School Competitions"
                                            ])->mapWithKeys(fn($item) => [$item => $item])
                                        )
                                        ->disabled()
                                        ->default($record->event_category),
                                    TextInput::make('event_location')
                                        ->label('Location')
                                        ->disabled()
                                        ->default($record->location),
                                    DatePicker::make('event_date')
                                        ->label('Date')
                                        ->disabled()
                                        ->default($record->event_date),
                                    TimePicker::make('event_time')
                                        ->label('Time')
                                        ->disabled()
                                        ->default($record->event_time),
                                    TextInput::make('event_duration')
                                        ->label('Duration')
                                        ->disabled()
                                        ->default($record->event_duration),
                                    MarkdownEditor::make('event_discription')
                                        ->label('Description')
                                        ->disabled()
                                        ->default($record->event_discription)
                                        ->columnSpanFull(),
                                ]),
                        ];
                    })
                    ->modalHeading('View Event Details')
                    ->modalActions([]),

                Tables\Actions\EditAction::make()
                    ->form([
                        Grid::make(2)  // 2-column grid layout
                            ->schema([
                                TextInput::make('event_name')->required(),
                                Select::make('event_category')
                                    ->options(
                                        collect([
                                            "Exams & Quizzes",
                                            "Science Fair",
                                            "Math Olympiad",
                                            "Spelling Bee",
                                            "Debate/Essay Contests",
                                            "Parent-Teacher Conferences",
                                            "Report Card Distribution",
                                            "Clubs (e.g., Journalism, Robotics)",
                                            "Student Council Elections",
                                            "Leadership Training",
                                            "Educational Field Trips",
                                            "Intramurals",
                                            "Sports Fest",
                                            "Tryouts and Practice Sessions",
                                            "Cheerleading Competitions",
                                            "P.E. Demonstrations",
                                            "Foundation Day",
                                            "Linggo ng Wika",
                                            "Buwan ng Sining",
                                            "Christmas Program",
                                            "School Play or Musical",
                                            "Art Exhibits",
                                            "Cultural Shows",
                                            "Mass or Worship Services",
                                            "Retreats & Recollections",
                                            "Religious Holidays",
                                            "Moral Instruction Sessions",
                                            "Medical/Dental Missions",
                                            "Mental Health Week",
                                            "Anti-Bullying Campaigns",
                                            "Nutrition Month",
                                            "Blood Donation Drives",
                                            "Tree Planting",
                                            "Community Clean-Up Drives",
                                            "Charity Events",
                                            "School Caravan",
                                            "Brigada Eskwela",
                                            "General Assembly",
                                            "Faculty Development",
                                            "Student/Parent Orientation",
                                            "Enrollment Days",
                                            "Accreditation Visits",
                                            "Awarding Ceremonies",
                                            "Recognition Day",
                                            "Graduation/Moving-Up",
                                            "Inter-School Competitions"
                                        ])->mapWithKeys(fn($item) => [$item => $item])
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('event_location')->required(),
                                DatePicker::make('event_date')->required(),
                                TimePicker::make('event_time')->required(),
                                TextInput::make('event_duration')->required(),
                                MarkdownEditor::make('event_discription')->toolbarButtons([
                                    'bulletList',
                                    'orderedList',
                                ])->required()->columnSpanFull(),
                            ]),
                    ])
                    ->mutateFormDataUsing(function ($data) {
                        $data['event_location'] = $data['event_location'];
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }



    public function render()
    {
        return view('livewire..event.main');
    }
}
