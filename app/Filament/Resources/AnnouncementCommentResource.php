<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementCommentResource\Pages;
use App\Filament\Resources\AnnouncementCommentResource\RelationManagers;
use App\Models\announcementComment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnnouncementCommentResource extends Resource
{
    protected static ?string $model = announcementComment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function getNavigationGroup(): ?string
    {
        return 'Comments Management';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('post_id')
                //     ->relationship('announcement', 'title')
                //     ->required()
                //     ->searchable(),
                Forms\Components\Select::make('commentatorId')
                    ->relationship('commentator', 'email')
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('type')
                    ->options([
                        'main' => 'Main',
                        'reply' => 'Reply',
                    ])
                    ->required(),
                Forms\Components\Select::make('reply_to')
                    ->relationship('parent', 'comment')
                    ->nullable()
                    ->searchable(),
                Forms\Components\Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('announcement.title')
                //     ->label('Announcement')
                //     ->sortable()
                //     ->searchable(),
                Tables\Columns\TextColumn::make('commentator.email')
                    ->label('Commentator')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'main' => 'success',
                        'reply' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('comment')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('parent.comment')
                    ->label('Reply To')
                    ->limit(30)
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAnnouncementComments::route('/'),
            'create' => Pages\CreateAnnouncementComment::route('/create'),
            'edit' => Pages\EditAnnouncementComment::route('/{record}/edit'),
        ];
    }
}
