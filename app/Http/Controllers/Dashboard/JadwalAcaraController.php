<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JadwalAcara;
use App\Models\Acara;

use App\Traits\ResponseTrait;

class JadwalAcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ResponseTrait;

    public function index(Request $request)
    {
        $jadwals = JadwalAcara::with('acara');

        if(isset($request->acara)){
            $jadwals->where('acara_id',strip_tags($request->acara));
        }

        if(isset($request->type)){
            if($request->type =='akan-datang')
                $jadwals->where('tanggal','>=',date('Y-m-d'));
        }
        else{
            $jadwals->where('tanggal','>=',date('Y-m-d'));
        }

        if($request->tanggal){
            $jadwals->where('tanggal',date("Y-m-d",strtotime($request->tanggal)));
        }
        // dd('jadwals');

        $jadwals->orderby('tanggal','ASC');
        $jadwals = $jadwals->paginate(10);
        $acaras = Acara::where('sistem_jadwal','Terjadwal')->get(['id','name']);
        return view('dashboard.jadwal-acara.index',['title'=>'Jadwal Acara','jadwals'=>$jadwals,'acaras'=>$acaras]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acaras = Acara::where('sistem_jadwal','Terjadwal')->orderBy('order','ASC')->get(['id','name']);
        return view('dashboard.jadwal-acara.form',['title'=>'Form Jadwal Acara','jadwal'=>[],'acaras'=>$acaras]);

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
            'acara_id' => 'required',
            'tanggal'  => 'required|array',
            'detail'   => 'required|array',
        ]);

        $acara =  Acara::whereId($request->acara_id)->where('sistem_jadwal', 'terjadwal')->count();
        if(!$acara)
            return $this->actionRejected();


        foreach($request->tanggal as $k => $v) {
            JadwalAcara::create([
                'acara_id'       => $request->acara_id,
                'tanggal'        => $v,
                'dinan'          => strip_tags($request->detail[$k]),
                'jumlah_peserta' => 0,
                'is_closed'      => false
            ]);
        }


        if(isset($request->pleaseBack)){
            return back()->with('notif-success', 'Jadwal Acara sudah di simpan');
        }

        return redirect()->route('jadwal-acara.index')->with('notif-success','Jadwal Acara sudah di simpan');
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
        $jadwal = JadwalAcara::whereId($id)->with('acara')->first();
        $acaras = Acara::get(['id','name']);

        return view('dashboard.jadwal-acara.edit',['title'=>'Form Jadwal Acara','jadwal'=>$jadwal,'acaras'=>$acaras]);
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
            'tanggal'=>'required|Date',
            'detail'=>'required',
        ]);

        $jadwal = JadwalAcara::findOrFail($id);
        $jadwal -> tanggal = $request->tanggal;
        $jadwal -> dinan = $request->detail;
        $jadwal -> is_closed = isset($request->tutup)?true:false;
        $jadwal -> save();

        return redirect()->route('jadwal-acara.index')->with('notif-success','Jadwal Acara sudah di simpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwal = JadwalAcara::findOrFail($id);

        $jadwal ->delete();

        return back()->with('notif-success','Jadwal Acara sudah di hapus');
    }


    public function jadwalKosong() {

        $acaras = Acara::select(['acaras.*'])
            ->leftJoin('jadwal_acaras', 'acaras.id', '=', 'jadwal_acaras.acara_id')
            ->where('acaras.sistem_jadwal', '=', 'Terjadwal')
            ->whereNull('jadwal_acaras.id')
            ->groupBy('acaras.id')
            ->get();

        return view('dashboard.jadwal-acara.jadwalKosong', compact('acaras'));
    }

}
