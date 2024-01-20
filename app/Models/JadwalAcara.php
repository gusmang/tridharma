<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAcara extends Model
{
    use HasFactory;

    protected $fillable = [
        'acara_id',
        'tanggal',
        'dinan',
        'jumlah_peserta',
        'penjelasan',
    ];

    public function acara(){
        return $this->hasOne(Acara::class,'id','acara_id');
    }
}
