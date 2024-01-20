@extends('layouts.app')

@section('links')
@stop

@section('body')
    <div class="peserta">
        <div class="row">
            <div class="col">
                <h1>Upload Dokumentasi Acara</h1>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                Detail Acara
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-8">
                        <input type="text" value="{{ $peserta->nama }}" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-8">
                        <input type="text" value="{{ $peserta->tanggal }}" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Telepon</label>
                    <div class="col-sm-8">
                        <input type="text" value="{{ $peserta->telpon }}" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Acara</label>
                    <div class="col-sm-8">
                        <input type="text" value="{{ $peserta->acara->name }}" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Punia</label>
                    <div class="col-sm-8">
                        <input type="text" value="{{ $peserta->punia }}" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Sudah Bayar</label>
                    <div class="col-sm-8">
                        <input type="text" value="{{ $peserta->sudah_bayar == 1 ? "Sudah" : "Belum" }}" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nomor Urut</label>
                    <div class="col-sm-8">
                        <input type="text" value="{{ $peserta->nomor_urut }}" class="form-control" readonly />
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Daftar Dokumentasi
                    </div>
                    <div class="card-body1">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>File Dokumentasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peserta->dokumentasi as $k => $v)
                                    <tr>
                                        <td>
                                            <a href="{{ route('cdn.image.thumbnail', $v->url) }}" target="_blank">
                                                <img src="{{ route('cdn.image.thumbnail', $v->url) }}" alt="" class="img-fluid" width="200px">
                                            </a>
                                        </td>

                                        <td>
                                            <form onsubmit="return confirm('Apakah anda yakin untuk menghapus data ini?');" action="{{ route('media.destroy', $v->id) }}" method="post" style="display: inline-block;">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Hapus Data">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach

                                @if(count($peserta->dokumentasi) == 0)
                                    <tr>
                                        <td colspan="2">Belum ada dokumentasi</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('media.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="model" value="dokumentasi_acara">
                            <input type="hidden" name="model_id" value="{{ $peserta->id }}">
                            <input type="hidden" name="is_photo" value="true">

                            <div class="form-group">
                                <label class="col-form-label">Upload Dokumentasi</label>
                                <input type="file" class="form-control" name="file" accept="image/*" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>



@endsection
