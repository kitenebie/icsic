<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notif = Notification::findOrFail($id);
        $viewed = collect($notif->user_id_who_already_viewed);

        if (!$viewed->contains(Auth::id())) {
            $viewed->push(Auth::id());
            $notif->update([
                'user_id_who_already_viewed' => $viewed->values()->all(),
            ]);
        }

        // Determine the redirect URL based on category
        $url = match ($notif->category) {
            'Announcement' => url('/announcements#' . $notif->link),
            'Event' => url('/events' . $notif->link),
            'News' => url('/read/OuO9qzwUNphz2qBmHrLQQ2pILprFlIyuZg6viUZYqYFm5EkxtWhNwsE06OXi7eSMdv8012J0mFlR5hXYk0yOW24npkwLNMcAiXx8/' . $notif->link),
            default => null
        };
        return response()->json([
            'status' => 'ok',
            'redirect' => $url
        ]);
    }
}
