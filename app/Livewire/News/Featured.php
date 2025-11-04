<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\NewsPage as NewsDB;

class Featured extends Component
{
    public $categories = [
        "School Announcements",
        "Teacher Updates",
        "Student Achievements",
        "Curriculum Changes",
        "School Events",
        "DEPED Policies",
        "Educational Resources",
        "Parent Involvement",
        "School Safety",
        "Academic Programs",
        "Extracurricular Activities",
        "School Administration",
        "Teacher Training",
        "Student Welfare",
        "Educational Technology",
        "School Facilities",
        "Graduation News",
        "Enrollment Information",
        "Scholarship Opportunities",
        "Educational Reforms",
        "School Supplies",
        "Teacher Recruitment",
        "Student Discipline",
        "School Budget",
        "Educational Partnerships",
        "Online Learning",
        "Special Education",
        "School Feeding Program",
        "DepEd Orders",
        "School Calendar"
    ];
    
    public function render()
    {
        return view('livewire.news.featured', [
            'featured' => NewsDB::where('remarks', 'Featured')->orderBy('id', 'desc')->first(),
        ]);
    }
}
