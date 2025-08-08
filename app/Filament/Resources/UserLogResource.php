<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserLogResource\Pages;
use App\Filament\Resources\UserLogResource\RelationManagers;
use App\Models\SystemLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserLogResource extends Resource
{
    protected static ?string $model = SystemLog::class;
    protected static ?int $navigationSort = 999; // ✅ Move to last position

    public static function getNavigationGroup(): ?string
    {
        return 'System Management';
    }
    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')->disabled(),
                Forms\Components\TextInput::make('model_type')->disabled(),
                Forms\Components\TextInput::make('model_id')->disabled(),
                // Forms\Components\Textarea::make('changes')->disabled(),
                Forms\Components\TextInput::make('action')->disabled(),
                Forms\Components\DateTimePicker::make('created_at')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(SystemLog::query()->latest())
            ->columns([
                Tables\Columns\TextColumn::make('user.id')
                    ->label('User')
                    ->formatStateUsing(function ($state, $record) {
                        $user = $record->user;
                        if (!$user) {
                            return 'System';
                        }

                        return "{$user->LastName}, {$user->FirstName} {$user->MiddleName}";
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('model_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model_id')
                    ->searchable()

                    ->placeholder('System'), // For null values
                // Tables\Columns\TextColumn::make('changes'),
                Tables\Columns\TextColumn::make('action')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(), // View details
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUserLogs::route('/'),
            'view' => Pages\UserLogResource\ViewUserLog::route('/{record}'),
            // 'create' => Pages\CreateUserLog::route('/create'),
            // 'edit' => Pages\EditUserLog::route('/{record}/edit'),
        ];
    }
}
