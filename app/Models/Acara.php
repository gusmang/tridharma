<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Acara extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'order',
        'penjelasan',
        'yang_di_dapat',
        'yang_di_bawa',
        'susunan_acara',
        'sistem_jadwal',
        'punia',
        'vidios',
        'deleted_at',
        'status_slider'
    ];

    public function pesertas(){
        return $this->hasMany(Peserta::class);
    }

    public function jadwals(){
        return $this->hasMany(JadwalAcara::class);
    }

    public function halaman(){
        return $this->belongsTo(Halaman::class,'id','acara_id');
    }

    public function photos(){
        return $this->hasMany(Media::class,'mediable_id','id')->where([['mediable_type','acara'],['photo',true]]);
    }
    public function videos(){
        return $this->hasMany(Media::class,'mediable_id','id')->where([['mediable_type','acara'],['photo',false]]);
    }

    public function dokumentasi(){
        return $this->hasMany(Media::class, 'mediable_id','id')->where([['mediable_type', 'dokumentasi_acara'], ['photo',true]]);
    }
}
