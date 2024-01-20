<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'acara_id',
        'jadwal_id',
        'tanggal',
        'nama',
        'jumlah_peserta',
        'list_peserta',
        'alamat',
        'penanggung_jawab',
        'telpon',
        'catatan',
        'sudah_bayar',
        'punia',
        'nomor_urut',
    ];

    public function acara(){
        return $this->hasOne(Acara::class,'id','acara_id');
    }

    public function jadwal(){
        return $this->hasOne(JadwalAcara::class, 'id','jadwal_id');
    }

    public function pembayaran(){
        return $this->hasOne(Pembayaran::class);
    }

    public function pembayaranList(){
        return $this->hasMany(Pembayaran::class);
    }

    public function getStatusPesertaAttribute() {

        if($this->sudah_bayar == 0 &&  date("Y-m-d") <= $this->tanggal ) {
            return "Sudah Terdaftar";
        }

        if($this->sudah_bayar == 1 &&  date("Y-m-d") <= $this->tanggal ) {
            return "Upload Konfirmasi Pembayaran";
        }

        if($this->sudah_bayar == 1 &&  date("Y-m-d") > $this->tanggal ) {
            return "Selesai Kegiatan";
        }

        if($this->sudah_bayar == 0 &&  date("Y-m-d") > $this->tanggal ) {
            return "Batal";
        }

    }


    public function getStatusOrderAttribute() {

        if($this->pembayaran == null && date("Y-m-d") <= $this->tanggal ) {
            return "Belum Bayar";
        }

        if($this->pembayaran != null && $this->sudah_bayar == 0 ) {
            return "Upload Bukti Pembayaran";
        }

        if($this->sudah_bayar == 1 && date("Y-m-d") <= $this->tanggal ) {
            return "Sudah Bayar";
        }

        if($this->sudah_bayar == 1 && date("Y-m-d") > $this->tanggal ) {
            return "Sudah Selesai";
        }

        if($this->sudah_bayar == 0 && date("Y-m-d") > $this->tanggal ) {
            return "Batal";
        }

    }


    public function dokumentasi(){
        return $this->hasMany(Media::class, 'mediable_id','id')->where([['mediable_type', 'dokumentasi_acara'], ['photo',true]]);
    }

}
