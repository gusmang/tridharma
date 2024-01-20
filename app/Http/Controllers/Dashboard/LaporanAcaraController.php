<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ReportPesertaAcara;
use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanAcaraController extends Controller
{
    public function index () {
        return view('dashboard.laporan-acara.index');
    }

    public function datatable(Request $request) {
        $acara = Acara::select([
            'acaras.id as ac_id',
            'acaras.name',
        ]);

        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = $request->tanggal_selesai;

        return DataTables::of($acara)
            ->addColumn('t_pembayaran', function($item) use ($tanggal_mulai, $tanggal_selesai) {
                $q = Peserta::where('sudah_bayar', '=', 1)
                    ->where('acara_id', '=', $item->ac_id);

                if($tanggal_mulai != null) {
                    $q->where('tanggal', '>=', $tanggal_mulai);
                }
                if($tanggal_selesai != null) {
                    $q->where('tanggal', '<=', $tanggal_selesai);
                }

                return $q->count();
            })
            ->addColumn('t_peserta', function($item) use ($tanggal_mulai, $tanggal_selesai) {
                $q = Peserta::where('sudah_bayar', '=', 1)
                    ->where('acara_id', '=', $item->ac_id);

                if($tanggal_mulai != null) {
                    $q->where('tanggal', '>=', $tanggal_mulai);
                }
                if($tanggal_selesai != null) {
                    $q->where('tanggal', '<=', $tanggal_selesai);
                }

                return $q->sum('jumlah_peserta');
            })
            ->addColumn('t_nominal', function($item) use ($tanggal_mulai, $tanggal_selesai) {
                $q = Peserta::where('sudah_bayar', '=', 1)
                    ->where('acara_id', '=', $item->ac_id);
                if($tanggal_mulai != null) {
                    $q->where('tanggal', '>=', $tanggal_mulai);
                }
                if($tanggal_selesai != null) {
                    $q->where('tanggal', '<=', $tanggal_selesai);
                }

                return $q->sum('punia');
            })
            ->addColumn('aksi', function($item) use ($tanggal_mulai, $tanggal_selesai) {
                return '<a href="'. route('laporan-acara.export-peserta', ['acara_id' => $item->ac_id, 'tanggal_mulai' => $tanggal_mulai, 'tanggal_selesai' => $tanggal_selesai]) .'" class="btn btn-info">Export Peserta</a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function exportPeserta ($acara_id, Request $request) {
        $acara = Acara::findOrFail($acara_id);
        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = $request->tanggal_selesai;

        $nama_file = "Report Peserta {$acara->name}";
        $nama_file = preg_replace("/[^a-zA-Z0-9]+/", "", $nama_file);

        return Excel::download(new ReportPesertaAcara($acara, $tanggal_mulai, $tanggal_selesai), "$nama_file.xlsx");
    }
}
