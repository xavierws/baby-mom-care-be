<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $table = 'forums';

    protected $fillable = [
        'title',
        'question',
        'user_id',
        'topic_id',
        'category_id'
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materi()
    {
        return $this->hasOne(Materi::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
