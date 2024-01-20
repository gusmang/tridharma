<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\cash_payment;
use App\Models\JadwalAcara;
use App\Models\Pembayaran;
use App\Models\Peserta;
use App\View\Components\WaLink;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function test_cash(Request $request)
    {
        $peserta = cash_payment::select([
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
        ])->join('pesertas', 'pesertas.id', '=', 'cash_payments.id_peserta')->join('acaras', 'acaras.id', '=', 'pesertas.acara_id');
        if ($request->id_acara != "") {
            $peserta = $peserta->where("acaras.id", $request->id_acara)->where('pesertas.sudah_bayar', "=", 0)
                ->where('pesertas.tanggal', "<", date('Y-m-d'))->orderBy('id', 'desc');
        } else {
            // $peserta_list = $peserta->get();

            // $peserta = $peserta->where("status_batal", 0)
            //     ->whereDate('pesertas.tanggal', "=", $request->tanggal)->orderBy('cash_payments.id', 'desc');
        }

        print_r($peserta->get());
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

        //if($request->id_acara != ""){

        //}
        // else{
        //     $peserta_list = $peserta2->get();

        //     $peserta2 = $peserta2->where("acaras.name" , $peserta_list[0]->name)->where("status_batal" , 0)->whereNull('pembayarans.id')
        //     ->whereDate('pesertas.tanggal', "=", $request->tanggal)->orderBy('id' , 'desc');
        // }


        if ($request->status == 1) {
            $peserta = $peserta->where("dibayarkan", 0)->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->whereNull('pembayarans.id')->where("status_batal", 0)->groupBy('acaras.name')->get();
            //$peserta2 = $peserta2->where("dibayarkan"  , 0)->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->whereNull('pembayarans.id')->where("status_batal" , 0);
        } else if ($request->status == 2) {
            $peserta = $peserta->where("dibayarkan", '>',  0)->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->where("status_batal", 0)->where("dibayarkan", ">", 0)->where("is_cash", 1)->groupBy('acaras.name')->get();
            //$peserta2 = $peserta2->where("dibayarkan" , '>' ,  0)->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->where("status_batal" , 0)->where("sudah_bayar" , 1)->where("is_cash" , 1);
        } else if ($request->status == 3) {
            $peserta = $peserta->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->where("status_batal", 1)->groupBy('acaras.name')->get();
            //$peserta2 = $peserta2->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->where("status_batal" , 1);
        } else {
            $peserta = $peserta->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->whereNull('pembayarans.id')->where("status_batal", 0)->groupBy('acaras.name')->get();
            //$peserta2 = $peserta2->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->whereNull('pembayarans.id')->where("status_batal" , 0);
        }

        $id_acara_def = count($peserta) > 0 ? $peserta[0]->id_acara : "";

        $id_acaras = $request->id_acara != "" ? $request->id_acara : $id_acara_def;

        // if ($request->status == 1) {
        //     $peserta2 = $peserta2->where("acaras.id", $id_acaras)->where("status_batal", 0)->where("dibayarkan", 0)->whereNull('pembayarans.id')
        //         ->whereDate('pesertas.tanggal', "=", $request->tanggal)->orderBy('id', 'desc');
        // } else if ($request->status == 2) {
        //     $peserta2 = $peserta2->where("acaras.id", $id_acaras)
        //         ->whereDate('pesertas.tanggal', "=", $request->tanggal)->where("dibayarkan", ">", 0)->where("pesertas.is_cash", "1")->orderBy('id', 'desc');
        // } else if ($request->status == 3) {
        //     $peserta2 = $peserta2->where("acaras.id", $id_acaras)->where('pesertas.sudah_bayar', "=", 0)
        //         ->where('pesertas.tanggal', "<", date('Y-m-d'))->orderBy('id', 'desc');
        // }

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
        return view('dashboard.order.index', ['acaras' => $acaras, 'tipe_order' => $tipe_order, 'list_acara' => $peserta, 'acara_id' => count($peserta) > 0 ? $peserta[0]->id_acara : "0", 'totalBelumTerima' => $totalBelumTerima, 'totalSudahTerima' => $totalSudahTerima]);
    }

    public function terima(Request $request)
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

        $peserta = $peserta->where("dibayarkan", '>',  0)->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->where("status_batal", 0)->where("dibayarkan", ">", 0)->where("is_cash", 1)->groupBy('acaras.name')->get();
        //$peserta2 = $peserta2->where("dibayarkan" , '>' ,  0)->where('pesertas.tanggal', "=", isset($request->tanggal) ? $request->tanggal : date("Y-m-d"))->where("status_batal" , 0)->where("sudah_bayar" , 1)->where("is_cash" , 1);

        $id_acara_def = count($peserta) > 0 ? $peserta[0]->id_acara : "";

        $id_acaras = $request->id_acara != "" ? $request->id_acara : $id_acara_def;

        if ($request->status == 1) {
            $peserta2 = $peserta2->where("status_batal", 0)->where("dibayarkan", 0)->whereNull('pembayarans.id')
                ->whereDate('pesertas.tanggal', "=", $request->tanggal)->orderBy('id', 'desc');
        } else if ($request->status == 2) {
            $peserta2 = $peserta2
                ->whereDate('pesertas.tanggal', "=", $request->tanggal)->where("dibayarkan", ">", 0)->where("pesertas.is_cash", "1")->orderBy('id', 'desc');
        } else if ($request->status == 3) {
            $peserta2 = $peserta2->where('pesertas.sudah_bayar', "=", 0)
                ->where('pesertas.tanggal', "<", date('Y-m-d'))->orderBy('id', 'desc');
        }

        $peserta3 = cash_payment::select([
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
            'cash_payments.nama_penerima',
        ])->join('pesertas', 'pesertas.id', '=', 'cash_payments.id_peserta')->join('acaras', 'acaras.id', '=', 'pesertas.acara_id');

        if ($id_acaras != "") {
            $peserta3 = $peserta3->whereDate("cash_payments.tanggal_bayar", $request->tanggal)->orderBy('cash_payments.id', 'desc');
        } else {
            // $peserta_list = $peserta->get();

            // $peserta = $peserta->where("status_batal", 0)
            //     ->whereDate('pesertas.tanggal', "=", $request->tanggal)->orderBy('cash_payments.id', 'desc');
        }

        $totalBelumTerima = $peserta3->where("cash_payments.sudah_diterima", 0)->sum('cash_payments.nominal');

        $peserta5 = cash_payment::select([
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
            'cash_payments.nama_penerima',
        ])->join('pesertas', 'pesertas.id', '=', 'cash_payments.id_peserta')->join('acaras', 'acaras.id', '=', 'pesertas.acara_id');

        if ($id_acaras != "") {
            $peserta5 = $peserta5->whereDate("cash_payments.tanggal_bayar", $request->tanggal)->orderBy('cash_payments.id', 'desc');
        } else {
        }

        $peserta5->whereDate("cash_payments.tanggal_bayar", $request->tanggal)->orderBy('cash_payments.id', 'desc');

        $totalSudahTerima = $peserta5->where("cash_payments.sudah_diterima", 1)->sum('cash_payments.nominal');

        $peserta4 = cash_payment::select([
            'acaras.id as id_acara',
            'cash_payments.nama_penerima',
            'users.first_name',
            'users.last_name',
            'cash_payments.id_penerima',
            'cash_payments.sudah_diterima',
            DB::raw("SUM(cash_payments.nominal) as nominal_sub")
        ])->join('pesertas', 'pesertas.id', '=', 'cash_payments.id_peserta')->join('acaras', 'acaras.id', '=', 'pesertas.acara_id')->leftJoin('users', 'users.id', '=', 'cash_payments.id_penerima');

        $peserta4 = $peserta4->whereDate("cash_payments.tanggal_bayar", $request->tanggal)->where("cash_payments.sudah_diterima", "0")->orderBy('cash_payments.id', 'desc');

        $list_penerima = $peserta4->groupBy("cash_payments.id_penerima")->get();

        $peserta_sudah = cash_payment::select([
            'acaras.id as id_acara',
            'cash_payments.nama_penerima',
            'users.first_name',
            'users.last_name',
            'cash_payments.id_penerima',
            'cash_payments.sudah_diterima',
            DB::raw("SUM(cash_payments.nominal) as nominal_sub")
        ])->join('pesertas', 'pesertas.id', '=', 'cash_payments.id_peserta')->join('acaras', 'acaras.id', '=', 'pesertas.acara_id')->leftJoin('users', 'users.id', '=', 'cash_payments.id_penerima');

        $peserta_sudah = $peserta_sudah->whereDate("cash_payments.tanggal_bayar", $request->tanggal)->where("cash_payments.sudah_diterima", "1")->orderBy('cash_payments.id', 'desc');
        $list_penerima_sudah = $peserta_sudah->groupBy("cash_payments.id_penerima")->get();

        $acaras = Acara::orderBy('id', 'DESC')->get(['id', 'name']);
        return view('dashboard.order.terima', ['acaras' => $acaras, 'tipe_order' => $tipe_order, 'list_penerima_sudah' => $list_penerima_sudah, 'list_penerima' => $list_penerima, 'list_acara' => $peserta, 'acara_id' => count($peserta) > 0 ? $peserta[0]->id_acara : "0", 'totalBelumTerima' => $totalBelumTerima, 'totalSudahTerima' => $totalSudahTerima]);
    }

    public function terima_pembayaran(Request $request)
    {
        $updates = cash_payment::join("pesertas", "pesertas.id", "cash_payments.id_peserta")->where("cash_payments.id_penerima", $request->id_staff)->where("cash_payments.tanggal_bayar", $request->tanggal)->where("pesertas.acara_id", $request->id_acara)
            ->update([
                "cash_payments.sudah_diterima" => "1"
            ]);

        if ($updates) {
            return response()->json(["status" => 200, "message" => "Successfully update"]);
        }
    }

    public function datatableUpload(Request $request)
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
            'pembayarans.bukti_transfer',
            'acaras.name',
            'acaras.id as acara_id',
            'acaras.yang_di_bawa as yang_di_bawa',
            'pembayarans.id as id_pembayaran'
        ])
            ->join('acaras', 'pesertas.acara_id', '=', 'acaras.id')
            ->leftJoin('pembayarans', 'pesertas.id', '=', 'pembayarans.peserta_id');

        if ($request->acara != null) {
            $peserta->where('acaras.id', '=', $request->acara);
        }

        if ($request->dateFilter != null) {
            //$peserta->whereDate('pesertas.tanggal', '=', $request->dateFilter);
        } else {
            $date = date("Y-m-d");
            $newdate = strtotime('-1 day', strtotime($date));
            //$peserta->whereDate('pesertas.tanggal', '=', $newdate);
        }
        //$peserta = $peserta->groupBy('pesertas.id');
        // $peserta = $peserta->where("status_batal" , 0)->whereNull('pembayarans.id')
        // ->where('pesertas.tanggal', ">=", date('Y-m-d'))->orderBy('id' , 'desc');
        $peserta = $peserta->where("status_batal", 0)->whereNotNull('pembayarans.id')
            ->where('pesertas.sudah_bayar', "=", 0)->orderBy('id', 'desc');

        return DataTables::of($peserta)
            ->editColumn('created_at', function ($item) {
                return Carbon::parse($item->created_at)->format("Y-m-d H:i:s");
            })
            ->editColumn('bukti_transfer', function ($item) {
                return url('cdn/image/' . $item->bukti_transfer . "?type=thumnail");
            })
            ->addColumn('approve_url', function ($item) {
                return url('dashboard/list-order/' . $item->id . '/' . $item->id_pembayaran . '/acc');
            })
            ->addColumn('reject_url', function ($item) {
                return url('dashboard/list-order/' . $item->id . '/' . $item->id_pembayaran . '/reject');
            })
            ->addColumn('status_order', function ($item) {
                return $item->StatusOrder;
            })
            ->editColumn('yang_di_bawa', function ($item) {
                return strip_tags(html_entity_decode($item->yang_di_bawa));
            })
            // ->editColumn('telpon', function($item) {
            //     $obj = new WaLink($item->telpon);
            //     return $obj->render();
            // })
            ->rawColumns(['telpon'])
            ->make(true);
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
                $peserta = $peserta->where("acaras.id", $request->id_acara)->where("status_batal", 0)->where("dibayarkan", 0)->whereNull('pembayarans.id')
                    ->whereDate('pesertas.tanggal', "=", $request->tanggal)->orderBy('id', 'desc');
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
            // ->editColumn('telpon', function($item) {
            //     $obj = new WaLink($item->telpon);
            //     return $obj->render();
            // })
            ->rawColumns(['telpon'])
            ->make(true);
    }

    public function datatablePaymentCash(Request $request)
    {
        $peserta = cash_payment::select([
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
            'cash_payments.nama_penerima',
            'cash_payments.nominal',
            'cash_payments.sudah_diterima',
            'cash_payments.sisa_pembayaran as sisa_pembayaran_peserta',
        ])->join('pesertas', 'pesertas.id', '=', 'cash_payments.id_peserta')->join('acaras', 'acaras.id', '=', 'pesertas.acara_id');

        if ($request->id_acara != "") {
            //$peserta = $peserta->where("acaras.id", $request->id_acara)->whereDate("cash_payments.tanggal_bayar", $request->tanggal)->orderBy('cash_payments.id', 'desc');
            //$peserta = $peserta->whereDate("cash_payments.tanggal_bayar", $request->tanggal)->orderBy('cash_payments.id', 'desc');
        } else {
            // $peserta_list = $peserta->get();

            // $peserta = $peserta->where("status_batal", 0)
            //     ->whereDate('pesertas.tanggal', "=", $request->tanggal)->orderBy('cash_payments.id', 'desc');
        }

        $peserta = $peserta->whereDate("cash_payments.tanggal_bayar", $request->tanggal)->orderBy('cash_payments.id', 'desc');
        $peserta_list = $peserta->get();

        return DataTables::of($peserta)
            ->editColumn('created_at', function ($item) {
                return Carbon::parse($item->created_at)->format("Y-m-d H:i:s");
            })
            ->addColumn('status_order', function ($item) {
                return $item->StatusOrder;
            })
            // ->editColumn('telpon', function($item) {
            //     $obj = new WaLink($item->telpon);
            //     return $obj->render();
            // })
            ->rawColumns(['telpon'])
            ->make(true);
    }


    public function show($id)
    {
        $peserta = Peserta::findOrFail($id);
        return view('dashboard.order.show', compact('peserta'));
    }

    public function bayar($id)
    {
        $peserta = Peserta::findOrFail($id);

        $cash_pay = cash_payment::where("id_peserta", $id)->join("users", "users.id", "cash_payments.id_penerima")->get();
        $summary = DB::table('cash_payments')
            ->select(DB::raw('SUM(nominal) AS total_nominal'))->where("id_peserta", $id)
            ->get();

        return view('dashboard.order.bayar', compact('peserta', 'cash_pay', 'summary'));
    }

    public function pembayaran(Request $request)
    {
        $payment = new cash_payment();

        $peserta = Peserta::findOrFail($request->hidden_index);

        $payment->id_peserta = $peserta->id;
        $payment->id_penerima = Auth::user()->id;
        $payment->nominal = $request->t_jml_bayar;
        $payment->tanggal_bayar = $request->t_tanggal_bayar;
        $payment->status = 1;
        $payment->catatan = $request->t_catatan;
        $payment->nama_penerima = Auth::user()->first_name . " " . Auth::user()->last_name;
        $payment->sisa_pembayaran = $request->sisa_pembayaran - $request->t_jml_bayar;

        $payment->save();

        $summary = DB::table('cash_payments')
            ->select(DB::raw('SUM(nominal) AS total_nominal'))->where("id_peserta", $request->hidden_index)
            ->get();

        Peserta::where("id", $request->hidden_index)->update([
            "dibayarkan" => $summary[0]->total_nominal
        ]);

        $cekPelunasan = $request->sisa_pembayaran - $request->t_jml_bayar;

        Peserta::where("id", $request->hidden_index)->update([
            "is_cash" => true
        ]);

        if ($cekPelunasan == 0) {
            Peserta::where("id", $request->hidden_index)->update([
                "sudah_bayar" => "1",
                "is_cash" => true
            ]);

            $pembayaran = new Pembayaran();

            $pembayaran->peserta_id = $peserta->id;
            $pembayaran->nominal = $peserta->punia;
            $pembayaran->tanggal_bayar = date('Y-m-d H:i:s');
            $pembayaran->bukti_transfer = "-";
            $pembayaran->status_bayar = 1;

            $pembayaran->save();
        }

        return back()->with('notif-success', 'Pembayaran berhasil diverifikasi');
    }

    public function reject($peserta_id, $pembayaran_id)
    {
    }

    public function acc($peserta_id, $pembayaran_id)
    {
        $peserta = Peserta::findOrFail($peserta_id);
        $pembayaran = Pembayaran::where('peserta_id', '=', $peserta_id)
            ->findOrFail($pembayaran_id);

        $number_urut = Peserta::where('acara_id', $peserta->acara_id);

        if ($peserta->jadwal_id != null)
            $number_urut->where('jadwal_id', $peserta->jadwal_id);
        else
            $number_urut->where('tanggal', $peserta->tanggal);

        $number_urut     = $number_urut->orderBy('nomor_urut', 'desc')->first();

        if ($number_urut == null) {
            $no = 1;
        } else {
            $no = $number_urut->nomor_urut + 1;
        }

        $pembayaran->update([
            'status_bayar' => 1,
            'kode_bayar'   => ''
        ]);

        $peserta->update([
            'sudah_bayar' => 1,
            'nomor_urut' => $no
        ]);

        return back()->with('notif-success', 'Pembayaran berhasil diverifikasi');
    }


    public function tolak($peserta_id, $pembayaran_id)
    {
        $peserta = Peserta::findOrFail($peserta_id);
        $pembayaran = Pembayaran::where('peserta_id', '=', $peserta_id)
            ->findOrFail($pembayaran_id);

        $pembayaran->update([
            'status_bayar' => 0
        ]);

        return back()->with('notif-success', 'Pembayaran berhasil ditolak');
    }

    public function cancelOrder(Request $request, $pembayaran_id)
    {
        $peserta = Peserta::where("id", $pembayaran_id)->update([
            'status_batal' => 1
        ]);

        return back()->with('notif-success', 'Pendaftaran berhasil dicancel');
    }

    public function editOrder(Request $request)
    {

        $pesertas = Peserta::where('id', $request->hidden_index)->first();
        $jadwal = JadwalAcara::where("id", $pesertas->jadwal_id)->first();

        $acara = Acara::where("id", $pesertas->acara_id)->first();

        $punia = $acara->punia;

        $jmlBayar = ($punia * $request->t_jumlah_peserta) + $pesertas->kode_bayar;

        Peserta::where('id', $request->hidden_index)->update([
            'nama' => $request->t_nama_peserta,
            'tanggal' => $request->t_tanggal_acara,
            'jumlah_peserta' => $request->t_jumlah_peserta,
            'telpon' => $request->t_telpon,
            'alamat' => $request->t_alamat_peserta,
            'punia' => $jmlBayar
        ]);

        return back()->with('notif-success', 'Pendaftaran berhasil diupdate');
    }

    public function uploadBuktiBayar($peserta_id, Request $request)
    {
        $peserta = Peserta::findOrFail($peserta_id);

        $request->validate([
            'tanggal_bayar' => 'required',
            'nominal'       => 'required',
            'bukti_bayar'   => 'required|image',
        ]);
        $peserta = Peserta::findOrFail($request->peserta_id);

        if (!$request->hasFile('bukti_bayar')) {
            return back()->withInput($request->all())->with('notif-warning', 'Bukti Transfer di perlukan');
        }

        // upload file
        $file_image = Str::random(50) . '.' . $request->file('bukti_bayar')->getClientOriginalExtension();
        $request->file('bukti_bayar')->storeAs('public/full', $file_image);

        // tanggal
        $date    = str_replace('/', '-', $request->tanggal_bayar);
        $tanggal = date('Y-m-d', strtotime($date));

        Pembayaran::create([
            'peserta_id'     => $peserta->id,
            'nominal'        => $request->nominal,
            'tanggal_bayar'  => $tanggal,
            'bukti_transfer' => $file_image,
            'status_bayar'   => 0
        ]);

        return redirect()->back()->with('notif-success', "Pembayaran berhasil disimpan. Lakukan konfirmasi untuk memvalidasi pembayaran");
    }


    public function hapusPembayaran($peserta_id, $pembayaran_id)
    {
        $peserta = Peserta::findOrFail($peserta_id);
        $pembayaran = Pembayaran::where('peserta_id', '=', $peserta_id)
            ->findOrFail($pembayaran_id);
        $pembayaran->delete();
        return back()->with('notif-success', 'Pembayaran berhasil dihapus');
    }
}
