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
        'lingkar_kepala',
        'baby_gender',
        'usia_gestas',
        'harapan_orangtua',
        'mother_name',
        'mother_birthday',
        'mother_religion',
        'mother_education',
        'mother_job',
        'paritas',
        'jumlah_anak',
        'pengalaman_merawat',
        'tinggal_dengan_suami',
        'father_name',
        'father_birthday',
        'father_religion',
        'father_education',
        'father_job',
        'pendapatan_keluarga',
        'phone',
        'status',
        'return_date',
        'marked_date',
        'hospital_id',
    ];

//    protected $with = [
//        'kontrols',
//        'user',
//        'materis',
//    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

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
        return $this->belongsToMany(SurveyQuestion::class, 'patient_survey', 'patient_id', 'question_id')
            ->withTimestamps()
            ->withPivot('answer', 'order','survey_id');
    }

    public function quizzes()
    {
        return $this->belongsToMany(QuestionChoice::class, 'user_answer', 'patient_id', 'answer_id')
            ->withTimestamps()
            ->withPivot('point', 'question_id', 'quiz_id', 'order');
    }

    public function getResumePulangAttribute()
    {
        return $this->kontrols->where('mode', 'resume')->first();
    }

    public function getCurrentWeightAttribute()
    {
        if (!$this->kontrols) return $this->born_weight;

        $kontrol = $this->kontrols()->orderBy('order', 'desc')->pluck('weight')->first();

        return $kontrol;
    }

    public function getCurrentLengthAttribute()
    {
        if (!$this->kontrols) return $this->born_length;

        $kontrol = $this->kontrols()->orderBy('order', 'desc')->pluck('length')->first();

        return $kontrol;
    }

    public function getCurrentLingkarKepalaAttribute()
    {
        if (!$this->kontrols) return $this->lingkar_kepala;

        $kontrol = $this->kontrols()->orderBy('order', 'desc')->pluck('lingkar_kepala')->first();

        return $kontrol;
    }
}
