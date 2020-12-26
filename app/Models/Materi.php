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
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function patients()
    {
        return $this->belongsToMany(PatientProfile::class, 'materi_patient', 'materi_id', 'patient_id')
            ->withTimestamps();
    }
}
