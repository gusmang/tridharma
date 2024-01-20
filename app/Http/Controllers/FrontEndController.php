<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Meta;
use App\Models\Halaman;
use App\Models\Acara;
use App\Models\JadwalAcara;
use App\Models\Pembayaran;
use App\Models\Peserta;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\cash_payment;
use App\Models\User;

use App\Traits\FrontEnd;
use App\Traits\Models\AcaraTrait as AcaraRepositories;
use Illuminate\Support\Facades\Storage;

class FrontEndController extends Controller
{
    use FrontEnd, AcaraRepositories;

    public function index(Request $request)
    {

        // get homepage
        $halaman_depan = Halaman::where('is_homepage', true)->with('metas')->first();
        $halaman_id = $halaman_depan ? $halaman_depan->id : 0;

        // get all event
        if (!isset($request->sr)) {
            $acaras = $this->getAllAcaraWith();
        } else {
            $acaras = $this->getAcaraByName($request->sr);
            // print_r($acaras);
            // die();
        }

        if (!$acaras)
            abort(404);
        // dd($halaman_depan);

        $slider = Acara::where('status_slider', '=', 1)
            ->orderBy('order')
            ->get();


        $dokumentasi = Acara::select(['acaras.*'])
            ->join('media', 'media.mediable_id', '=', 'acaras.id')
            ->where('mediable_type', '=', 'dokumentasi_acara')
            ->orderBy('media.id', 'desc')
            ->groupBy('acaras.id')
            ->get();


        return view('page.index', ['pengaturan' => $this->getPengaturan($halaman_id), 'acaras' => $acaras, 'halaman' => $halaman_depan, 'menus' => $this->getMenus(), 'slider' => $slider, 'dokumentasi' => $dokumentasi]);
    }

    public function update_penerimas()
    {
        $cash_pay = cash_payment::all();
        foreach ($cash_pay as $pays) {
            $users = User::where("id", $pays->id_penerima)->firstOrfail();

            $updates = cash_payment::where("id", $pays->id)->update(["nama_penerima" => $users->name]);
        }
    }

    public function acara($slug)
    {

        $acara = $this->getAcaraBySlug($slug);
        if (!$acara)
            abort(404);

        $pengaturan = [];
        $halaman_id = $acara->halaman ? $acara->halaman->id : 0;
        $metas = Meta::whereIn('halaman_id', [0, $halaman_id])->get();

        foreach ($metas as $key => $meta) {
            $pengaturan[$meta->meta_key] = $meta->meta_value;
        }
        $halaman = [];
        if ($halaman_id)
            $halaman = Halaman::whereId($halaman_id)->with('metas')->first();
        return view('page.acara', ['title' => $acara->name, 'pengaturan' => $pengaturan, 'acara' => $acara, 'menus' => $this->getMenus(), 'halaman' => $halaman]);
    }

    public function daftar($acara_id, $jadwal_id = null)
    {


        $acara = Acara::findOrFail($acara_id);

        $jadwal = JadwalAcara::whereId($jadwal_id)->where('acara_id', $acara_id)->first();
        // dd(!$jadwal &&$acara->sistem_jadwal=='Terjadwal');
        if (!$jadwal && $acara->sistem_jadwal == 'Terjadwal')
            abort(404);

        return view('page.daftar', ['acara' => $acara, 'pengaturan' => $this->getPengaturan(), 'jadwal' => $jadwal, 'menus' => $this->getMenus()]);
    }

    public function daftarStore(Request $request)
    {
        $request->validate([
            'namaPeserta'       => 'required',
            'acara_id'          => 'required',
            'jumlahPeserta'     => 'required|Integer|min:1|max:10',
            'alamat'            => 'required|String',
            'telpon'            => 'required|Integer',
            'captcha' => 'required|captcha',
            //'penanggungJawab'   =>'required|String|min:3',
            'tanggal'           => 'required',
            // 'g-recaptcha-response' => 'recaptcha',

        ]);
        

        $acara = Acara::whereId($request->acara_id)->first();

        $code =  rand(111, 999);

        $new_punia = $acara->punia + $code;

        $peserta = new Peserta;
        $peserta->acara_id           = $acara->id;

        if ($request->jadwal_id)
            $peserta->jadwal_id          = strip_tags($request->jadwal_id);

        $peserta->tanggal            = date("Y-m-d", strtotime($request->tanggal));
        $peserta->nama               = strip_tags($request->namaPeserta);
        $peserta->jumlah_peserta     = strip_tags($request->jumlahPeserta);

        if ($request->listPeserta)
            $peserta->list_peserta   = strip_tags($request->listPeserta);

        $peserta->alamat             = strip_tags($request->alamat);
        $peserta->penanggung_jawab   = strip_tags($request->penanggungJawab);
        $peserta->telpon             = strip_tags($request->telpon);
        $peserta->catatan            = strip_tags($request->catatan);
        $peserta->punia              = $new_punia;
        $peserta->nomor_urut         = 0;
        $peserta->kode_bayar         = $code;
        // dd($peserta);
        $peserta->save();

        $peserta = Peserta::whereId($peserta->id)->with('acara', 'jadwal')->first();

        return redirect()->route('daftar.success')->with('peserta', $peserta);
        // }
        // else
        // {
        //     return back()->withInput($request->all())->with('notif-warning','Validasi recapca gagal');
        // }


    }

    public function daftarSuccess()
    {

        if (!\Session::has('peserta'))
            abort(404);

        $pengaturan = [];
        $metas = Meta::whereIn('halaman_id', [0])->get();
        foreach ($metas as $key => $meta) {
            $pengaturan[$meta->meta_key] = $meta->meta_value;
        }


        return view('page.daftar-success', ['pengaturan' => $pengaturan, 'menus' => $this->getMenus()]);
    }

    public function code()
    {
        $codes = rand(100, 999);
        $repeat = true;
        while ($repeat != false) {
            $peserta = Peserta::where('kode_bayar', $codes)->first();
            if ($peserta)
                $codes = rand(100, 999);
            else
                $repeat = false;
        }
        return $codes;
    }



    public function konfirmasiPembayaran(Request $request)
    {
        $halaman_id     = 0;
        $pengaturan     = $this->getPengaturan($halaman_id);
        $peserta        = null;
        $jumlah_tagihan = $request->jumlah_tagihan;
        $jmlBayar       = 0;
        if ($jumlah_tagihan != null) {
            $peserta = Peserta::where('punia', '=', $jumlah_tagihan)
                ->first();
            if (isset($peserta)) {
                $jmlBayar = Pembayaran::where("peserta_id", $peserta->id)->where("nominal", $request->jumlah_tagihan)->count();
            } else {
                $jmlBayar = 0;
            }
        }



        //$cekConfirm = Pembayaran::where("nominal" , $jumlah_tagihan)->where("status_bayar" , 0)->count();
        return view('page.konfirmasi-pembayaran', ['pengaturan' => $pengaturan, 'menus' => $this->getMenus(), 'peserta' => $peserta, 'jmlBayar' => $jmlBayar]);
    }


    public function konfirmasiPembayaranStore(Request $request)
    {
        $request->validate([
            'peserta_id'    => 'required',
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
        //$tanggal = date('Y-m-d', strtotime($date));
        $tanggal = $request->tanggal_bayar;

        $jmlBayar = Pembayaran::where("peserta_id", $peserta->id)->where("nominal", $request->nominal)->count();

        if ($jmlBayar > 0) {
            return back()->withInput($request->all())->with('notif-warning', 'Bukti Pembayaran sudah dikirim. Silakan tunggu verifikasi lebih lanjut.');
        }

        Pembayaran::create([
            'peserta_id'     => $peserta->id,
            'nominal'        => $request->nominal,
            'tanggal_bayar'  => $tanggal,
            'bukti_transfer' => $file_image,
            'status_bayar'   => 0
        ]);

        return redirect()->route('konfirmasi.pembayaran')->with('notif-success', "Pembayaran berhasil disimpan. Mohon menunggu konfirmasi");
    }

    public function cekPembayaran(Request $request)
    {
        $jmlBayar = Pembayaran::join("pesertas", "pesertas.id", "pembayarans.peserta_id")->whereDate("pesertas.tanggal", '>=', date("Y-m-d"))->where("pembayarans.nominal", $request->kode)->count();

        return response()->json(["status" => 200, "message" => "Nominal ini sudah melakukan konfirmasi bayar via Transfer. Mohon Menunggu proses validasi dari admin.", "jml" => $jmlBayar]);
    }


    public function sertifikat(Request $request)
    {
        $halaman_id     = 0;
        $pengaturan     = $this->getPengaturan($halaman_id);

        $peserta  = [];
        $pdf_path = null;

        $telepon = $request->telepon;

        if ($telepon != null) {
            $peserta = Peserta::where('telpon', '=', $telepon)
                ->where('sudah_bayar', '=', 1)
                ->where('tanggal', '<', date("Y-m-d"))
                ->get();
        }

        return view('page.sertifikat', ['pengaturan' => $pengaturan, 'menus' => $this->getMenus(), 'peserta' => $peserta, 'pdf_path' => $pdf_path]);
    }


    public function unduhSertifikat($id_peserta)
    {
        $peserta = Peserta::findOrFail($id_peserta);
        if ($peserta->StatusPeserta == 'Selesai Kegiatan') {
            $halaman_id = 0;

            $pengaturan     = $this->getPengaturan($halaman_id);

            $feature_image_path = \Storage::path('public/full/' . $pengaturan['feature_image']);
            $logo_image_path    = \Storage::path('public/full/' . $pengaturan['logo']);
            $pdf = Pdf::loadView('pdf.sertifikat', compact('peserta', 'pengaturan', 'feature_image_path', 'logo_image_path'));
            $pdf->save(public_path('sertifikat_file/' . $peserta->id . ".pdf"));
            $pdf_path = asset('sertifikat_file/' . $peserta->id . ".pdf");

            return $pdf->download("Sertifikat {$peserta->nama}.pdf");
        } else {
            abort(404);
        }
    }


    public function agendaIndex(Request $request)
    {

        $halaman_depan = Halaman::where('is_homepage', true)->with('metas')->first();
        $halaman_id    = $halaman_depan ? $halaman_depan->id : 0;
        $acara =

            $peserta = Peserta::select([
                'pesertas.created_at',
                'pesertas.id',
                'pesertas.tanggal',
                'pesertas.nama',
                'pesertas.penanggung_jawab',
                'pesertas.jumlah_peserta',
                'pesertas.alamat',
                'pesertas.telpon',
                'pesertas.sudah_bayar',
                'pesertas.nomor_urut',
                'acaras.name',
            ])
            ->join('acaras', 'pesertas.acara_id', '=', 'acaras.id')
            ->join('media', 'media.mediable_id', '=', 'pesertas.id')
            ->where([
                'media.mediable_type' => 'dokumentasi_acara'
            ])->orderBy('pesertas.tanggal', 'desc')
            ->groupBy('pesertas.id');

        if ($request->acara != null) {
            $peserta->where('pesertas.acara_id', '=', $request->acara);
        }

        if ($request->tanggal_mulai != null) {
            $peserta->where('pesertas.tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->tanggal_selesai != null) {
            $peserta->where('pesertas.tanggal', '>=', $request->tanggal_selesai);
        }

        $peserta = $peserta->paginate(10);

        $acaras = Acara::orderBy('order', 'ASC')->get(['id', 'name']);

        return view('page.agenda_index', ['pengaturan' => $this->getPengaturan($halaman_id), 'peserta' => $peserta, 'halaman' => $halaman_depan, 'menus' => $this->getMenus(), 'acaras' => $acaras]);
    }
}
