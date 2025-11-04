<?php

namespace App\Livewire\Event;

use Livewire\Component;
use App\Models\event as EventModel;

class Event extends Component
{
    public $events;
    public $currentMonth;
    public $currentYear;
    public $currentDate;
    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadEvents();
    }

    public function prevMonth()
    {
        if ($this->currentMonth == 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }
        $this->currentDate =  $this->currentYear. '-' .$this->currentMonth . '-01';
        $this->currentDate = date('Y-m-d', strtotime($this->currentDate));
        return $this->loadEvents();
    }

    protected $listeners = [
        'calendarPrev' => 'prevMonth',
    ];

    public function nextMonth()
    {
        if ($this->currentMonth == 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }
        $this->currentDate =  $this->currentYear. '-' .$this->currentMonth . '-01';
        $this->currentDate = date('Y-m-d', strtotime($this->currentDate));
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $this->events = EventModel::orderBy('event_date', 'asc')
            ->get();
    }
    public function render()
    {
        return view('livewire.event.event', [
            'events' => $this->events,
        ]);
    }
}
