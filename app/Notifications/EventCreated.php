<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreated extends Notification
{
    use Queueable;

    public $event;

    /**
     * Create a new notification instance.
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Event: ' . $this->event->event_name,
            'message' => 'A new event "' . $this->event->event_name . '" has been scheduled on ' . $this->event->event_date,
            'url' => url('/events'), // adjust if you have an event detail page
        ];
    }
    // You can also use the following code to display notifications in your Blade view:
        // @foreach(auth()->user()->notifications as $notification)
        //     <div class="p-4 bg-gray-100 mb-2">
        //         <strong>{{ $notification->data['title'] }}</strong><br>
        //         {{ $notification->data['message'] }}
        //         <a href="{{ $notification->data['url'] }}" class="text-blue-500">View</a>
        //     </div>
        // @endforeach

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
