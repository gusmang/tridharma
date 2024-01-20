<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable= [
        'peserta_id',
        'nominal',
        'tanggal_bayar',
        'bukti_transfer',
        'status_bayar'
    ];

    public function peserta(){
        return $this->belongsTo(Peserta::class);
    }
}
