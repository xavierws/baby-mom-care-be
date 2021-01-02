<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'question',
        'quiz_id',
    ];

    public function choices()
    {
        return $this->hasMany(QuestionChoice::class);
    }
}
