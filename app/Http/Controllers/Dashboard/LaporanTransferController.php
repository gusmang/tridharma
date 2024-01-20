<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ReportPesertaAcara;
use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\cash_payment;
use App\Models\Peserta;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanTransferController extends Controller
{
    public function index(Request $request)
    {

        $tipe_order = [
            'semua'       => "Semua Order",
            'belum_bayar' => "Belum Bayar",
            'upload'      => "Upload Bukti Bayar",
            'terbayar'    => "List Terbayar",
            'selesai'     => "List Selesai",
            'batal'       => "Batal",
        ];


        // $peserta = Peserta::select([
        //     'pesertas.created_at',
        //     'pesertas.id',
        //     'pesertas.tanggal',
        //     'pesertas.nama',
        //     'pesertas.penanggung_jawab',
        //     'pesertas.jumlah_peserta',
        //     'pesertas.alamat',
        //     'pesertas.punia',
        //     'pesertas.telpon',
        //     'pesertas.kode_bayar',
        //     'pesertas.sudah_bayar',
        //     'pesertas.nomor_urut',
        //     'pesertas.dibayarkan',
        //     'acaras.name',
        //     'acaras.id as id_acara',
        //     'pembayarans.id as id_pembayaran',
        //     DB::raw('COUNT(pesertas.id) as jml_peserta')
        // ])
        //     ->join('acaras', 'pesertas.acara_id', '=', 'acaras.id')
        //     ->leftJoin('pembayarans', 'pesertas.id', '=', 'pembayarans.peserta_id');
        $dateFilter = !isset($request->tanggal) ? date("Y-m-d") : $request->tanggal;
        $peserta = cash_payment::where("tanggal_bayar", $dateFilter)->get();

        // $totalBelumTerima = $peserta->where("sudah_diterima", 0)->sum('pesertas.dibayarkan');

        $jmlCash = cash_payment::where('cash_payments.tanggal_bayar', $dateFilter)->sum('cash_payments.nominal');

        $cashPayments = number_format($jmlCash, 0, ',', '.');


        $acaras = Acara::orderBy('id', 'DESC')->get(['id', 'name']);
        return view('dashboard.laporan-transfer.index', ['pesertas_count' => count($peserta), 'jmlTotal' => $cashPayments,  'acaras' => $acaras, 'tipe_order' => $tipe_order, 'list_acara' => $peserta]);
    }

    public function terima_cash(Request $request){
        
    }

    public function datatable(Request $request)
    {
        $dateFilter = !isset($request->tanggal) ? date("Y-m-d") : $request->tanggal;
        $peserta = cash_payment::select([
            'cash_payments.created_at',
            'cash_payments.id',
            'cash_payments.tanggal_bayar',
            'cash_payments.nominal',
            'cash_payments.nama_penerima',
            'cash_payments.sisa_pembayaran',
            'pesertas.jumlah_peserta',
            'pesertas.nomor_urut',
            'pesertas.punia',
            'pesertas.alamat',
            'pesertas.tanggal',
            'pesertas.telpon',
            'pesertas.nama as nama_peserta'
        ])->join("pesertas", "pesertas.id", "cash_payments.id_peserta")->where('cash_payments.tanggal_bayar', $dateFilter)->orderBy("cash_payments.id", "desc");

        return DataTables::of($peserta)->make(true);
    }


    public function exportPeserta($acara_id, Request $request)
    {
        $acara = Acara::findOrFail($acara_id);
        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = $request->tanggal_selesai;

        $nama_file = "Report Peserta {$acara->name}";
        $nama_file = preg_replace("/[^a-zA-Z0-9]+/", "", $nama_file);

        return Excel::download(new ReportPesertaAcara($acara, $tanggal_mulai, $tanggal_selesai), "$nama_file.xlsx");
    }
}
