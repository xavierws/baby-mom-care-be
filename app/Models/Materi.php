<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materis';

    protected $fillable = [
        'title',
        'content',
        'content_url',
        'video_url',
        'doc_url',
        'category_id',
        'forum_id',
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }

    public function patients()
    {
        return $this->belongsToMany(PatientProfile::class, 'materi_patient', 'materi_id', 'patient_id')
            ->withTimestamps();
    }

    public function forum()
    {
        return $this->hasOne(Forum::class);
    }

    public function getForumTitleAtrribute()
    {
        if (!$this->forum->isEmpty()) return $this->forum->title;

        return null;
    }
}
