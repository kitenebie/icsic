<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\student as Student;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions;
use Filament\Support\Enums\MaxWidth;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Checkbox;
use Illuminate\Validation\Rules\File;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Enums\ActionsPosition;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Users Management';
    }
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('profile')
                    ->label('Profile Picture')
                    ->image()
                    ->imageEditor()
                    ->directory('students/profiles')
                    ->preserveFilenames()
                    ->columnSpanFull()
                    ->required(),

                TextInput::make('lrn')
                    ->required()
                    ->unique(ignoreRecord: true)->hidden(fn($record) => $record !== null), // Hide on edit

                TextInput::make('firstname')->required(),
                TextInput::make('lastname')->required(),
                TextInput::make('middlename'),
                TextInput::make('extension_name'),
                DatePicker::make('birthday')->required(),
                TextInput::make('permanent_address')->required(),

                Select::make('gender')->options([
                    'Male' => 'Male',
                    'Female' => 'Female',
                    'Other' => 'Other',
                ])->required(),

                TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true)->hidden(fn($record) => $record !== null), // Hide on edit

                TextInput::make('guardian_name')->required(),
                TextInput::make('relationship')->required(),
                TextInput::make('guardian_contact_number')->tel()->required(),
                TextInput::make('guardian_email')->email(),

                Select::make('grade')->options([
                    'Kender' => 'Kender',
                    'Grade 1' => 'Grade 1',
                    'Grade 2' => 'Grade 2',
                    'Grade 3' => 'Grade 3',
                    'Grade 4' => 'Grade 4',
                    'Grade 5' => 'Grade 5',
                    'Grade 6' => 'Grade 6',
                ])->required(),

                Select::make('section')->options([
                    0 => 'N/A',
                    1,
                    2,
                    3,
                    4,
                    5,
                    6
                ])->required(),

                TextInput::make('year_graduated'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\Action::make('UploadExcelFile')
                    ->hidden()
                    ->requiresConfirmation()
                    ->modalHeading('Upload Excel File')
                    ->modalDescription('To upload an Excel file, first download the default template from the system, add your records to it, and then upload the updated file.')
                    ->modalSubmitActionLabel('Download Template')
                    ->color('primary')
                    ->outlined()
                    ->modalIcon('heroicon-o-command-line')
                    ->modalIconColor('primary')
                    ->modalCancelAction(
                        fn(StaticAction $action) =>
                        $action->label('Close')
                    )
                    ->modalSubmitAction(
                        fn(StaticAction $action) =>
                        $action->outlined()
                    )
                    ->badge('not functional')
                    ->badgeColor('warning')
                    ->extraAttributes([
                        'title' => 'Display Only',
                    ])
                    ->extraModalFooterActions([
                        Tables\Actions\Action::make('Upload Template')
                            ->color('primary')
                            ->form([
                                FileUpload::make('upload')
                                    ->label('Upload Excel File format (.xls or .xlsx)')
                                    ->directory('excel/upload')
                                    ->acceptedFileTypes([
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
                                        'application/vnd.ms-excel',                                          // .xls
                                    ])
                                    ->maxSize(2048)
                                    ->required(true)
                                    ->columnSpanFull(),
                            ])
                            ->modalSubmitActionLabel('Upload Now')
                            ->action(function (array $data) {
                                // Code for Upload
                                // You can use $data['upload'] here
                                Notification::make()
                                    ->title('This function is under development')
                                    ->color('warning')
                                    ->send();
                            }),
                    ])
                    ->action(function (array $data) {
                        Notification::make()
                            ->title('Template File is created')
                            ->success()
                            ->body('Click the donwload button')
                            ->actions([
                                NotificationAction::make('download')
                                    // ->url(route('posts.show', $post), shouldOpenInNewTab: true),
                                    ->action(function () {
                                        Notification::make()
                                            ->title('This function is under development')
                                            ->color('warning')
                                            ->send();
                                    })
                                    ->button(),
                                NotificationAction::make('undo')
                                    ->color('gray'),
                            ])
                            ->send();
                    }),
                Tables\Actions\Action::make('CreateStudentRecord')
                    ->modalSubmitActionLabel('Submit Student Record')
                    ->modalCancelAction(fn(StaticAction $action) => $action->label('Cancel'))
                    ->closeModalByClickingAway(false)
                    ->slideOver()
                    ->modalWidth(MaxWidth::FiveExtraLarge)
                    ->badge('+')
                    ->form([
                        Section::make('Learner’s Reference Number')
                            ->description('The Learner’s Reference Number (LRN) must be a 12-digit number.')
                            ->schema([
                                TextInput::make('lrn')
                                    ->unique()
                                    ->label('LRN')
                                    ->prefixIcon('heroicon-m-user-circle')
                                    ->columnSpan(3)->required(true),
                            ])
                            ->columns(4),

                        Section::make('Student Personal Information')
                            ->description('Basic personal details of the learner.')
                            ->schema([
                                FileUpload::make('profile')
                                    ->label('Profile Picture')
                                    ->image()
                                    ->imageEditor()
                                    ->imageCropAspectRatio('1:1')
                                    ->directory('students/profiles')
                                    ->preserveFilenames()
                                    ->columnSpanFull()->required(true),

                                TextInput::make('lastname')->rule('regex:/^[A-Za-z\s]+$/')
                                    ->label('Last Name')
                                    ->prefixIcon('heroicon-m-user-circle')->required(true),

                                TextInput::make('firstname')->rule('regex:/^[A-Za-z\s]+$/')
                                    ->label('First Name')
                                    ->prefixIcon('heroicon-m-user-circle')->required(true),

                                TextInput::make('middlename')->rule('regex:/^[A-Za-z\s]+$/')
                                    ->label('Middle Name')
                                    ->prefixIcon('heroicon-m-user-circle'),

                                TextInput::make('extension_name')->rule('regex:/^[A-Za-z\s]+$/')
                                    ->label('Extension Name')
                                    ->prefixIcon('heroicon-m-user-circle'),

                                DatePicker::make('birthday')
                                    ->label('Birthdate')
                                    ->prefixIcon('heroicon-m-cake')
                                    ->native(false)->required(true),

                                Select::make('gender')
                                    ->label('Gender')
                                    ->options([
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                        'Other' => 'Other',
                                    ])->required(true),

                                TextInput::make('permanent_address')
                                    ->label('Permanent Address')
                                    ->prefixIcon('heroicon-m-map-pin')
                                    ->required(true),

                                TextInput::make('email')->email()
                                    ->label('Email')->unique()
                                    ->prefixIcon('heroicon-m-envelope')
                                    ->required(false),
                            ])
                            ->columns([
                                'sm' => 1,
                                'md' => 1,
                                'lg' => 3,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Section::make('Guardian Information')
                            ->description('Details about the learner’s guardian.')
                            ->schema([
                                TextInput::make('guardian_name')->rule('regex:/^[A-Za-z\s]+$/')
                                    ->label('Guardian’s Name')
                                    ->prefixIcon('heroicon-m-user-circle')->required(true),

                                TextInput::make('relationship')->rule('regex:/^[A-Za-z\s]+$/')
                                    ->label('Relationship with Guardian')
                                    ->prefixIcon('heroicon-m-user-circle')->required(true),

                                TextInput::make('guardian_contact_number')
                                    ->label('Guardian’s Contact Number')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->prefixIcon('heroicon-m-chat-bubble-left-ellipsis')->required(true),

                                TextInput::make('guardian_email')->email()
                                    ->label('Guardian’s Email Address')
                                    ->prefixIcon('heroicon-m-envelope')->required(false),
                            ])
                            ->columns([
                                'sm' => 1,
                                'md' => 1,
                                'lg' => 4,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),

                        Section::make('Education Information')
                            ->description('Previous education background of the learner.')
                            ->schema([
                                Select::make('grade')
                                    ->label('Grade')
                                    ->prefixIcon('heroicon-m-academic-cap')
                                    ->options([
                                        'Kender' => 'Kender',
                                        'Grade 1' => 'Grade 1',
                                        'Grade 2' => 'Grade 2',
                                        'Grade 3' => 'Grade 3',
                                        'Grade 4' => 'Grade 4',
                                        'Grade 5' => 'Grade 5',
                                        'Grade 6' => 'Grade 6',
                                    ])->required(true),

                                Select::make('section')
                                    ->label('Section')
                                    ->prefixIcon('heroicon-m-users')
                                    ->options([
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '5' => '5',
                                        '6' => '6',
                                    ])->required(true),


                                TextInput::make('year_graduated')
                                    ->label('Year Graduated')
                                    ->prefixIcon('heroicon-m-academic-cap')->required(false),
                            ])
                            ->columns([
                                'sm' => 1,
                                'md' => 1,
                                'lg' => 3,
                                'xl' => 3,
                                '2xl' => 3,
                            ]),

                    ])
                    ->action(function (array $data) {
                        $student_data = [
                            'profile' => $data['profile'],
                            'lrn' => $data['lrn'],
                            'birthday' => $data['birthday'],
                            'permanent_address' => $data['permanent_address'],
                            'gender' => $data['gender'],
                            'grade' => $data['grade'],
                            'section' => $data['section'],
                            'email' => $data['email'],
                            'guardian_name' => $data['guardian_name'],
                            'relationship' => $data['relationship'],
                            'guardian_contact_number' => $data['guardian_contact_number'],
                            'guardian_email' => $data['guardian_email'],
                            'year_graduated' => $data['year_graduated'],
                        ];
                        $user_model = [
                            'FirstName' => $data['firstname'],
                            'LastName' => $data['lastname'],
                            'MiddleName' => $data['middlename'],
                            'extension_name' => $data['extension_name'],
                            'email' => $data['email'],
                            'password' => Hash::make($data['lastname'] . $data['lrn']),
                            'lrn' => $data['lrn'],
                            'year_graduated' => $data['year_graduated'],
                            'role' => 'student'
                        ];
                        User::create($user_model);
                        Student::create($student_data);
                        return Notification::make()
                            ->title('Saved successfully')
                            ->icon('heroicon-o-document-text')
                            ->iconColor('success')
                            ->send();
                    })

            ])
            ->columns([
                ImageColumn::make('profile')
                    ->label('Photo')
                    ->circular()
                    ->height(40)
                    ->width(40),

                TextColumn::make('lrn')->label('LRN')->searchable()->sortable(),
                TextColumn::make('firstname')->label('First Name')->searchable()->sortable(),
                TextColumn::make('middlename')->label('Middle Name')->searchable()->sortable(),
                TextColumn::make('lastname')->label('Last Name')->searchable()->sortable()->toggleable(),
                TextColumn::make('extension_name')->label('Ext Name')->searchable()->sortable(),
                TextColumn::make('birthday')->label('Birthday')->date()->sortable(),
                TextColumn::make('age')->label('Age')->sortable(),
                TextColumn::make('permanent_address')->label('Address')->limit(30)->tooltip(fn($record) => $record->permanent_address),
                TextColumn::make('gender')->label('Gender')->sortable(),

                TextColumn::make('grade')->label('Grade')->sortable()->toggleable(),
                TextColumn::make('section')->label('Section')->sortable()->toggleable(),

                TextColumn::make('guardian_name')->label('Guardian')->toggleable(),
                TextColumn::make('relationship')->label('Relation')->toggleable(),
                TextColumn::make('guardian_contact_number')->label('Contact')->toggleable(),
                TextColumn::make('guardian_email')->label('Email')->toggleable(),
                TextColumn::make('year_graduated')->label('Graduated')->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Other' => 'Other',
                    ])
                    ->label('Gender'),

                Tables\Filters\SelectFilter::make('grade')
                    ->options([
                        'Kender' => 'Kender',
                        'Grade 1' => 'Grade 1',
                        'Grade 2' => 'Grade 2',
                        'Grade 3' => 'Grade 3',
                        'Grade 4' => 'Grade 4',
                        'Grade 5' => 'Grade 5',
                        'Grade 6' => 'Grade 6',
                    ])
                    ->label('Grade'),

                Tables\Filters\SelectFilter::make('year_graduated')
                    ->options(
                        fn() => Student::query()
                            ->whereNotNull('year_graduated')
                            ->distinct()
                            ->pluck('year_graduated', 'year_graduated')
                            ->toArray()
                    )
                    ->label('Year Graduated')
                    ->searchable(),
            ])
            ->actions([
                // The Edit Action
                Tables\Actions\Action::make('Edit')
                    ->label('Edit Student')
                    ->modalHeading('Update Student Information')
                    ->modalDescription('Modify the details of the student profile.')
                    ->modalSubmitActionLabel('Save Changes')
                    ->modalWidth(MaxWidth::FiveExtraLarge)
                    ->slideOver()
                    ->form([
                        Section::make('Learner’s Reference Number')
                            ->description('The Learner’s Reference Number (LRN) must be a 12-digit number.')
                            ->schema([
                                TextInput::make('lrn')
                                    ->label('LRN')
                                    ->prefixIcon('heroicon-m-user-circle')
                                    ->columnSpan(3)
                                    ->unique()
                                    ->required(true)
                                    ->readOnly() // Disable if LRN should not be edited
                            ])
                            ->columns(4),

                        Section::make('Personal Information')
                            ->description('Basic personal details of the learner.')
                            ->schema([
                                FileUpload::make('profile')
                                    ->label('Profile Picture')
                                    ->image()
                                    ->imageEditor()
                                    ->imageCropAspectRatio('1:1')
                                    ->directory('students/profiles')
                                    ->preserveFilenames()
                                    ->columnSpanFull()
                                    ->required(false),

                                TextInput::make('lastname')
                                    ->label('Last Name')
                                    ->prefixIcon('heroicon-m-user-circle')
                                    ->required(true),

                                TextInput::make('firstname')
                                    ->label('First Name')
                                    ->prefixIcon('heroicon-m-user-circle')
                                    ->required(true),

                                TextInput::make('middlename')
                                    ->label('Middle Name')
                                    ->prefixIcon('heroicon-m-user-circle')
                                    ->required(false),

                                TextInput::make('extension_name')
                                    ->label('Extension Name')
                                    ->prefixIcon('heroicon-m-user-circle')
                                    ->required(false),

                                DatePicker::make('birthday')
                                    ->label('Birthdate')
                                    ->prefixIcon('heroicon-m-cake')
                                    ->native(false)
                                    ->required(true),

                                Select::make('gender')
                                    ->label('Gender')
                                    ->options([
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                        'Other' => 'Other',
                                    ])
                                    ->required(true),

                                TextInput::make('permanent_address')
                                    ->label('Permanent Address')
                                    ->prefixIcon('heroicon-m-map-pin')
                                    ->required(true)
                                    ->suffixAction(
                                        Action::make('SelectFromTheMap')
                                            ->icon('heroicon-m-globe-americas')
                                            ->action(function () {
                                                // Optional map logic here
                                            })
                                    ),

                                TextInput::make('email')
                                    ->email()
                                    ->label('Email')
                                    ->unique()
                                    ->prefixIcon('heroicon-m-envelope')
                                    ->required(true),
                            ])
                            ->columns(4),

                        Section::make('Guardian Information')
                            ->description('Details about the learner’s guardian.')
                            ->schema([
                                TextInput::make('guardian_name')
                                    ->label('Guardian’s Name')
                                    ->prefixIcon('heroicon-m-user-circle')
                                    ->required(true),

                                TextInput::make('relationship')
                                    ->label('Relationship with Guardian')
                                    ->prefixIcon('heroicon-m-user-circle')
                                    ->required(true),

                                TextInput::make('guardian_contact_number')
                                    ->label('Guardian’s Contact Number')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->prefixIcon('heroicon-m-chat-bubble-left-ellipsis')
                                    ->required(true),

                                TextInput::make('guardian_email')
                                    ->email()
                                    ->label('Guardian’s Email Address')
                                    ->prefixIcon('heroicon-m-envelope')
                                    ->required(false),
                            ])
                            ->columns(4),

                        Section::make('Education Information')
                            ->description('Previous education background of the learner.')
                            ->schema([

                                Select::make('grade')
                                    ->label('Grade')
                                    ->prefixIcon('heroicon-m-academic-cap')
                                    ->options([
                                        'Kender' => 'Kender',
                                        'Grade 1' => 'Grade 1',
                                        'Grade 2' => 'Grade 2',
                                        'Grade 3' => 'Grade 3',
                                        'Grade 4' => 'Grade 4',
                                        'Grade 5' => 'Grade 5',
                                        'Grade 6' => 'Grade 6',
                                    ])->required(true),

                                Select::make('section')
                                    ->label('Section')
                                    ->prefixIcon('heroicon-m-users')
                                    ->options([
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '5' => '5',
                                        '6' => '6',
                                    ])->required(true),


                                TextInput::make('year_graduated')
                                    ->label('Year Graduated')
                                    ->prefixIcon('heroicon-m-academic-cap')
                                    ->required(false),
                            ])
                            ->columns(4),
                    ])
                    ->fillForm(fn(Student $record): array => [
                        'lrn' => $record->lrn,
                        'profile' => $record->profile,
                        'firstname' => $record->firstname,
                        'lastname' => $record->lastname,
                        'middlename' => $record->middlename,
                        'extension_name' => $record->extension_name,
                        'birthday' => $record->birthday,
                        'gender' => $record->gender,
                        'permanent_address' => $record->permanent_address,
                        'email' => $record->user_email,
                        'guardian_name' => $record->guardian_name,
                        'relationship' => $record->relationship,
                        'guardian_contact_number' => $record->guardian_contact_number,
                        'guardian_email' => $record->guardian_email,
                        'grade' => $record->grade,
                        'section' => $record->section,
                        'year_graduated' => $record->year_graduated,
                    ])
                    ->action(function (array $data, Student $studentModel): void {
                        // Update the student data
                        // dd($data);
                        $studentModel->update([
                            'profile' => $data['profile'],
                            'lrn' => $data['lrn'],
                            'birthday' => $data['birthday'],
                            'gender' => $data['gender'],
                            'permanent_address' => $data['permanent_address'],
                            'email' => $data['email'],
                            'guardian_name' => $data['guardian_name'],
                            'relationship' => $data['relationship'],
                            'guardian_contact_number' => $data['guardian_contact_number'],
                            'guardian_email' => $data['guardian_email'],
                            'grade' => $data['grade'],
                            'section' => $data['section'],
                            'year_graduated' => $data['year_graduated'],
                        ]);
                        User::where('lrn', $data['lrn'])->update([
                            'FirstName' => $data['firstname'],
                            'LastName' => $data['lastname'],
                            'MiddleName' => $data['middlename'],
                            'extension_name' => $data['extension_name'],
                            'email' => $data['email'],
                            'year_graduated' => $data['year_graduated'],
                        ]);
                    })
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->leftJoin('users', 'students.lrn', '=', 'users.lrn')
            ->select([
                'students.id',
                'users.id as userId',
                'users.FirstName as firstname',
                'users.LastName as lastname',
                'users.MiddleName as middlename',
                'users.extension_name',
                'users.email as user_email',
                'students.lrn',
                'students.profile',
                'students.birthday',
                'students.permanent_address',
                'students.gender',
                'students.grade',
                'students.section',
                'students.guardian_name',
                'students.relationship',
                'students.guardian_contact_number',
                'students.guardian_email',
            ]);
    }


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            // 'create' => Pages\CreateStudent::route('/create'),
            // 'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
