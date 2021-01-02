<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionChoice extends Model
{
    use HasFactory;

    protected $table = 'question_choices';

    protected $fillable = [
        'choice',
        'is_true',
        'question_id',
    ];

    protected $casts = [
        'is_true' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function patients()
    {
        return $this->belongsToMany(PatientProfile::class, 'user_answer', 'answer_id', 'patient_id')
            ->withTimestamps()
            ->withPivot('point', 'question_id', 'quiz_id');
    }
}
