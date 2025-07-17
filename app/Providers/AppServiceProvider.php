<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Announcement;
use App\Models\event;
use App\Models\news;
use App\Models\Group;
use App\Models\student;
use App\Models\announcementComment;
use App\Models\newsComment;

use App\Observers\UserObserver;
use App\Observers\ModelActivityObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(ModelActivityObserver::class);
        Announcement::observe(ModelActivityObserver::class);
        event::observe(ModelActivityObserver::class);
        news::observe(ModelActivityObserver::class);
        Group::observe(ModelActivityObserver::class);
        student::observe(ModelActivityObserver::class);
        announcementComment::observe(ModelActivityObserver::class);
        newsComment::observe(ModelActivityObserver::class);
        \Filament\Resources\Pages\CreateRecord::disableCreateAnother();
        \Filament\Actions\CreateAction::configureUsing(fn(\Filament\Actions\CreateAction $action) => $action->createAnother(false));
    }
}
