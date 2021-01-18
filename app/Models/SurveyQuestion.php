<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $table = 'survey_questions';

    protected $fillable = [
        'question',
        'survey_id',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function patients()
    {
        return $this->belongsToMany(PatientProfile::class, 'patient_survey', 'question_id', 'patient_id')
            ->withTimestamps()
            ->withPivot('answer');
    }
}
