<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseProfile extends Model
{
    use HasFactory;

    protected $table = 'nurse_profiles';

    protected $fillable = [
        'name',
        'working_exp',
        'education',
        'phone',
        'hospital_id',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userabel');
    }
}
