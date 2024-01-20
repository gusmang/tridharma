@extends('layouts.app')

@section('links')
@stop

@section('body')
    <div class="peserta">
        <div class="row">
            <div class="col">
                <h1>Pembayaran Cash</h1>
            </div>
        </div>


        <div class="card">

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Transaksi</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="card-header">
                            Detail Peserta
                        </div>
                        <div class="card-body" id="daftar">
                            
                            <form method="post" action="{{ route('edit-order.pembayaran') }}">
                                <input type="hidden" id="hidden_index" name="hidden_index" value="{{ $peserta->id }}"  class="form-control" />
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $peserta->nama }}" name="t_nama_peserta" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tanggal Acara</label>
                                    <div class="col-sm-8">
                                        <input type="date" value="{{ $peserta->tanggal }}" class="form-control" name="t_tanggal_acara" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Jumlah Peserta</label>
                                    <div class="col-sm-8">
                                        <input type="number" value="{{ $peserta->jumlah_peserta }}" class="form-control" name="t_jumlah_peserta" readonly />
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
                                    <label class="col-sm-2 col-form-label">Nomor Urut</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $peserta->nomor_urut }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Punia</label>
                                    <div class="col-sm-8">
                                        Rp. {{ number_format(($peserta->punia-$peserta->kode_bayar),0,'.','.') }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Di Bayar</label>
                                    <div class="col-sm-8">
                                        Rp. {{ number_format(($summary[0]->total_nominal),0,'.','.') }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Sisa</label>
                                    <div class="col-sm-8">
                                        Rp. {{ number_format((($peserta->punia-$peserta->kode_bayar) - $summary[0]->total_nominal),0,'.','.') }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Jumlah Bayar</label>
                                    <div class="col-sm-8">
                                        <input type="number" max="<?php echo (($peserta->punia-$peserta->kode_bayar) - $summary[0]->total_nominal); ?>" value="0" class="form-control" name="t_jml_bayar" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tanggal Bayar</label>
                                    <div class="col-sm-8">
                                        <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="t_tanggal_bayar" />
                                        <input type="text" name="sisa_pembayaran" value="<?php echo (($peserta->punia-$peserta->kode_bayar) - $summary[0]->total_nominal); ?>" style="display:none;" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Catatan</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="" class="form-control" name="t_catatan" />
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Sudah Bayar</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $peserta->sudah_bayar == 1 ? 'Sudah' : 'Belum' }}" class="form-control" readonly />
                                    </div>
                                </div> -->
                                <!-- <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_pembayaran" class="btn btn-primary">Upload Bukti Bayar</a>
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-primary">Kirim Pembayaran</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="card">
                            <div class="card-header">
                                Daftar Pembayaran
                            </div>
                            <div class="card-body1" style="padding-bottom:20px;">

                                <div class="col-md-12">
                                    @php $no = 0 @endphp
                                    @foreach($cash_pay as $list)
                                    @php $no++; @endphp
                                        <div class="col-md-12" style="padding:20px 0; border-bottom:1px solid #EEEEEE;">
                                            <div style="padding:0 8px;">
                                                <h5 style="font-size:16px; font-weight:bold;">
                                                    Pembayaran # {{ $no }}<br />
                                                    <span style="font-size:13px;"> {{ $list->tanggal_bayar }} </span>
                                                </h5>
                                            </div>

                                            <div class="col-md-12 mt-4">
                                                <div class="row mb-2">
                                                    <div class="col-5">
                                                        Nominal Bayar
                                                    </div>
                                                    <div class="col-1">
                                                        :
                                                    </div>
                                                    <div class="col-6">
                                                        Rp. {{ number_format($list->nominal,0,'.','.') }}
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-5">
                                                        Sisa Bayar
                                                    </div>
                                                    <div class="col-1">
                                                        :
                                                    </div>
                                                    <div class="col-6">
                                                        Rp. {{ number_format(($peserta->punia - $summary[0]->total_nominal),0,'.','.') }}
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-5">
                                                        Penerima
                                                    </div>
                                                    <div class="col-1">
                                                        :
                                                    </div>
                                                    <div class="col-6">
                                                        {{ ucwords($list->name) }}
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-5">
                                                        Catatan
                                                    </div>
                                                    <div class="col-1">
                                                        :
                                                    </div>
                                                    <div class="col-6">
                                                        {{ $list->catatan }}
                                                    </div>
                                                </div>

                                                <div class="row mb-2">

                                                    <div class="col-5">
                                                        Status
                                                    </div>
                                                    <div class="col-1">
                                                        :
                                                    </div>
                                                    <div class="col-6">
                                                        @if($peserta->punia - $summary[0]->total_nominal > 0)
                                                            Belum Lunas
                                                        @else
                                                            Lunas
                                                        @endif
                                                    </div>
                                                </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                                <!-- <table class="table table-responsive" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Bayar</th>
                                            <th>Nominal</th>
                                            <th>Sisa Pembayaran</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cash_pay as $list)
                                            <tr>
                                                <td>{{ $list->created_at }}</td>
                                                <td>{{ number_format($list->nominal,0,',','.') }}</td>
                                                <td>{{ number_format(($peserta->punia - $list->nominal),0,',','.') }}</td>
                                                <td>{{ $list->catatan }}</td>
                                                <td> <i class="fa fa-eye"></i> Detail </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table> -->

                            </div>
                        </div>
                    </div>

                </div>

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
