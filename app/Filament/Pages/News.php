<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class News extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
public static function getNavigationGroup(): ?string
{
    return 'Communication';
}
    protected static string $view = 'filament.pages.news';
    
    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin'; // or use ->isAdmin()
    }
}
