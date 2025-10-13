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
use App\Models\Otp;
use App\Models\Sms;
use App\Models\Email;
use App\Models\AiModel;
use App\Models\announcementReacts;
use App\Models\Document;
use App\Models\DocumentRequest;
use App\Models\FcmToken;
use App\Models\Form;
use App\Models\guardian;
use App\Models\newsLikes;
use App\Models\NewsPage;
use App\Models\NewsView;
use App\Models\Notification;
use App\Models\NotListedStudent;

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
        Otp::observe(ModelActivityObserver::class);
        Sms::observe(ModelActivityObserver::class);
        Email::observe(ModelActivityObserver::class);
        AiModel::observe(ModelActivityObserver::class);
        announcementReacts::observe(ModelActivityObserver::class);
        Document::observe(ModelActivityObserver::class);
        DocumentRequest::observe(ModelActivityObserver::class);
        FcmToken::observe(ModelActivityObserver::class);
        Form::observe(ModelActivityObserver::class);
        guardian::observe(ModelActivityObserver::class);
        newsLikes::observe(ModelActivityObserver::class);
        NewsPage::observe(ModelActivityObserver::class);
        NewsView::observe(ModelActivityObserver::class);
        Notification::observe(ModelActivityObserver::class);
        NotListedStudent::observe(ModelActivityObserver::class);
        \Filament\Resources\Pages\CreateRecord::disableCreateAnother();
        \Filament\Actions\CreateAction::configureUsing(fn(\Filament\Actions\CreateAction $action) => $action->createAnother(false));
    }
}
