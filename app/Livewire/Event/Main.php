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
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Grid;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Notification as Notify;
use App\Notifications\EventCreated;
use App\Models\Notification as CustomNotification;
use App\Models\User;

class Main extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?array $data = [];
    public $currentMonth;
    public $currentYear;
    public $viewMode = 'month'; // 'month' or 'week'
    public $selectedDate = null;
    public $searchQuery = '';

    // Full-screen image modal properties
    public $showImageModal = false;
    public $currentImageIndex = 0;
    public $modalImages = [];

    // Edit modal property
    public $showEditModal = false;
    public $editingEventId = null;

    // Bulk selection properties
    public $selectedEvents = [];
    public $selectAll = false;

    public function mount(): void
    {
        $this->form->fill();
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }
    public function form(Form $form): Form
    {
        return $form
            ->extraAttributes([
                'x-data' => '{}',
                'x-init' => "
                let saved = JSON.parse(localStorage.getItem('eventsDraft') ?? '{}');
                
                if (Object.keys(saved).length > 0) {
                    if (confirm('A saved draft was found. Do you want to restore it?')) {
                        for (let key in saved) {
                            if (saved[key] !== null && saved[key] !== undefined) {
                                \$wire.set('data.' + key, saved[key]);
                            }
                        }
                    } else {
                        localStorage.removeItem('eventsDraft');
                    }
                }

                \$watch('\$wire.data', value => {
                    localStorage.setItem('eventsDraft', JSON.stringify(value));
                });
            ",
            ])
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
                DatePicker::make('event_date')->required(),
                TimePicker::make('event_time')->required(),
                TextInput::make('event_duration')->required(),
                FileUpload::make('event_images')
                    ->label('Event Images')
                    ->image()
                    ->multiple()
                    ->maxFiles(15)
                    ->directory('events')
                    ->visibility('public')
                    ->imageEditor()
                    ->reorderable()
                    ->columnSpanFull(),

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
            'event_images'      => $validatedData['event_images'] ?? null,
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

    public function editEvent($eventId): void
    {
        $event = event::findOrFail($eventId);

        $this->form->fill([
            'event_name' => $event->event_name,
            'event_category' => $event->event_category,
            'event_location' => $event->event_location,
            'event_date' => $event->event_date,
            'event_time' => $event->event_time,
            'event_duration' => $event->event_duration,
            'event_images' => $event->event_images,
            'event_discription' => $event->event_discription,
        ]);
        $this->dispatch('open-modal', id: 'open-modal-edit');
        $this->editingEventId = $eventId;
        $this->showEditModal = true;
    }

    public function update(): void
    {
        if (!$this->editingEventId) {
            Notification::make()
                ->title('No event selected for editing')
                ->error()
                ->send();
            return;
        }

        $validatedData = $this->form->getState();

        $event = event::findOrFail($this->editingEventId);

        $event->update([
            'event_name'        => $validatedData['event_name'],
            'event_category'    => $validatedData['event_category'],
            'event_date'        => $validatedData['event_date'],
            'event_time'        => $validatedData['event_time'],
            'event_duration'    => $validatedData['event_duration'],
            'event_discription' => $validatedData['event_discription'],
            'event_location'    => $validatedData['event_location'],
            'event_images'      => $validatedData['event_images'] ?? $event->event_images,
        ]);

        // Reset form and close modal
        $this->form->fill([]);
        $this->showEditModal = false;
        $this->editingEventId = null;

        Notification::make()
            ->title('Event updated successfully!')
            ->success()
            ->send();
    }

    public function toggleEventSelection($eventId): void
    {
        if (in_array($eventId, $this->selectedEvents)) {
            $this->selectedEvents = array_diff($this->selectedEvents, [$eventId]);
        } else {
            $this->selectedEvents[] = $eventId;
        }

        $this->updateSelectAllState();
    }

    public function toggleSelectAll(): void
    {
        if ($this->selectAll) {
            $this->selectedEvents = [];
            $this->selectAll = false;
        } else {
            $selectedDateEvents = $this->selectedDate ? $this->getEventsForDate($this->selectedDate) : collect();
            $this->selectedEvents = $selectedDateEvents->pluck('id')->toArray();
            $this->selectAll = true;
        }
    }

    public function deleteSelectedEvents(): void
    {
        if (empty($this->selectedEvents)) {
            Notification::make()
                ->title('No events selected')
                ->warning()
                ->send();
            return;
        }

        $eventsToDelete = event::whereIn('id', $this->selectedEvents)->get();

        foreach ($eventsToDelete as $event) {
            // Delete associated images if they exist
            if ($event->event_images) {
                foreach ($event->event_images as $image) {
                    $imagePath = storage_path('app/public/' . $image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
            $event->delete();
        }

        $this->selectedEvents = [];
        $this->selectAll = false;

        Notification::make()
            ->title('Selected events deleted successfully!')
            ->success()
            ->send();
    }

    private function updateSelectAllState(): void
    {
        if (!$this->selectedDate) {
            $this->selectAll = false;
            return;
        }

        $selectedDateEvents = $this->getEventsForDate($this->selectedDate);
        $totalEvents = $selectedDateEvents->count();
        $selectedCount = count($this->selectedEvents);

        $this->selectAll = $totalEvents > 0 && $selectedCount === $totalEvents;
    }

    // Calendar Navigation Methods
    public function previousMonth()
    {
        if ($this->currentMonth == 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }
    }

    public function nextMonth()
    {
        if ($this->currentMonth == 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }
    }

    public function goToToday()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedDate = now()->format('Y-m-d');
    }

    public function switchView($view)
    {
        $this->viewMode = $view;
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }

    public function getEventsForDate($date)
    {
        $query = event::whereDate('event_date', $date);

        if (!empty($this->searchQuery)) {
            $query->where(function($q) {
                $q->where('event_name', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('event_category', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('event_location', 'like', '%' . $this->searchQuery . '%');
            });
        }

        return $query->get();
    }

    public function getCalendarDays()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $date->daysInMonth;
        $firstDayOfWeek = $date->copy()->startOfMonth()->dayOfWeek;

        $days = [];

        // Add empty cells for days before the first day of the month
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $days[] = null;
        }

        // Add days of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = Carbon::create($this->currentYear, $this->currentMonth, $day);
            $events = $this->getEventsForDate($currentDate->format('Y-m-d'));

            $days[] = [
                'day' => $day,
                'date' => $currentDate->format('Y-m-d'),
                'events' => $events,
                'is_today' => $currentDate->isToday(),
                'is_selected' => $this->selectedDate === $currentDate->format('Y-m-d'),
            ];
        }

        return $days;
    }

    // Image Modal Methods
    public function openImageModal($images, $startIndex = 0)
    {
        $this->modalImages = $images;
        $this->currentImageIndex = $startIndex;
        $this->showImageModal = true;
    }

    public function closeImageModal()
    {
        $this->showImageModal = false;
        $this->modalImages = [];
        $this->currentImageIndex = 0;
    }

    public function nextImage()
    {
        if ($this->currentImageIndex < count($this->modalImages) - 1) {
            $this->currentImageIndex++;
        }
    }

    public function previousImage()
    {
        if ($this->currentImageIndex > 0) {
            $this->currentImageIndex--;
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(event::query()->latest())
            ->columns([
                TextColumn::make('event_name')->label('Event Name')->searchable()->sortable(),
                TextColumn::make('event_category')->label('Category')->sortable(),
                ImageColumn::make('event_images')->label('Images')->circular()->stacked(),
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
                                    FileUpload::make('event_images')
                                        ->label('Event Images')
                                        ->disabled()
                                        ->default($record->event_images),
            
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
                                FileUpload::make('event_images')
                                    ->label('Event Images')
                                    ->image()
                                    ->multiple()
                                    ->maxFiles(15)
                                    ->directory('events')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->reorderable(),

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



    public function render(): View
    {
        return view('livewire.event.main', [
            'calendarDays' => $this->getCalendarDays(),
            'monthName' => Carbon::create($this->currentYear, $this->currentMonth)->format('F'),
            'year' => $this->currentYear,
            'selectedDateEvents' => $this->selectedDate ? $this->getEventsForDate($this->selectedDate) : collect(),
        ]);
    }
}
