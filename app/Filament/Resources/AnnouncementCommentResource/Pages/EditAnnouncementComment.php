<?php

namespace App\Filament\Resources\AnnouncementCommentResource\Pages;

use App\Filament\Resources\AnnouncementCommentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnnouncementComment extends EditRecord
{
    protected static string $resource = AnnouncementCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
