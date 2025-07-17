<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\event>
 */
class EventFactory extends Factory
{
    protected $model = \App\Models\event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_name' => $this->faker->randomElement([
                'Math Exam',
                'Science Fair',
                'Guest Lecture',
                'Parent-Teacher Meeting',
                'Art Exhibition',
                'Sports Day',
                'Workshop on Robotics',
                'Drama Rehearsal'
            ]),

            'event_category' => $this->faker->randomElement([
                'Academic',
                'Cultural',
                'Sports',
                'Workshop',
                'Meeting'
            ]),

            'event_location' => $this->faker->randomElement([
                'Auditorium',
                'Classroom 101',
                'Library',
                'Computer Lab',
                'Science Lab',
                'Sports Ground',
                'Hall A',
                'Seminar Room'
            ]),

            // Random date for the entire year of 2025
            'event_date' => $this->faker->dateTimeBetween('2025-05-01', '2025-12-31')->format('Y-m-d'),


            'event_time' => $this->faker->time(),
            'event_duration' => $this->faker->randomElement([
                '30 minutes',
                '1 hour',
                '2 hours',
                'Half-day',
                'Full-day'
            ]),

            'event_discription' => $this->faker->sentence(12),
        ];
    }
}
