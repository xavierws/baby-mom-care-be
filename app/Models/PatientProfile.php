<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    use HasFactory;

    protected $table = 'patient_profiles';

    protected $fillable = [
        'baby_name',
        'baby_birthday',
        'born_weight',
        'born_length',
        'baby_gender',
        'mother_name',
        'mother_birthday',
        'mother_religion',
        'mother_education',
        'mother_job',
        'paritas',
        'father_name',
        'father_birthday',
        'father_religion',
        'father_education',
        'father_job',
        'status',
        'hospital_id',
    ];

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kontrols()
    {
        return $this->hasMany(Kontrol::class, 'patient_profile_id');
    }

    public function nurses()
    {
        return $this->belongsToMany(NurseProfile::class, 'nurse_patient', 'patient_id', 'nurse_id')
            ->withTimestamps();
    }

    public function materis()
    {
        return $this->belongsToMany(Materi::class, 'materi_patient', 'patient_id', 'materi_id')
            ->withTimestamps();
    }

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'patient_survey', 'patient_id', 'survey_id')
            ->withTimestamps()
            ->withPivot('answer');
    }

    public function quizzes()
    {
        return $this->belongsToMany(QuestionChoice::class, 'user_answer', 'patient_id', 'answer_id')
            ->withTimestamps()
            ->withPivot('point', 'question_id', 'quiz_id');
    }

    public function getResumePulangAttribute()
    {
        return $this->kontrols->where('mode', 'resume')->first();
    }
}
