<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'lrn',
        'adviser_id',
        'last_name',
        'first_name',
        'middle_name',
        'extension_name',
        'birthdate',
        'is_learner_with_disability',
        'disability_type',
        'permanent_address',
        'current_address',
        'mother_tongue',
        'age',
        'with_lrn',
        'returning_learner',
        'sex',
        'indigenous_peoples',
        'indigenous_peoples_specification',
        '4ps_beneficiary',
        '4ps_household_id',
        'father_name',
        'mother_maiden_name',
        'legal_guardian_name',
        'contact_number',
        'last_grade_level_completed',
        'last_school_year_completed',
        'last_school_attended',
        'school_id',
        'semester',
        'track',
        'strand',
        'distance_learning_preference',
    ];
}
