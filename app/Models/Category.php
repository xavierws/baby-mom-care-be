<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    protected $with = [
        'materis'
    ];

    public function materis()
    {
        return $this->hasMany(Materi::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

//    public function forums()
//    {
//        return $this->hasMany(Forum::class);
//    }
}
