@extends('layouts.front')

@section('body')
<div class="container">
    <x-hero-section :pengaturan="$pengaturan"/>
    
    <div class="row pb-10 text-center mb-10">
        <a href="<?php echo url('/'); ?>" target="_self" class="btn btn-primary">Halaman Utama</a>
    </div>
    
    @if(Request::query('telepon') != null)
        @if(count($peserta) == 0)
            <div class="alert alert-warning">
                Peserta tidak ditemukan berdasarkan telepon yang anda masukan
            </div>
        @else
            <div class="row mt-5 pt-3 pb-2">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            DOWNLOAD PIAGAM
                        </div>
                        <div class="card-body">
                            
                            <div class="alert alert-danger">
                            Piagam berhasil ditemukan, silahkan download... Geser kekanan untuk melihat tombol download pada nama peserta dibawah ini
                        </div>

                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Peserta</th>
                                        <th>Acara</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peserta as $k => $v)
                                        <tr>
                                            <td>{{ ($k + 1) }}</td>
                                            <td>{{ $v->nama }}</td>
                                            <td>{{ $v->acara->name }}</td>
                                            <td>{{ $v->tanggal }}</td>
                                            <td>{{ $v->StatusPeserta }}</td>
                                            <td>
                                                @if($v->StatusPeserta == "Selesai Kegiatan")
                                                    <a href="{{ route('konfirmasi.unduhSertifikat', $v->id) }}" target="_blank" class="btn btn-primary">Unduh Piagam</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>


        @endif

    @endif

    <form id="form-cari" method="GET">
        <div class="row mt-5 pt-3 pb-2">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        CARI PIAGAM
                    </div>
                    <div class="card-body">

                        <div class="alert alert-info">
                            Masukan nomor telepon anda kemudian tekan tombol cari untuk melihat data peserta. Piagam hanya dapat diunduh apabila anda sudah membayar dan kegiatan sudah selesai dilaksanakan.
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{ Request::query('telepon') }}" class="form-control" required name="telepon" />
                                <small class="small-2 text-danger">Isi Kode negara 62 diikuti nomor. Contoh:6281336...</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-success">Cari Peserta</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

    



</div>
@endsection


