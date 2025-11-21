<?php

namespace App\Filament\Resources\ReportCommentsResource\Pages;

use App\Filament\Resources\ReportCommentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportComments extends ListRecords
{
    protected static string $resource = ReportCommentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
