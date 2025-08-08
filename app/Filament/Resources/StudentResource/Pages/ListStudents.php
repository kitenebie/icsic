<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Actions\StaticAction;


class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
        //     Actions\Action::make('sendEmail')
        //         ->form([
        //             Section::make('Learner’s Reference Number')
        //                 ->description('The Learner’s Reference Number (LRN) must be a 12-digit number.')
        //                 ->schema([
        //                     TextInput::make('lrn')
        //                         ->label('LRN')
        //                         ->prefixIcon('heroicon-m-user-circle')
        //                         ->columnSpan(3),
        //                 ])
        //                 ->columns(4),
    
        //             Section::make('Student Personal Information')
        //                 ->description('Basic personal details of the learner.')
        //                 ->schema([
        //                     FileUpload::make('profile')
        //                         ->label('Profile Picture')
        //                         ->image()
        //                         ->imageEditor()
        //                         ->imageCropAspectRatio('1:1')
        //                         ->directory('students/profiles')
        //                         ->preserveFilenames()
        //                         ->columnSpanFull(),
    
        //                     TextInput::make('lastname')
        //                         ->label('Last Name')
        //                         ->prefixIcon('heroicon-m-user-circle'),
    
        //                     TextInput::make('firstname')
        //                         ->label('First Name')
        //                         ->prefixIcon('heroicon-m-user-circle'),
    
        //                     TextInput::make('middlename')
        //                         ->label('Middle Name')
        //                         ->prefixIcon('heroicon-m-user-circle'),
    
        //                     TextInput::make('extension_name')
        //                         ->label('Extension Name')
        //                         ->prefixIcon('heroicon-m-user-circle'),
    
        //                     DatePicker::make('birthday')
        //                         ->label('Birthdate')
        //                         ->prefixIcon('heroicon-m-cake')
        //                         ->native(false),
    
        //                     Select::make('gender')
        //                         ->label('Gender')
        //                         ->options([
        //                             'Male' => 'Male',
        //                             'Female' => 'Female',
        //                             'Other' => 'Other',
        //                         ]),
    
        //                     TextInput::make('permanent_address')
        //                         ->label('Permanent Address')
        //                         ->prefixIcon('heroicon-m-map-pin')
        //                         ->suffixAction(
        //                             Action::make('SelectFromTheMap')
        //                                 ->icon('heroicon-m-globe-americas')
        //                                 ->action(function () {
        //                                     // Optional map logic here
        //                                 })
        //                         )->columnSpan(2),
        //                 ])
        //                 ->columns([
        //                     'sm' => 1,
        //                     'md' => 1,
        //                     'lg' => 3,
        //                     'xl' => 4,
        //                     '2xl' => 6,
        //                 ]),
    
        //             Section::make('Guardian Information')
        //                 ->description('Details about the learner’s guardian.')
        //                 ->schema([
        //                     TextInput::make('guardian_name')
        //                         ->label('Guardian’s Name')
        //                         ->prefixIcon('heroicon-m-user-circle'),
    
        //                     TextInput::make('relationship')
        //                         ->label('Relationship with Guardian')
        //                         ->prefixIcon('heroicon-m-user-circle'),
    
        //                     TextInput::make('guardian_contact_number')
        //                         ->label('Guardian’s Contact Number')
        //                         ->prefixIcon('heroicon-m-user-circle'),
    
        //                     TextInput::make('guardian_email')
        //                         ->label('Guardian’s Email Address')
        //                         ->prefixIcon('heroicon-m-envelope'),
        //                 ])
        //                 ->columns([
        //                     'sm' => 1,
        //                     'md' => 1,
        //                     'lg' => 4,
        //                     'xl' => 4,
        //                     '2xl' => 4,
        //                 ]),
    
        //             Section::make('Education Information')
        //                 ->description('Previous education background of the learner.')
        //                 ->schema([
        //                     TextInput::make('grade')
        //                         ->label('Grade')
        //                         ->prefixIcon('heroicon-m-academic-cap'),
    
        //                     TextInput::make('section')
        //                         ->label('Section')
        //                         ->prefixIcon('heroicon-m-users'),
    
        //                     TextInput::make('year_graduated')
        //                         ->label('Year Graduated')
        //                         ->prefixIcon('heroicon-m-academic-cap'),
        //                 ])
        //                 ->columns([
        //                     'sm' => 1,
        //                     'md' => 1,
        //                     'lg' => 3,
        //                     'xl' => 3,
        //                     '2xl' => 6,
        //                 ]),
                
        //         ])
        //         ->action(function (array $data) {
                    
        //         })
        //         ->slideOver()
        //         ->modalWidth(MaxWidth::FiveExtraLarge)
        //         ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
            ];
    }
}
