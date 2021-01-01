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

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
