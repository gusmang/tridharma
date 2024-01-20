
@extends('layouts.app')
@section('links')
@endsection
@section('body')
<div class="row justify-content-center mt-3">
    @php $dataErrors= [];  @endphp
    @if ($errors->any())
        @php  $dataErrors = $errors->all();  @endphp
        <!-- <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> -->
    @endif
    <div class=" col-md-6 col-lg-6 pt-5">
        <a href="{{ route('pembayaran.index') }}" class="btn btn-info">{{ __('Kembali') }}</a>
        <div class="card mt-3">
            <div class="card-header">
            {{ __('Pembayaran Form') }}
            </div>

            <div class="card-body">
                <form action="{{ $pembayaran?route('pembayaran.update',$pembayaran->id):route('pembayaran.store') }}" method="post" class="">
                    {{ csrf_field() }}
                    @if($pembayaran)
                    {{ method_field('PUT') }}
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <tr><td>Nama Peserta</td><td>: {{ $peserta->nama }}</td> </tr>
                                <tr><td>Jumlah Peserta</td><td>:  {{ $peserta->jumlah_peserta }}</td> </tr>
                                <tr><td>Alamat</td><td>:  {{ $peserta->alamat }}</td> </tr>
                                <tr><td>Penanggung Jawab</td><td>:  {{ $peserta->penanggung_jawab }}</td> </tr>
                                <tr><td>Nominal</td><td>:  {{ $pembayaran->nominal }}</td> </tr>
                                <tr><td>Nomor Urut</td><td>:  {{ $peserta->nomor_urut }}</td> </tr>
                                <tr><td>Tanggal Bayar</td><td>:  {{ date("d M Y" ,strtotime($pembayaran->tanggal_bayar)) }}</td> </tr>
                                <tr><td>Bukti Bayar</td><td>:
                                    <img src="/storage/full/{{ $pembayaran->bukti_transfer }}" alt="" class="img-fluid" width="200px">
                                    <br/>
                                    <!-- <button class="btn btn-warning btn-sm mt-3">Ganti Bukti Pembayaran</button> -->
                                </td> </tr>
                            </table>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>

</div>

@endsection

