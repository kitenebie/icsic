<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
//use Auth
use Illuminate\Support\Facades\Auth;
class Announcements extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
public static function getNavigationGroup(): ?string
{
    return 'Communication';
}
    protected static string $view = 'filament.pages.announcements';

}
