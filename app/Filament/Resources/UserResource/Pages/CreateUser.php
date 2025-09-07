<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Draft restore action
            Actions\Action::make('restoreDraft')
                ->label('Restore Draft')
                ->icon('heroicon-o-document-text')
                ->color('info')
                ->visible(function () {
                    // Check if draft exists in localStorage (client-side check)
                    return true; // We'll handle visibility with JavaScript
                })
                ->action(function () {
                    // This will be handled by JavaScript
                })
                ->extraAttributes([
                    'x-show' => 'false',
                    'id' => 'userDraftAction',
                    'x-init' => "
                        let saved = JSON.parse(localStorage.getItem('userDraft') ?? '{}');
                        if (Object.keys(saved).length > 0) {
                            \$el.style.display = 'inline-flex';
                        }
                    ",
                    'x-on:click' => "
                        let saved = JSON.parse(localStorage.getItem('userDraft') ?? '{}');
                        if (Object.keys(saved).length > 0) {
                            if (confirm('A saved draft was found. Do you want to restore it?')) {
                                for (let key in saved) {
                                    if (saved[key] !== null && saved[key] !== undefined) {
                                        \$wire.set('data.' + key, saved[key]);
                                    }
                                }
                                localStorage.removeItem('userDraft');
                                \$el.style.display = 'none';
                            }
                        }
                    "
                ]),
        ];
    }
}
