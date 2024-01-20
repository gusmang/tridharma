<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Pembayaran;
use App\Models\Peserta;


class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembayaran =  Pembayaran::with('peserta')->paginate(20);
        return view('dashboard.pembayaran.index',['acaras'=>[],'pembayarans'=>$pembayaran]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'peserta_id' => 'required',
            'punia'      => 'required',
            'file'       => 'required'
        ]);
        $peserta = Peserta::findOrFail($request->peserta_id);
        if(!$peserta)
        return back()->withInput($request->all())->with('notif-warning','Peserta Tidak di temukan');

        // dd($request->hasFile('file'));

        if($request->hasFile('file')){
            $file_image = Str::random(50).'.'.$request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/full',$file_image);
        }
        else {
            return back()->withInput($request->all())->with('notif-warning','Bukti Transfer di perlukan');
        }

        $pembayaran = new Pembayaran;
        $pembayaran -> peserta_id = strip_tags($request->peserta_id);
        $pembayaran -> nominal = strip_tags($request->punia);
        $pembayaran -> tanggal_bayar = now();

        $pembayaran -> bukti_transfer =  $file_image;
        // dd($pembayaran);
        $pembayaran -> save();

        // get Number Urut;

        $number_urut = Peserta::where('acara_id', $request->acara_id);
        if($request->jadwal_id)
            $number_urut->where('jadwal_id',$request->jadwal_id);
        else
            $number_urut->where('tanggal',$request->tanggal);

        $number_urut     = $number_urut->count();
        $new_number_urut = $number_urut>0? ($number_urut+1):1;


        $peserta->nomor_urut =  $new_number_urut;
        $peserta->sudah_bayar=true;
        $peserta->kode_bayar='';
        $peserta->save();

        return back()->with('notif-success','Pembayaran Teralah DI simpan');
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
        $pembayaran = Pembayaran::findOrFail($id);
        return view('dashboard.pembayaran.form',['peserta'=>$pembayaran->peserta,'pembayaran'=>$pembayaran]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        if($pembayaran){
            \Storage::delete('public/full/'.$pembayaran->bukti_transfer);

            $peserta = Peserta::findOrFail($pembayaran->peserta_id);
            $peserta->sudah_bayar = false;
            $peserta->nomor_urut = 0;
            $peserta->save();

            $pembayaran->delete();
        }
        return back()->with('notif-success','Pembayarana  telah di hapus');
    }

    public function uploadBuktiBayar(Request $request) {
        return 'delete';
    }
}
