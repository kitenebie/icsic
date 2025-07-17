<?php

namespace App\Filament\Resources\UserLogResource\Pages\UserLogResource;

use App\Filament\Resources\UserLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;

class ViewUserLog extends ViewRecord
{
    protected static string $resource = UserLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('close')
                ->label('Close')
                ->color('danger')
                ->url($this->getResource()::getUrl('index'))
                ->icon('heroicon-o-x-mark')
                ->outlined(),
        ];
    }

    public function getInfolist(string $name): ?Infolist
    {
        $rawChanges = $this->record->changes ?? '{}';
        $changes = is_array($rawChanges) ? $rawChanges : json_decode($rawChanges, true);

        $output = '';

        if (isset($changes['new']) && isset($changes['old'])) {
            foreach ($changes['new'] as $key => $newValue) {
                $oldValue = $changes['old'][$key] ?? '(empty)';

                if ($oldValue === $newValue) {
                    continue;
                }

                $label = ucwords(str_replace('_', ' ', $key));
                $output .= "- **{$label}**: {$oldValue} ➡️🆕 {$newValue}\n";
            }
        } elseif (isset($changes['new'])) {
            $output .= "**Created Record:**\n";
            foreach ($changes['new'] as $key => $value) {
                $label = ucwords(str_replace('_', ' ', $key));
                $output .= "- **{$label}**: 🆕 {$value}\n";
            }
        } elseif (isset($changes['old'])) {
            $output .= "**Deleted Record:**\n";
            foreach ($changes['old'] as $key => $value) {
                $label = ucwords(str_replace('_', ' ', $key));
                $output .= "- **{$label}**: ❌ {$value}\n";
            }
        }

        return Infolist::make()
            ->record($this->record)
            ->schema([
                Section::make('Log Details')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('User')
                            ->default('System'),
                        TextEntry::make('action')
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'created' => 'success',
                                'updated' => 'warning',
                                'deleted' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('model_type')->label('Model Type'),
                        TextEntry::make('model_id')->label('Model ID'),
                        TextEntry::make('created_at')->label('Timestamp')->dateTime(),

                        TextEntry::make('changes')
                            ->label('Changes')
                            ->markdown()
                            ->columnSpan(2)
                            ->state($output ?: 'No changes found.'),
                    ]),
            ]);
    }
}
