<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $table = 'topics';

    protected $fillable = [
        'name',
    ];

    protected $with = [
        'forums',
    ];

    public function forums()
    {
        return $this->hasMany(Forum::class);
    }
}
