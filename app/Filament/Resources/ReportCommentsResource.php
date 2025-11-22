<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportCommentsResource\Pages;
use App\Filament\Resources\ReportCommentsResource\RelationManagers;
use App\Models\ReportComments;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportCommentsResource extends Resource
{
    protected static ?string $model = ReportComments::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Comments Management';
    }

    public static function canViewNavigation(): bool
    {
        return Filament::auth()->user()->role === 'admin';
    }

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('user'))
            ->columns([
                Tables\Columns\TextColumn::make('user.FirstName')
                    ->label('Reported By')
                    ->formatStateUsing(fn ($state, $record) => $record->user ? $record->user->FirstName . ' ' . $record->user->LastName : 'Unknown'),
                Tables\Columns\TextColumn::make('comment_type')
                    ->label('Type')
                    ->badge(),
                Tables\Columns\TextColumn::make('comment_content')
                    ->label('Comment Content')
                    ->state(function ($record) {
                        return $record->getCommentContent();
                    })
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->getCommentContent();
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reported At')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('delete_comment')
                    ->label('Delete Comment')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (ReportComments $record) {
                        $commentType = $record->comment_type;
                        $commentId = $record->comment_id;

                        if ($commentType === 'announcement') {
                            $comment = \App\Models\announcementComment::find($commentId);
                        } elseif ($commentType === 'news') {
                            $comment = \App\Models\newsComment::find($commentId);
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Error')
                                ->body('Invalid comment type.')
                                ->danger()
                                ->send();
                            return;
                        }

                        if (!$comment) {
                            \Filament\Notifications\Notification::make()
                                ->title('Error')
                                ->body('Comment not found.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $comment->delete();
                        $record->delete();

                        \Filament\Notifications\Notification::make()
                            ->title('Success')
                            ->body('Comment and report deleted successfully.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Remove Selected Reports'),
                ])->label('Invalidate Comments'),
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
            'index' => Pages\ListReportComments::route('/'),
            // 'create' => Pages\CreateReportComments::route('/create'),
            // 'edit' => Pages\EditReportComments::route('/{record}/edit'),
        ];
    }
}
