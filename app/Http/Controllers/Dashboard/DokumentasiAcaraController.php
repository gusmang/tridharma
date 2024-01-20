<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Peserta;
use App\View\Components\WaLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DokumentasiAcaraController extends Controller
{

    // public function index () {
    //     $acaras = Acara::orderBy('order', 'ASC')->get(['id','name']);
    //     return view('dashboard.dokumentasi-acara.index', compact('acaras'));
    // }
    public function change_acara(Request $request)
    {
        Peserta::where("id", $request->no_daftar)->update([
            "tanggal" => $request->date_tanggal_acara
        ]);

        return response()->json(["status" => 200, "message" => "success"]);
    }

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

        $peserta = Peserta::select([
            'pesertas.created_at',
            'pesertas.id',
            'pesertas.tanggal',
            'pesertas.nama',
            'pesertas.penanggung_jawab',
            'pesertas.jumlah_peserta',
            'pesertas.alamat',
            'pesertas.punia',
            'pesertas.telpon',
            'pesertas.kode_bayar',
            'pesertas.sudah_bayar',
            'pesertas.nomor_urut',
            'pesertas.dibayarkan',
            'acaras.name',
            'acaras.id as id_acara',
            'pembayarans.id as id_pembayaran',
            DB::raw('COUNT(pesertas.id) as jml_peserta')
        ])
            ->join('acaras', 'pesertas.acara_id', '=', 'acaras.id')
            ->leftJoin('pembayarans', 'pesertas.id', '=', 'pembayarans.peserta_id');

        $peserta2 = Peserta::select([
            'pesertas.created_at',
            'pesertas.id',
            'pesertas.tanggal',
            'pesertas.nama',
            'pesertas.penanggung_jawab',
            'pesertas.jumlah_peserta',
            'pesertas.alamat',
            'pesertas.punia',
            'pesertas.telpon',
            'pesertas.kode_bayar',
            'pesertas.sudah_bayar',
            'pesertas.nomor_urut',
            'pesertas.dibayarkan',
            'acaras.name',
            'acaras.id as id_acara',
            'pembayarans.id as id_pembayaran',
            DB::raw('COUNT(pesertas.id) as jml_peserta')
        ])
            ->join('acaras', 'pesertas.acara_id', '=', 'acaras.id')
            ->leftJoin('pembayarans', 'pesertas.id', '=', 'pembayarans.peserta_id');
        $totalPesertas = 0;
        $totals_array = [];

        

        if ($request->status == 1) {
            //$peserta = $peserta->whereDate('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->where('pesertas.sudah_bayar', "=", 1)->where("status_batal", 0)->groupBy('acaras.name')->get();
            $peserta = $peserta->where("status_batal", 0)->whereDate('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))
                ->where(function ($query) {
                    $query->where('pesertas.dibayarkan', ">", 0)
                        ->orWhere('pesertas.sudah_bayar', 1);
                })->groupBy('acaras.name');

            $peserta = $peserta->get();

            $inc = 0;

           
            foreach($peserta as $rows){
                $totalPesertas = 0;
                $peserta3 = Peserta::select([
                    'pesertas.created_at',
                    'pesertas.id',
                    'pesertas.tanggal',
                    'pesertas.nama',
                    'pesertas.penanggung_jawab',
                    'pesertas.jumlah_peserta',
                    'pesertas.alamat',
                    'pesertas.punia',
                    'pesertas.telpon',
                    'pesertas.kode_bayar',
                    'pesertas.sudah_bayar',
                    'pesertas.nomor_urut',
                    'pesertas.dibayarkan',
                    'acaras.name',
                    'acaras.id as id_acara',
                    'pembayarans.id as id_pembayaran',
                    DB::raw('COUNT(pesertas.id) as jml_peserta')
                ])
                    ->join('acaras', 'pesertas.acara_id', '=', 'acaras.id')
                    ->leftJoin('pembayarans', 'pesertas.id', '=', 'pembayarans.peserta_id');

                $peserta3 = $peserta3->where("status_batal", 0)->where("acaras.id", $rows->id_acara)->whereDate('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))
                ->where(function ($query) {
                    $query->where('pesertas.dibayarkan', ">", 0)
                        ->orWhere('pesertas.sudah_bayar', 1);
                })->groupBy('pesertas.id')->get();

                foreach ($peserta3 as $rowp) {
                    $totalPesertas += $rowp->jumlah_peserta;
                }

                array_push($totals_array , $totalPesertas);
            }

            // foreach ($peserta3 as $rowp) {
            //     $totalPesertas += $rowp->jumlah_peserta;
            //     if(count($peserta) > 1){
            //         if(count($peserta3) < $peserta3[$inc+1]->id_acara){
            //             if ($rowp->id_acara == $peserta3[$inc + 1]->id_acara) {
            //                 $totalPesertas += $rowp->jumlah_peserta;
            //             } else {
            //                 $totalPesertas = 0;
            //                 array_push($totals_array, $totalPesertas);
            //             }
            //     }
            //     else{
            //         $totalPesertas += $rowp->jumlah_peserta;
            //     }
                
            //     $inc++;
            // }
            // }
        } else if ($request->status == 2) {
            $peserta = $peserta->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->where("status_batal", 0)->where(function ($query) {
                $query->where('pesertas.dibayarkan', ">", 0)
                    ->orWhere('pesertas.sudah_bayar', 1);
            })->groupBy('acaras.name');

            //$totalPesertas = $peserta->sum('pesertas.jumlah_peserta');
            $peserta = $peserta->get();

            $inc = 0;

            foreach($peserta as $rows){
                $totalPesertas = 0;
                $peserta3 = Peserta::select([
                    'pesertas.created_at',
                    'pesertas.id',
                    'pesertas.tanggal',
                    'pesertas.nama',
                    'pesertas.penanggung_jawab',
                    'pesertas.jumlah_peserta',
                    'pesertas.alamat',
                    'pesertas.punia',
                    'pesertas.telpon',
                    'pesertas.kode_bayar',
                    'pesertas.sudah_bayar',
                    'pesertas.nomor_urut',
                    'pesertas.dibayarkan',
                    'acaras.name',
                    'acaras.id as id_acara',
                    'pembayarans.id as id_pembayaran',
                    DB::raw('COUNT(pesertas.id) as jml_peserta')
                ])
                    ->join('acaras', 'pesertas.acara_id', '=', 'acaras.id')
                    ->leftJoin('pembayarans', 'pesertas.id', '=', 'pembayarans.peserta_id');

                $peserta3 = $peserta3->where("status_batal", 0)->where("acaras.id", $rows->id_acara)->whereDate('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))
                ->where(function ($query) {
                    $query->where('pesertas.dibayarkan', ">", 0)
                        ->orWhere('pesertas.sudah_bayar', 1);
                })->groupBy('pesertas.id')->get();

                foreach ($peserta3 as $rowp) {
                    $totalPesertas += $rowp->jumlah_peserta;
                }

                array_push($totals_array , $totalPesertas);
            }

        } else if ($request->status == 3) {
            $peserta = $peserta->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->where("status_batal", 1)->groupBy('acaras.name');
            //$totalPesertas = $peserta->sum('pesertas.jumlah_peserta');
            $peserta = $peserta->get();

            $inc = 0;

            foreach($peserta as $rows){
                $totalPesertas = 0;
                $peserta3 = Peserta::select([
                    'pesertas.created_at',
                    'pesertas.id',
                    'pesertas.tanggal',
                    'pesertas.nama',
                    'pesertas.penanggung_jawab',
                    'pesertas.jumlah_peserta',
                    'pesertas.alamat',
                    'pesertas.punia',
                    'pesertas.telpon',
                    'pesertas.kode_bayar',
                    'pesertas.sudah_bayar',
                    'pesertas.nomor_urut',
                    'pesertas.dibayarkan',
                    'acaras.name',
                    'acaras.id as id_acara',
                    'pembayarans.id as id_pembayaran',
                    DB::raw('COUNT(pesertas.id) as jml_peserta')
                ])
                    ->join('acaras', 'pesertas.acara_id', '=', 'acaras.id')
                    ->leftJoin('pembayarans', 'pesertas.id', '=', 'pembayarans.peserta_id');

                $peserta3 = $peserta3->where("status_batal", 0)->where("acaras.id", $rows->id_acara)->whereDate('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))
                ->where(function ($query) {
                    $query->where('pesertas.dibayarkan', ">", 0)
                        ->orWhere('pesertas.sudah_bayar', 1);
                })->groupBy('pesertas.id')->get();

                foreach ($peserta3 as $rowp) {
                    $totalPesertas += $rowp->jumlah_peserta;
                }

                array_push($totals_array , $totalPesertas);
            }
        } else {
            $peserta = $peserta->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->whereNull('pembayarans.id')->where("status_batal", 0)->groupBy('acaras.name');
            //$totalPesertas = $peserta->sum('pesertas.jumlah_peserta');
            $peserta = $peserta->get();

            $inc = 0;

            foreach($peserta as $rows){
                $totalPesertas = 0;
                $peserta3 = Peserta::select([
                    'pesertas.created_at',
                    'pesertas.id',
                    'pesertas.tanggal',
                    'pesertas.nama',
                    'pesertas.penanggung_jawab',
                    'pesertas.jumlah_peserta',
                    'pesertas.alamat',
                    'pesertas.punia',
                    'pesertas.telpon',
                    'pesertas.kode_bayar',
                    'pesertas.sudah_bayar',
                    'pesertas.nomor_urut',
                    'pesertas.dibayarkan',
                    'acaras.name',
                    'acaras.id as id_acara',
                    'pembayarans.id as id_pembayaran',
                    DB::raw('COUNT(pesertas.id) as jml_peserta')
                ])
                    ->join('acaras', 'pesertas.acara_id', '=', 'acaras.id')
                    ->leftJoin('pembayarans', 'pesertas.id', '=', 'pembayarans.peserta_id');

                $peserta3 = $peserta3->where("status_batal", 0)->where("acaras.id", $rows->id_acara)->whereDate('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))
                ->where(function ($query) {
                    $query->where('pesertas.dibayarkan', ">", 0)
                        ->orWhere('pesertas.sudah_bayar', 1);
                })->groupBy('pesertas.id')->get();

                foreach ($peserta3 as $rowp) {
                    $totalPesertas += $rowp->jumlah_peserta;
                }

                array_push($totals_array , $totalPesertas);
            }
        }

        $id_acara_def = count($peserta) > 0 ? $peserta[0]->id_acara : "";

        $id_acaras = $request->id_acara != "" ? $request->id_acara : $id_acara_def;

        if ($request->status == 1) {
            $peserta2 = $peserta2->where("acaras.id", $id_acaras)->where("status_batal", 0)->where("dibayarkan", 0)->whereNull('pembayarans.id')
                ->whereDate('pesertas.tanggal', "=", $request->tanggal)->orderBy('id', 'desc');
        } else if ($request->status == 2) {
            $peserta2 = $peserta2->where("acaras.id", $id_acaras)
                ->whereDate('pesertas.tanggal', "=", $request->tanggal)->where("dibayarkan", ">", 0)->where("pesertas.is_cash", "1")->orderBy('id', 'desc');
        } else if ($request->status == 3) {
            $peserta2 = $peserta2->where("acaras.id", $id_acaras)->where('pesertas.sudah_bayar', "=", 0)
                ->where('pesertas.tanggal', "<", date('Y-m-d'))->orderBy('id', 'desc');
        }

        $totalBelumTerima = $peserta2->where("sudah_diterima", 0)->sum('pesertas.dibayarkan');
        $totalSudahTerima = $peserta2->where("sudah_diterima", 1)->sum('pesertas.dibayarkan');

        $acaras = Acara::orderBy('id', 'DESC')->get(['id', 'name']);
        return view('dashboard.dokumentasi-acara.index', ['pesertas_count' => count($peserta), 'totalPesertas' =>  $totals_array, 'acaras' => $acaras, 'tipe_order' => $tipe_order, 'list_acara' => $peserta, 'acara_id' => count($peserta) > 0 ? $peserta[0]->id_acara : "0", 'totalBelumTerima' => $totalBelumTerima, 'totalSudahTerima' => $totalSudahTerima]);
    }


    public function datatable(Request $request)
    {
        $peserta = Peserta::select([
            'pesertas.created_at',
            'pesertas.id',
            'pesertas.tanggal',
            'pesertas.nama',
            'pesertas.penanggung_jawab',
            'pesertas.jumlah_peserta',
            'pesertas.alamat',
            'pesertas.punia',
            'pesertas.telpon',
            'pesertas.kode_bayar',
            'pesertas.sudah_bayar',
            'pesertas.nomor_urut',
            'pesertas.dibayarkan',
            'pesertas.is_cash',
            'acaras.name',
            'acaras.id as id_acara',
            'pembayarans.id as id_pembayaran'
        ])
            ->join('acaras', 'pesertas.acara_id', '=', 'acaras.id')
            ->leftJoin('pembayarans', 'pesertas.id', '=', 'pembayarans.peserta_id');

        if ($request->acara != null) {
            $peserta->where('acaras.id', '=', $request->acara);
        }

        if ($request->tipe_order != null) {
            $tipe_order = $request->tipe_order;

            if ($tipe_order == 'belum_bayar') {
                $peserta
                    ->whereNull('pembayarans.id')
                    ->where('pesertas.tanggal', ">=", date('Y-m-d'));
            }

            if ($tipe_order == 'upload') {
                $peserta
                    ->whereNotNull('pembayarans.id')
                    ->where('pesertas.sudah_bayar', "=", 0);
            }

            if ($tipe_order == 'terbayar') {
                $peserta
                    ->where('pesertas.sudah_bayar', "=", 1)
                    ->where('pesertas.tanggal', ">=", date('Y-m-d'));
            }

            if ($tipe_order == 'selesai') {
                $peserta
                    ->where('pesertas.sudah_bayar', "=", 1)
                    ->where('pesertas.tanggal', "<", date('Y-m-d'));
            }

            if ($tipe_order == 'batal') {
                $peserta
                    ->where('pesertas.sudah_bayar', "=", 0)
                    ->where('pesertas.tanggal', "<", date('Y-m-d'));
            }
        }

        if ($request->id_acara != "") {
            if ($request->status == 1) {
                $peserta = $peserta->where("acaras.id", $request->id_acara)->where("status_batal", 0)->whereDate('pesertas.tanggal', "=", $request->tanggal)
                    ->where(function ($query) {
                        $query->where('pesertas.dibayarkan', ">", 0)
                            ->orWhere('pesertas.sudah_bayar', 1);
                    })->groupBy('pesertas.id');
            } else if ($request->status == 2) {
                $peserta = $peserta->where("acaras.id", $request->id_acara)
                    ->whereDate('pesertas.tanggal', "=", $request->tanggal)->where("dibayarkan", ">", 0)->where("pesertas.is_cash", "1")->orderBy('id', 'desc');
            } else if ($request->status == 3) {
                $peserta = $peserta->where("acaras.id", $request->id_acara)->where('pesertas.sudah_bayar', "=", 0)
                    ->where('pesertas.tanggal', "<", date('Y-m-d'))->orderBy('id', 'desc');
            }
        } else {
            $peserta_list = $peserta->get();

            $peserta = $peserta->where("acaras.name", $peserta_list[0]->name)->where("status_batal", 0)->whereNull('pembayarans.id')
                ->whereDate('pesertas.tanggal', "=", $request->tanggal)->orderBy('id', 'desc');
        }

        $peserta_list = $peserta->get();

        return DataTables::of($peserta)
            ->editColumn('created_at', function ($item) {
                return Carbon::parse($item->created_at)->format("Y-m-d H:i:s");
            })
            ->addColumn('status_order', function ($item) {
                return $item->StatusOrder;
            })
            ->rawColumns(['telpon'])
            ->make(true);
    }


    public function show($peserta_id)
    {
        $peserta = Peserta::findOrFail($peserta_id);
        return view('dashboard.dokumentasi-acara.show', compact('peserta'));
    }
}
