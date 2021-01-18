<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'surveys';

    protected $fillable = [
        'title',
        'choice_type',
    ];

    protected $with = [
        'questions'
    ];

//    public function patients()
//    {
//        return $this->belongsToMany(PatientProfile::class, 'patient_survey', 'survey_id', 'patient_id')
//            ->withTimestamps()
//            ->withPivot('answer');
//    }

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }
}
