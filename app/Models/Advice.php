<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advice extends Model
{
    use HasFactory;

    protected $table = 'advices';

    protected $fillable = [
        'name',
        'frequency',
        'description',
    ];

    public function kontrols()
    {
        return $this->belongsToMany(Kontrol::class, 'advice_kontrol', 'advice_id', 'kontrol_id')
            ->withTimestamps();
    }
//    public function notifications()
//    {
//        return $this->hasMany(NotificationLog::class);
//    }
}
