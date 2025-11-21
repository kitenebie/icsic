<?php

namespace App\Filament\Resources\ReportCommentsResource\Pages;

use App\Filament\Resources\ReportCommentsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportComments extends EditRecord
{
    protected static string $resource = ReportCommentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
