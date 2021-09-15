<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;

    protected $table = 'notification_logs';

    protected $fillable = [
        'notification',
        'nurse_id',
        'type',
        'isRead'
    ];

//    public function advice()
//    {
//        return $this->belongsTo(Advice::class);
//    }
}
