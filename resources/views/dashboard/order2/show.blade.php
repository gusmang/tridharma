@extends('layouts.app')

@section('links')
@stop

@section('body')
    <div class="peserta">
        <div class="row">
            <div class="col">
                <h1>Detail Order</h1>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                Detail Peserta
            </div>
            <div class="card-body">
                
                <form method="post" action="{{ route('edit-order.update') }}">
                    <input type="hidden" id="hidden_index" name="hidden_index" value="{{ $peserta->id }}"  class="form-control" />
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{ $peserta->nama }}" name="t_nama_peserta" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tanggal Acara</label>
                        <div class="col-sm-8">
                            <input type="date" value="{{ $peserta->tanggal }}" class="form-control" name="t_tanggal_acara" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jumlah Peserta</label>
                        <div class="col-sm-8">
                            <input type="number" value="{{ $peserta->jumlah_peserta }}" class="form-control" name="t_jumlah_peserta" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{ $peserta->alamat }}" class="form-control" name="t_alamat_peserta" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tanggal Daftar</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{ $peserta->created_at }}" class="form-control" readonly />
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
                            <input type="text" value="{{ $peserta->sudah_bayar == 1 ? 'Sudah' : 'Belum' }}" class="form-control" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nomor Urut</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{ $peserta->nomor_urut }}" class="form-control" readonly />
                        </div>
                    </div>
                
                <!-- <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-8">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_pembayaran" class="btn btn-primary">Upload Bukti Bayar</a>
                    </div>
                </div> -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Update Data</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Daftar Pembayaran
            </div>
            <div class="card-body1">


                <table class="table table-responsive" id="myTable">
                    <thead>
                        <tr>
                            <th>Nominal</th>
                            <th>Tanggal Bayar</th>
                            <th>Bukti Transfer</th>
                            <th>Status Terima</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peserta->pembayaranList as $k => $v)
                            <tr>
                                <td>{{ $v->nominal }}</td>
                                <td>{{ $v->tanggal_bayar }}</td>
                                <td>
                                    <a href="{{ route('cdn.image.thumbnail', $v->bukti_transfer) }}" target="_blank">
                                        <img src="{{ route('cdn.image.thumbnail', $v->bukti_transfer) }}" alt="" class="img-fluid" width="200px">
                                    </a>
                                </td>
                                <td>
                                    @if($v->status_bayar == 0)
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($v->status_bayar == 1)
                                        <span class="badge badge-success">Diterima</span>
                                    @elseif($v->status_bayar == 2)
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('list-order.acc', [$peserta->id, $v->id]) }}" class="btn btn-success">Terima</a>
                                    <a href="{{ route('list-order.tolak', [$peserta->id, $v->id]) }}" class="btn btn-warning">Tolak</a>

                                    @if($v->status_bayar == 0)
                                        <form onsubmit="return confirm('Apakah anda yakin untuk menghapus data ini?');" action="{{ route('list-order.hapus-pembayaran', [$peserta->id, $v->id]) }}" method="post" style="display: inline-block;">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Hapus Data">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                        @endforeach

                        @if(count($peserta->pembayaranList) == 0)
                            <tr>
                                <td colspan="5">Belum ada Pembayaran</td>
                            </tr>
                        @endif

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <form action="{{ route('list-order.upload-bukti-bayar', $peserta->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="modal_pembayaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tanggal Bayar</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" required name="tanggal_bayar" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nominal</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" value="{{ $peserta->punia }}" required name="nominal" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Bukti Bayar</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" accept="image/*" required name="bukti_bayar" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Upload Bukti</button>
                    </div>
                </div>
            </div>
        </div>

    </form>


@endsection

@section('scripts')
    <script>

        var table = null;

        // $(function() {

        // });

        $('#myTable').DataTable( {
            responsive: true
        } );


    </script>
@endsection
