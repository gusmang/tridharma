<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Halaman extends Model
{
    use HasFactory;
    protected $table = 'halaman';

    protected $fillable = [
        'title',
        'slug',
        'content',
    ];

    public function metas() {
        return $this->hasMany(Meta::class);
    }

    public function acara() {
        return $ths->hasOne(Acara::class);
    }
}
