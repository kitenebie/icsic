<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupResource\Pages;
use App\Models\Group;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Users Management';
    }
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('author_id')
                ->default(fn() => Auth::user()->id),

            Forms\Components\TextInput::make('name')
                ->label('Group Name')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->label('Description')
                ->maxLength(500)
                ->rows(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Group::query()->orderBy('id', 'desc'))
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Group ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('author_full_name')
                    ->label('Author')
                    ->getStateUsing(function ($record) {
                        $middle = $record->author->MiddleName ? ' ' . $record->author->MiddleName : '';
                        return $record->author->LastName . ', ' . $record->author->FirstName . $middle;
                    }),
                Tables\Columns\TextColumn::make('name')
                    ->label('Group Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->date(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('author_id')
                    ->label('Author')
                    ->options(
                        User::where('role', 'admin')->orWhere('role', 'teacher')->get()
                            ->filter(fn($user) => $user->LastName && $user->FirstName)
                            ->mapWithKeys(function ($user) {
                                return [
                                    $user->id => $user->LastName . ', ' . $user->FirstName .
                                        ($user->MiddleName ? ' ' . $user->MiddleName : ''),
                                ];
                            })
                            ->toArray()
                    )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroups::route('/'),
            // 'create' => Pages\CreateGroup::route('/create'),
            // 'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}
