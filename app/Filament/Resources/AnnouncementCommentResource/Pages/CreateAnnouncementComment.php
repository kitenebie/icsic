<?php

namespace App\Filament\Resources\AnnouncementCommentResource\Pages;

use App\Filament\Resources\AnnouncementCommentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAnnouncementComment extends CreateRecord
{
    protected static string $resource = AnnouncementCommentResource::class;
}
