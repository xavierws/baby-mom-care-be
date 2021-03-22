<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrol extends Model
{
    use HasFactory;

    protected $table = 'kontrols';

    protected $fillable = [
        'order',
        'date',
        'tempat_kontrol',
        'weight',
        'length',
        'lingkar_kepala',
        'temperature',
        'patient_profile_id',
        'note',
        'nurse_note',
        'hasil_penunjang',
        'terapi_pulang',
        'mode',
    ];

    public function patient()
    {
        return $this->belongsTo(PatientProfile::class, 'patient_profile_id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function advices()
    {
        return $this->belongsToMany(Advice::class, 'advice_kontrol', 'kontrol_id', 'advice_id')
            ->withTimestamps();
    }
}
