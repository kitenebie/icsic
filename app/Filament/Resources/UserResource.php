<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Group;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\ActionGroup;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    public static function getNavigationGroup(): ?string
    {
        return 'Users Management';
    }

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('FirstName')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->reactive()
                    ->placeholder('Enter first name'),
                TextInput::make('MiddleName')
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->placeholder('Enter middle name'),
                TextInput::make('LastName')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->reactive()
                    ->placeholder('Enter last name'),
                TextInput::make('extension_name')
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->placeholder('Enter ext name'),
                TextInput::make('contact')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->placeholder('Enter contact number'),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->placeholder('Enter email address'),
                TextInput::make('password')
                    ->hidden()
                    //create a generated password the value of lastname + first letter of firstname + 1234
                    ->default(fn(callable $get) => strtolower($get('LastName') . substr($get('FirstName'), 0, 1) . '1234'))
                    ->password()
                    ->maxLength(255),
                Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'teacher' => 'Teacher',
                        'perent' => 'Parent',
                        'staff' => 'Staff',
                    ])
                    ->default('student')
                    ->required()
                    ->columnSpanFull()
                    ->placeholder('Select user role')
                    ->reactive(), // Make it reactive so it can trigger changes in dependent fields

                Select::make('grade')
                    ->label('Grade')
                    ->options([
                        'Kender' => 'Kender',
                        'Grade 1' => 'Grade 1',
                        'Grade 2' => 'Grade 2',
                        'Grade 3' => 'Grade 3',
                        'Grade 4' => 'Grade 4',
                        'Grade 5' => 'Grade 5',
                        'Grade 6' => 'Grade 6',
                    ])
                    ->required()
                    ->hidden(fn(callable $get) => $get('role') !== 'teacher') // Hide if not teacher
                    ->reactive(),

                Select::make('section')
                    ->label('Section')
                    ->options([
                        0 => 'N/A',
                        1,
                        2,
                        3,
                        4,
                        5,
                        6,
                    ])
                    ->required()
                    ->hidden(fn(callable $get) => $get('role') !== 'teacher') // Hide if not teacher
                    ->reactive(),
                Select::make('Status')
                    ->options([
                        1 => true
                    ])
                    ->default(1)
                    ->required()
                    ->hidden()
                    ->columnSpanFull()
                    ->placeholder('Select user Status'),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->query(User::query()->whereNot('role', 'student'))
            ->deferLoading()
            ->poll(interval: '5s')
            ->description('Manage your users here.')
            ->striped()
            ->reorderRecordsTriggerAction(
                fn(Action $action, bool $isReordering) => $action
                    ->button()
                    ->label($isReordering ? 'Disable reordering' : 'Enable reordering'),
            )
            ->queryStringIdentifier('users')
            ->columns([
                TextColumn::make('LastName'),
                TextColumn::make('FirstName'),
                TextColumn::make('MiddleName'),
                TextColumn::make('extension_name'),
                TextColumn::make('contact'),
                TextColumn::make('grade'),
                TextColumn::make('section'),
                TextColumn::make('contact'),
                TextColumn::make('email'),
                TextColumn::make('role'),
                TextColumn::make('user_group'),
                TextColumn::make('year_graduated')
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Filter by Role')
                    ->options([
                        'admin' => 'Admin',
                        'parent' => 'Parent',
                        'pending' => 'Pending',
                        'staff' => 'Staff',
                        'teacher' => 'Teacher',
                    ])
            ], layout: FiltersLayout::AboveContent)
            ->actions(
                ActionGroup::make([
                    Tables\Actions\EditAction::make('Edit')->button(),
                    Tables\Actions\DeleteAction::make()->button(),
                    Tables\Actions\Action::make('Reject')->label('Reject')
                        ->button()
                        ->color('warning')->action(function (User $record) {
                            $record->update(['role' => 'rejected']);
                            Notification::make()
                                ->title('Successfully rejected user')
                                ->success()
                                ->send();
                        })->icon('heroicon-m-x-circle'),
                    Tables\Actions\Action::make('Approve')->label('Approve')
                        ->button()
                        ->color('success')->action(function (User $record) {
                            $record->update(['status' => true]);
                            Notification::make()
                                ->title('Successfully approved user')
                                ->success()
                                ->send();
                        })->icon('heroicon-m-check-circle'),
                    Tables\Actions\ViewAction::make()->button()->color('info'),
                ])
                    ->dropdownPlacement('top-start')
                    ->label('More actions')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::ExtraSmall)
                    ->color('warning')
                    ->dropdownOffset(16)
                    ->dropdownWidth(MaxWidth::ExtraSmall)
                    ->button(),
                position: ActionsPosition::BeforeColumns
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('assignGroups')
                        ->label('Assign Groups')
                        ->icon('heroicon-o-users')
                        ->form([
                            Select::make('groups')
                                ->label('Select Groups')
                                ->multiple()
                                ->options(Group::all()->pluck('name', 'id'))
                                ->searchable()
                                ->required(),
                        ])
                        ->action(function ($records, $data) {
                            foreach ($records as $record) {
                                $record->user_group = array_unique(array_merge($record->user_group ?? [], $data['groups']));
                                $record->save();
                            }
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->modalHeading('Assign Groups to Selected Users'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
