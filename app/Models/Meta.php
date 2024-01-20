<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;

    protected $fillable = [
        'halaman_id',
        'meta_key',
        'meta_value',
        'order',
        'is_photo',
        'is_vidio',
    ];
}
