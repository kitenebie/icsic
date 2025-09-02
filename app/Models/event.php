<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Guava\Calendar\Contracts\Eventable;
use Guava\Calendar\ValueObjects\CalendarEvent;

class Event extends Model implements Eventable
{
    protected $table = 'events';

    protected $fillable = [
        'event_name',
        'event_category',
        'event_date',       // DATE (Y-m-d)
        'event_time',       // TIME (H:i:s)
        'event_duration',   // e.g. "90", "1:30", "2h", "45m" (we'll parse)
        'event_discription',
        'event_location',
    ];

    public function toCalendarEvent(): CalendarEvent
    {
        $start = Carbon::parse(trim($this->event_date . ' ' . $this->event_time));

        $minutes = $this->parseDurationToMinutes($this->event_duration);
        $end = (clone $start)->addMinutes($minutes);

        return CalendarEvent::make($this)
            ->title($this->event_name)
            ->start($start)
            ->end($end)
            ->extendedProps([
                'category'    => $this->event_category,
                'location'    => $this->event_location,
                'description' => $this->event_discription,
            ]);
    }

    protected function parseDurationToMinutes($value): int
    {
        if (is_null($value) || $value === '') return 60;
        $s = strtolower(trim((string) $value));

        if (preg_match('/^(\d{1,2}):(\d{2})$/', $s, $m)) {
            return ((int) $m[1]) * 60 + ((int) $m[2]); // "H:MM"
        }
        if (preg_match('/^(\d+(?:\.\d+)?)\s*h/', $s, $m)) {
            return (int) round(((float) $m[1]) * 60); // "2h" or "1.5h"
        }
        if (preg_match('/^(\d+)\s*m/', $s, $m)) {
            return (int) $m[1]; // "45m"
        }
        if (is_numeric($s)) {
            return (int) $s; // plain minutes like "90"
        }
        return 60;
    }
}
