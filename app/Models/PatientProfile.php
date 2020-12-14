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
        'baby_gender',
        'mother_name',
        'mother_birthday',
        'mother_religion',
        'mother_education',
        'mother_job',
        'paritas',
        'father_name',
        'father_birthday',
        'father_religion',
        'father_education',
        'father_job',
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
