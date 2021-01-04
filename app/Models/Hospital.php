<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $table = 'hospitals';

    public function nurses()
    {
        return $this->hasMany(NurseProfile::class);
    }

    public function patients()
    {
        return $this->hasMany(PatientProfile::class);
    }
}
