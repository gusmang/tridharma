<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Acara;
use App\Models\Pebayaran;
use App\View\Components\Form\DeleteButton;
use App\View\Components\Form\EditButton;
use App\View\Components\WaLink;
use Yajra\DataTables\Facades\DataTables;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        /*
        $pesertas = Peserta::with(['acara','jadwal','pembayaran']);
        if($request->acara)
            $pesertas->where('acara_id',strip_tags($request->acara));

        if($request->tanggal)
            $pesertas->where('tanggal',strip_tags($request->tanggal));

        if($request->all())
            $pesertas = $pesertas->orderBy('created_at','DESC')->paginate(20);
        else
            $pesertas = $pesertas->orderBy('created_at','DESC')->paginate(20);

        */
        $acaras = Acara::orderBy('order','ASC')->get(['id','name']);
        return view('dashboard.peserta.index',['acaras'=>$acaras]);
    }


    public function datatable(Request $request  ) {
        $peserta = Peserta::select([
            'pesertas.id',
            'pesertas.tanggal',
            'pesertas.nomor_urut',
            'pesertas.nama',
            'pesertas.penanggung_jawab',
            'pesertas.jumlah_peserta',
            'pesertas.alamat',
            'pesertas.telpon',
            'pesertas.sudah_bayar',
            'pesertas.nomor_urut',
            'acaras.name',
        ])
        ->join('acaras', 'pesertas.acara_id', '=', 'acaras.id');

        if($request->acara != null) {
            $peserta->where('acaras.id', '=', $request->acara);
        }

        if($request->tanggal != null) {
            $peserta->where('pesertas.tanggal', '=', $request->tanggal);
        }



        if($request->status_peserta == "1") {
            $peserta->where('pesertas.sudah_bayar', '=', 0)
                ->where('pesertas.tanggal', '>=', date("Y-m-d"));
        }
        if($request->status_peserta == "2") {
            $peserta->where('pesertas.sudah_bayar', '=', 1)
                ->where('pesertas.tanggal', '>=', date("Y-m-d"));
        }
        if($request->status_peserta == "3") {
            $peserta->where('pesertas.sudah_bayar', '=', 1)
                ->where('pesertas.tanggal', '<', date("Y-m-d"));
        }

        if($request->status_peserta == "4") {
            $peserta->where('pesertas.sudah_bayar', '=', 0)
                ->where('pesertas.tanggal', '<', date("Y-m-d"));
        }


        return DataTables::of($peserta)
            ->addColumn('status_peserta', function($item) {
                return $item->StatusPeserta;
            })
            ->editColumn('telpon', function($item) {
                $obj = new WaLink($item->telpon);
                return $obj->render();
            })
            ->addColumn('aksi', function($item) {
                $edit = new EditButton(route('peserta.edit', $item->id));
                return $edit->render();
            })
            ->rawColumns(['telpon', 'aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acaras = Acara::with('jadwals')->orderBy('order','ASC')->get();
        return view('dashboard.peserta.form',['peserta'=>[],'acaras'=>$acaras]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'namaPeserta'       =>'required',
            'acara_id'          =>'required',
            'jumlahPeserta'     =>'required|Integer|min:1|max:10',
            'alamat'            =>'required|String',
            'telpon'            =>'required|Integer',
            'penanggungJawab'   =>'required|String|min:3',
            'tanggal'           =>'required',
        ]);

        // Check Acara
        $acara = Acara::whereId($request->acara_id)->first();
        if(!$acara)
            return back()->withInput($request->all())->with('notif-warning','Validation Failed');

        if($acara->sistem_jadwal =='Terjadwal' && !$request->jadwal_id)
            return back()->with('notif-warning','Validation Failed')->withInput($request->all());

        if($request->jadwal) {
            //check jadwal exist
            $jadwal = Jadwal::whereId($request->jadwal_id)->count();

            if(!$jadwal)
                return back()->withInput($request->all())->with('notif-warning','Validation Failed');
        }

        // // get Number Urut;
        // $number_urut = Peserta::where('acara_id',$request->acara_id);
        // if($request->jadwal_id)
        //     $number_urut->where('jadwal_id',$request->jadwal_id);
        // else
        //     $number_urut->where('tanggal',$request->tanggal);

        // $number_urut     = $number_urut->count();
        // $new_number_urut = $number_urut>0? ($number_urut+1):1;
        // dd($new_number_urut);

        //get last id;
        $last_id = Peserta::orderBy('id','DESC')->limit(1)->first();
        $code = $last_id?( ((int)$last_id->id)+1):1;
        $new_punia = (int)$acara->punia+$code;

        $peserta = new Peserta;
        $peserta -> acara_id   	    = $acara->id;

        if($request->jadwal_id)
            $peserta -> jadwal_id          = strip_tags($request->jadwal_id);

        $peserta -> tanggal            = strip_tags($request->tanggal);
        $peserta -> nama               = strip_tags($request->namaPeserta);
        $peserta -> jumlah_peserta     = strip_tags($request->jumlahPeserta);

        if($request->listPeserta)
            $peserta -> list_peserta   = strip_tags($request->listPeserta);

        $peserta -> alamat             = strip_tags($request->alamat);
        $peserta -> penanggung_jawab   = strip_tags($request->penanggungJawab);
        $peserta -> telpon             = strip_tags($request->telpon);
        $peserta -> catatan            = strip_tags($request->catatan);
        $peserta -> punia              = $new_punia;
        // $peserta -> nomor_urut         = $new_number_urut;
        // dd($peserta);
        $peserta->save();




        return redirect()->route('peserta.edit',$peserta->id)->with('notif-success','Peserta Suksess di simpan');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $acaras = Acara::with(['jadwals'])->orderBy('order','ASC')->get();
        $peserta = Peserta::whereId($id)->with(['jadwal','acara','pembayaran'])->first();
        // dd($peserta);
        return view('dashboard.peserta.form',['peserta'=>$peserta,'acaras'=>$acaras]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'namaPeserta'       =>'required',
            'acara_id'          =>'required',
            'jumlahPeserta'     =>'required|Integer|min:1|max:10',
            'alamat'            =>'required|String',
            'telpon'            =>'required|Integer',
            'penanggungJawab'   =>'required|String|min:3',
            'tanggal'           =>'required',
        ]);

        // Check Acara
        // $acara = Acara::whereId($request->acara_id)->first();
        // if(!$acara)
        //     return back()->withInput($request->all())->with('notif-warning','Validation Failed');

        // if($acara->sistem_jadwal =='Terjadwal' && !$request->jadwal_id)
        //     return back()->with('notif-warning','Validation Failed')->withInput($request->all());

        // if($request->jadwal) {
        //     //check jadwal exist
        //     $jadwal = Jadwal::whereId($request->jadwal_id)->count();

        //     if(!$jadwal)
        //         return back()->withInput($request->all())->with('notif-warning','Validation Failed');
        // }

        // // get Number Urut;
        // $number_urut = Peserta::where('acara_id',$request->acara_id);
        // if($request->jadwal_id)
        //     $number_urut->where('jadwal_id',$request->jadwal_id);
        // else
        //     $number_urut->where('tanggal',$request->tanggal);

        // $number_urut     = $number_urut->count();
        // $new_number_urut = $number_urut>0? ($number_urut+1):1;
        // // dd($new_number_urut);


        $peserta = Peserta::findOrFail($id);
        // $peserta -> acara_id   	    = $acara->id;

        // if($request->jadwal_id)
        //     $peserta -> jadwal_id          = strip_tags($request->jadwal_id);

        // $peserta -> tanggal            = strip_tags($request->tanggal);
        $peserta -> nama               = strip_tags($request->namaPeserta);
        $peserta -> jumlah_peserta     = strip_tags($request->jumlahPeserta);

        if($request->listPeserta)
            $peserta -> list_peserta   = strip_tags($request->listPeserta);

        $peserta -> alamat             = strip_tags($request->alamat);
        $peserta -> penanggung_jawab   = strip_tags($request->penanggungJawab);
        $peserta -> telpon             = strip_tags($request->telpon);
        $peserta -> catatan            = strip_tags($request->catatan);
        // $peserta -> punia              = $acara->punia;
        // $peserta -> nomor_urut         = $new_number_urut;
        // dd($peserta);
        $peserta->save();


        return redirect()->route('peserta.edit',$peserta->id)->with('notif-success','Peserta Suksess di update');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();
        return back()->with('notif-success','Peserta Suksess di hapus');
    }
}
