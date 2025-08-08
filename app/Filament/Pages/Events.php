<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Events extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';
public static function getNavigationGroup(): ?string
{
    return 'Communication';
}
    protected static string $view = 'filament.pages.events';

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin'; // or use ->isAdmin()
    }
}
