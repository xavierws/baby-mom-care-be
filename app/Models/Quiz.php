<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';

    protected $fillable = [
        'title',
        'materi_id',
    ];

    public function materi()
    {
        return $this->hasOne(Materi::class);
    }

    public function questions()
    {
        return $this->belongsTo(Question::class);
    }

    public function choices()
    {
        return $this->hasManyThrough(QuestionChoice::class, Question::class);
    }
}
