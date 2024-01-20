@extends('layouts.app')

@section('body')
@php $dataErrors= [];  @endphp
@if ($errors->any())
    @php $dataErrors= $errors->all();  @endphp
@endif
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="form-inline mb-3">
            <a href="{{ route('peserta.index') }}" class="btn btn-info ">Kembali</a>

            @if($peserta)
                <x-form.delete-button url="{{ route('peserta.destroy', $peserta->id) }}" id="{{$peserta->id}}"/>
            @endif
        </div>

        <form action="{{ $peserta? route('peserta.update', $peserta->id):route('peserta.store') }}" class="form" method="post">
        {{ csrf_field() }}
        @if($peserta)
        {{ method_field('PUT') }}
        @endif
        <div class="card">
            <div class="card-header bg-info">
                <h1>Form Peserta @if($peserta) ({{ $peserta->nomor_urut }}) @endif</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <x-form.input-field
                            label="Tanggal"
                            type="date"
                            name="tanggal"
                            filename="tanggal"
                            :value="[old('tanggal'),$peserta? $peserta->tanggal:'']"
                            :errors="$dataErrors"
                            :required="true"/>
                        <input type="text" readonly class="form-control-plaintext ml-2 jadwalDinan" name="jadwalDinan" value="{{ old('jadwalDinan')? old('jadwalDinan') : ($peserta?($peserta->jadwal?$peserta->jadwal->dinan:''):'') }}" required>
                        <input type="hidden" name="jadwal_id" value="{{ old('jadwal_id')? old('jadwal_id') : ($peserta?$peserta->jadwal_id:'') }}">
                        <input type="hidden" name="acara_id" value="{{ old('acara_id')? old('acara_id'):($peserta?$peserta->acara_id:'') }}">
                    </div>
                    <div class="@if($peserta) col-md-10 @else col-12 @endif">
                        <x-form.input-field
                            label="Nama Peserta"
                            type="text"
                            name="namaPeserta"
                            filename="nama peserta"
                            :value="[old('namaPeserta'),$peserta? $peserta->nama:'']"
                            :errors="$dataErrors"/>
                    </div>
                    @if($peserta)
                    <div class="col-md-2">
                       <div class="form-group">
                         <label for="">Nomor Urut</label>
                         <input type="text"
                           class="form-control-plaintext" readonly value={{ $peserta->nomor_urut }}>
                       </div>
                    </div>
                    @endif
                    <div class="col-md-4">
                        <x-form.input-field
                            label="Jumlah Peserta"
                            type="number"
                            name="jumlahPeserta"
                            filename="jumlah peserta"
                            :value="[old('jumlahPeserta'),$peserta? $peserta->jumlah_peserta:'']"
                            :errors="$dataErrors"/>
                    </div>
                    <div class="col-12 listPeserta">
                        <x-form.input-field
                            label="List Peserta"
                            type="text"
                            name="listPeserta"
                            filename="list peserta"
                            :value="[old('listPeserta'),$peserta? $peserta->listPeserta:'']"
                            :errors="$dataErrors"/>
                            <small class="small-2">pisahkan nama peserta dengan tanda koma(,) tanpa nama peserta yg di tulis di atas</small>

                    </div>
                    <div class="col-12">
                        <x-form.input-field
                            label="Alamat"
                            type="text"
                            name="alamat"
                            filename="alamat"
                            :value="[old('alamat'),$peserta? $peserta->alamat:'']"
                            :errors="$dataErrors"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input-field
                            label="Telp/Wa"
                            type="number"
                            name="telpon"
                            filename="telpon"
                            :value="[old('telpon'),$peserta? $peserta->telpon:'']"
                            :errors="$dataErrors"/>
                            <small class="small-2">Isi Kode negara 62 diikuti nomor ana ex:6281336...</small>
                    </div>
                    <div class="col-md-12">
                        <x-form.input-field
                            label="Penanggung Jawab"
                            type="text"
                            name="penanggungJawab"
                            filename="penanggung jawab"
                            :value="[old('penanggungJawab'),$peserta? $peserta->penanggung_jawab:'']"
                            :errors="$dataErrors"/>
                    </div>
                    <div class="col-md-12">
                        <x-form.textarea
                            label="Catatan"
                            name="catatan"
                            filename="catatan"
                            :value="[old('catatan'),$peserta? $peserta->catatan:'']"
                            :errors="$dataErrors"/>
                    </div>
                </div>

            </div>
            <div class="card-footer text-muted">
                <button type="submit" class="btn btn-info">Simpan</button>
            </div>
        </div>
        </form>
    </div>

    <div class="col-md-4 pt-1">
        <div class="card mt-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Pilih Acara</label>
                          <select class="form-control selectAcara">
                            <option> </option>
                            @foreach($acaras as $acara)
                            <option value="{{ $acara->id }}" {{ old('acara_id')? (old('acara_id')==$acara->id ? 'selected':'') : ( $peserta ? ($peserta->acara_id == $acara->id ? 'selected':''):'' ) }}>{{ $acara->name }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col-12 table-responsive" style="max-height:300px;overflow:auto;">
                        <table class="table table1 tableAcara">
                            <thead>
                                <th>Tanggal</th>
                                <th>Detail</th>
                                <th>Peserta</th>
                                <th></th>
                            </thead>
                            <tbody >
                            @foreach($acaras as $acara)
                                @foreach($acara->jadwals as $jadwal)
                                <tr class=" jadwal jadwal-{{ $acara->id }}"  style="display:none">
                                    <td>{{ $jadwal->tanggal }}</td>
                                    <td>{{ $jadwal->dinan }}</td>
                                    <td>{{ $jadwal->jumlah_peserta }}</td>
                                    <td> <button class="btn btn-info pilihJadwal" data="{{ $jadwal }}">Pilih</button> </td>
                                </tr>
                                @endforeach

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{--
        @if($peserta)
            <div class="card">
                <div class="card-header bg-info">
                    Pembayaran
                </div>
                <div class="card-body">
                    @if($peserta->pembayaran)
                    <img src="{{ asset('storage/full/'.$peserta->pembayaran->bukti_transfer) }}" alt="" class="img-fluid">
                    <form action="{{ route('pembayaran.destroy',$peserta->pembayaran->id) }}" method="post" >
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="btn btn-danger mt-3">x</button>
                    </form>
                    @else
                    <form action="{{ route('pembayaran.store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="peserta_id" value="{{ $peserta->id }}">
                    <div class="form-group">
                    <label for="">Punia</label>
                    <input type="text"
                        class="form-control" name="punia" value="{{ $peserta->punia }}">
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <x-form.input-field
                                label="Bukti transfer"
                                type="file"
                                name="file"
                                filename="file"
                                :value="[old('file'),'']"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div>
                        <div class="col-sm-2 pt-4">
                            <button type="submit" class="btn btn-info mt-2">Simapn</button>
                        </div>
                    </div>
                    </form>
                    @endif

                </div>
            </div>
        @endif
            --}}

    </div>
</div>
@endsection
@section('scripts')
<script>
    @if(old('acara_id')){
        $('.jadwal-'+{{old('acara_id')}}).show();
    }
    @endif

    $('.listPeserta').hide();

    jQuery(document).ready(function($){
        $('form').submit(function(e){
            if(!$('[name="acara_id"]').val()){
                toastr['warning']('Pilih acara terlebih dahulu');
                e.preventDefault();
            }

            if(jQuery('.jadwal[style=""]').length>0 && !$('[name="jadwal_id"]').val()){
                toastr['warning']('Pilih tanggal acara terlebih dahulu');
                e.preventDefault();
            }

        })
        $('.selectAcara').change(function(){
            const id = $(this).val();
            $('.jadwal').hide();
            $('.jadwal-'+id).show();
            $('[name="acara_id"]').val(id);
        })
        $('.pilihJadwal').click(function(){
            let data = JSON.parse($(this).attr('data'));
            $('[name="tanggal"]').val(data.tanggal);
            $('.jadwalDinan').val(data.dinan);
            $('[name="jadwal_id"]').val(data.id);
        });
        $('[name="jumlahPeserta"]').keyup(function(){
            if($(this).val()>1)
                $('.listPeserta').show();
            else
                $('.listPeserta').hide();
        });
        $('[name="telpon"]').change(function(){
            let value = $(this).val();
            if(!value.includes('62')){
                toastr['warning']('Nomor telpun harus berisi kode negara 62');
                $(this).val('');
            }
        });
    })


</script>
@endsection
