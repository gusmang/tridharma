<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Peserta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sudah_bayar =  Peserta::where('sudah_bayar', '=', true)
            ->where('pesertas.tanggal', ">=", date('Y-m-d'))
            ->count();

        $belum_bayar =  Peserta::where('sudah_bayar', '=', false)
            ->leftJoin('pembayarans', 'pesertas.id', '=', 'pembayarans.peserta_id')
            ->where('pesertas.tanggal', ">=", date('Y-m-d'))
            ->whereNull('pembayarans.id')
            ->count();

        $lewat_tanggal =  Peserta::where('sudah_bayar', '=', false)
            ->where('pesertas.tanggal', "<", date('Y-m-d'))
            ->count();


        $tipe_order = [
            'upload'      => "Upload Bukti Bayar",
            'terbayar'    => "List Terbayar",
        ];
        $acaras = Acara::orderBy('order', 'ASC')->get(['id','name']);
        return view('dashboard.index', compact('sudah_bayar', 'belum_bayar', 'lewat_tanggal', 'tipe_order', 'acaras'));
    }
}
