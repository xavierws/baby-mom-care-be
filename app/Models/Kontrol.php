<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrol extends Model
{
    use HasFactory;

    protected $table = 'kontrols';

    protected $fillable = [
        'title',
        'date',
        'tempat_kontrol',
        'weight',
        'length',
        'lingkar_kepala',
        'temperature',
        'patient_profile_id',
    ];

    public function patient()
    {
        return $this->belongsTo(PatientProfile::class, 'patient_profile_id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
