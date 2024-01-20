<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Acara;
use App\Traits\ResponseTrait;
use App\Traits\Models\AcaraTrait as AcaraRepositories;

class AcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ResponseTrait, AcaraRepositories;

    public function index(Request $request)
    {
        $acaras = Acara::orderBy('Order', 'ASC');

        if ($request->sistem_jadwal != null) {
            $acaras->where('sistem_jadwal', '=', $request->sistem_jadwal);
        }
        $acaras = $acaras->get();
        return view('dashboard.acara.index', ['title' => 'Acara', 'acaras' => $acaras]);
    }

    public function getAcara(Request $request)
    {
        $acaras = Acara::where("id", $request->acara_id)->first();

        return response()->json(['data' => $acaras, 'status' => 200, 'yang_di_bawa' =>  strip_tags(html_entity_decode($acaras->yang_di_bawa))]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.acara.form', ['title' => 'Form Acara', 'acara' => []]);
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
            'namaAcara'         => 'required',
            'urutanTampilan'    => 'required|Integer|max:100',
            'penjelasan'        => 'required',
            'yangDidapat'       => 'required',
            'yangDibawa'        => 'required',
            'susunanAcara'      => 'required',
            'systemJadwal'      => 'required|in:"Setiap Hari","Terjadwal"',
            'sistemKepesertaan' => 'required|in:"Satu Orang","Lebih Dari satu orang"',
            'punia'             => 'required',
        ]);


        $slug = Str::slug(strip_tags($request->namaAcara));

        // check slug duplicate
        $get_acara = Acara::where('slug', $slug)->count();
        if ($get_acara) {
            $count = $get_acara + 1;
            $slug = $slug . '_' . $count;
        }

        // dd($request->all());
        $acara = new Acara;
        $acara->name = strip_tags($request->namaAcara);
        $acara->slug = $slug;
        $acara->order = strip_tags($request->urutanTampilan);
        $acara->penjelasan = strip_tags($request->penjelasan, '<ul><ol><li><b><i>  ');
        $acara->yang_di_dapat = strip_tags($request->yangDidapat, '<ul><ol><li><b><i>  ');
        $acara->yang_di_bawa = strip_tags($request->yangDibawa, '<ul><ol><li><b><i>    ');
        $acara->susunan_acara = strip_tags($request->susunanAcara, '<ul><ol><li><b><i> ');
        $acara->sistem_jadwal = strip_tags($request->systemJadwal);
        $acara->sistem_kepesertaan = strip_tags($request->sistemKepesertaan);
        $acara->punia = strip_tags($request->punia);
        $acara->vidios = strip_tags($request->vidios);
        $acara->status_slider = $request->status_slider == 1 ? 1 : 0;
        $acara->save();

        return redirect()->route('acara.edit', $acara->id)->with($this->response('Save Data success', 'success'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $acara =  $this->getAcaraById($id);
        return view('dashboard.acara.show', ['title' => 'Detail Acara', 'acara' => $acara]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $acara =  $this->getAcaraById($id);
        // dd($acara);
        return view('dashboard.acara.form', ['title' => 'Form Acara', 'acara' => $acara]);
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
            'namaAcara'         => 'required|',
            'urutanTampilan'    => 'required',
            'penjelasan'        => 'required',
            'yangDidapat'       => 'required',
            'yangDibawa'        => 'required',
            'susunanAcara'      => 'required',
            'systemJadwal'      => 'required|in:"Setiap Hari","Terjadwal"',
            'sistemKepesertaan' => 'required|in:"Satu Orang","Lebih Dari satu orang"',
            'punia'             => 'required',
        ]);
        $slug = Str::slug(strip_tags($request->namaAcara));

        // check slug duplicate
        $get_acara = Acara::where([['id', '<>', $id], ['slug', $slug]])->count();
        if ($get_acara) {
            $count = $get_acara + 1;
            $slug = $slug . '_' . $count;
        }

        // dd($request->all());
        $acara = Acara::findOrFail($id);
        $acara->name = strip_tags($request->namaAcara);
        $acara->slug = $slug;
        $acara->order = strip_tags($request->urutanTampilan);
        $acara->penjelasan = strip_tags($request->penjelasan, '<ul><ol><li><b><i><strong><em>');
        $acara->yang_di_dapat = strip_tags($request->yangDidapat, '<ul><ol><li><b><i><strong><em>');
        $acara->yang_di_bawa = strip_tags($request->yangDibawa, '<ul><ol><li><b><i><strong><em>');
        $acara->susunan_acara = strip_tags($request->susunanAcara, '<ul><ol><li><b><i><strong><em>');
        $acara->sistem_jadwal = strip_tags($request->systemJadwal);
        $acara->sistem_kepesertaan = strip_tags($request->sistemKepesertaan);
        $acara->punia = strip_tags($request->punia);
        $acara->vidios = strip_tags($request->vidios);
        $acara->status_slider = $request->status_slider == 1 ? 1 : 0;
        $acara->save();


        return back()->with('notif-success', 'Update Data success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $acara = Acara::findOrFail($id);

        $acara->delete();

        return back()->with('notif-success', 'Acara sudah di hapus');
    }

    public function cariAcara(Request $request)
    {
        // dd('fgdf');
        $acara = Acara::where('name', 'like', '%' . $request->keyword . "%")->with('jadwals', function ($query) {
            $query->select('id', 'tanggal', 'dinan', 'jumalah_peserta');
        })->get();
        return response()->json($acara);
    }
}
