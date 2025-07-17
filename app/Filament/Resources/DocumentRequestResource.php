<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentRequestResource\Pages;
use App\Filament\Resources\DocumentRequestResource\RelationManagers;
use App\Models\DocumentRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Modal;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Textarea;
use App\Models\User;

class DocumentRequestResource extends Resource
{
    protected static ?string $model = DocumentRequest::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Forms & Requests';
    }
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ->columns([
                TextColumn::make('student_name'),
                TextColumn::make('reason'),
                TextColumn::make('created_by'),
                TextColumn::make('updated_by')
                    ->formatStateUsing(function ($state) {
                        if ($state == Auth::user()->id) {
                            return '(You)';
                        }
                        $Author = User::find(Auth::user()->id)->fisrt();
                        return $Author->LastName . ', ' . $Author->FirstName;
                    }),
                TextColumn::make('document_type')
                    ->label('Document Type')
                    ->formatStateUsing(function ($state) {
                        switch ($state) {
                            case 0:
                                return 'FORM137';
                            case 1:
                                return 'FORM138';
                            case 2:
                                return 'CERTIFICATE OF GOOD MORAL';
                            default:
                                return 'Unknown';
                        }
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
            ])
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('upload_file')
                    ->label(fn($record) => $record->document_type ? 'Upload File' : 'Re Upload File')
                    ->icon(function($record) { if($record->status == 'rejected'){
                        return 'heroicon-o-x-mark';
                    }else{
                        return 'heroicon-o-arrow-up-tray';
                    }})
                    ->outlined(fn($record) => $record->status === 'rejected')
                    ->button()
                    ->disabled(fn($record) => $record->status === 'rejected')
                    ->color(function($record) { if($record->status == 'rejected'){
                        return 'warning';
                    }else{
                        return 'info';
                    }})
                    ->extraAttributes(fn($record) => $record->status !== 'pending' ? ['class' => 'w-full'] : [])
                    ->form([
                        FileUpload::make('document_file')
                            ->acceptedFileTypes(['application/pdf'])
                            ->label('Upload PDF')
                            ->helperText('Please upload a PDF document.')
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $file = $data['document_file'];
                        if ($file) {
                            Storage::disk('public')->put('documents', $file);

                            $record->update([
                                'document_path' => $file,
                                'status' => 'approved',
                                'updated_by' => Auth::user()->id,
                            ]);

                            Notification::make()
                                ->title('Uploaded Successfully')
                                ->body('Document uploaded and status updated to approved.')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Upload Failed')
                                ->body('Unable to upload document. Please try again.')
                                ->danger()
                                ->send();
                        }
                    }),

                Tables\Actions\Action::make('input_rejection_reason')
                    ->label('Rejection')
                    ->button()
                    ->color('danger')
                    ->icon('heroicon-o-pencil')
                    ->visible(fn($record) => $record->status === 'pending')
                    ->modalHeading('Enter Rejection Reason')
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->placeholder('Enter the reason for rejection...')
                            ->rows(4)
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'reason' => $data['rejection_reason'],
                            'updated_by' => Auth::id(),
                            'status' => 'rejected',
                        ]);

                        Notification::make()
                            ->title('Rejection Reason Saved')
                            ->body('The request has been marked as rejected.')
                            ->success()
                            ->send();
                    }),
            ], position: ActionsPosition::BeforeColumns)
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
            'index' => Pages\ListDocumentRequests::route('/'),
            'create' => Pages\CreateDocumentRequest::route('/create'),
            'edit' => Pages\EditDocumentRequest::route('/{record}/edit'),
        ];
    }
}
