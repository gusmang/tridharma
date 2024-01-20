@extends('layouts.front')
@section('links')
{!! ReCaptcha::htmlScriptTagJsApi() !!}
@endsection
@section('body')
<div class="container">
    <x-hero-section :pengaturan="$pengaturan" />

    <div class="row">

        <div class="col-md-1 col-2 d-flex justify-content-center" style="height:55px; align-items:center;">
            <a href="{{ url('/') }}"> <i class="fa fa-home" style="font-size:36px;"></i> </a>
        </div>

        <div class="col-md-11 col-10" style="position:relative;">
            <input type="text" style="color:#000000;" value="<?php echo isset($_GET['sr']) ? $_GET['sr'] : ""; ?>" id="inputUpacara" class="form-control bg-white px-3 py-3" placeholder="Input Pencarian Upacara .." />

            <div style="position:absolute; right:40px; top:10px; font-size:21px;" onclick="searchData()">
                <i class="fa fa-search"></i>
            </div>
            <div style="position:absolute; right:20px; top:10px; font-size:21px;" onclick="searchData()">
                <a href="{{ url('/') }}"> X </a>
            </div>

        </div>

    </div>

    <section class="list-acara mt-5">
        @php $dataErrors= []; @endphp
        @if ($errors->any())
        @php $dataErrors = $errors->all(); @endphp
        <!-- <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> -->
        @endif
        <form action="{{ route('daftar.store') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h1>Form Pendaftaran {{ $acara->name }}</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Acara</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value="{{ $acara->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Tanggal/Jadwal</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="acara_id" value="{{ $acara->id }}">
                                    <input type="hidden" name="jadwal_id" value="{{ $jadwal?$jadwal->id:'' }}">
                                    @if($jadwal)
                                    <input type="text" readonly class="form-control-plaintext" name="tanggal" value="{{ date('d-m-Y',strtotime($jadwal->tanggal)) }}" required>
                                    <input type="text" readonly class="form-control-plaintext" value="{{ $jadwal->dinan }}">
                                    @else
                                    <div class="row">
                                        <div class="col-md-3">
                                            <x-form.input-field label="" type="date" name="tanggal" filename="tanggal" :value="[old('tanggal'), '']" :errors="$dataErrors" :required="true" />
                                        </div>
                                        <!-- <div class="col-md-4">
                                        <input type="text"  class="form-control" value="" name="dinan" placeholder="Saptawara, Panceware , Wuku" required>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#CariTanggal">Cari Tanggal</button>
                                    </div> -->
                                    </div>
                                    <small>Masukkan tanggal yang anda inginkan untuk acara ini kalo tidak tau bisa gunakan tmbol cari tanggal</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <x-form.input-field label="Nama Peserta" type="text" name="namaPeserta" filename="nama peserta" :value="[old('namaPeserta'),'']" :errors="$dataErrors" :required="true" />
                                </div>
                                <div class="col-md-4">
                                    <x-form.input-field label="Jumlah Peserta" type="number" name="jumlahPeserta" filename="jumlah peserta" :value="[old('jumlahPeserta'),'1']" :errors="$dataErrors" :required="true" />
                                </div>
                                @if($acara->sistem_kepesertaan !='Satu Orang')
                                <!-- <div class="col-12 listPeserta">
                                <x-form.input-field
                                    label="List Peserta"
                                    type="text"
                                    name="listPeserta"
                                    filename="list peserta"
                                    :value="[old('listPeserta'),'']"
                                    :errors="$dataErrors"/>
                                    <small class="small-2">pisahkan nama peserta dengan tanda koma(,) tanpa nama peserta yg di tulis di atas</small>

                            </div> -->
                                @endif
                                <div class="col-12">
                                    <x-form.input-field label="Alamat" type="text" name="alamat" filename="alamat" :value="[old('alamat'),'']" :errors="$dataErrors" :required="true" />
                                </div>
                                <div class="col-md-6 form-telpon">
                                    <x-form.input-field label="Telp/Wa" type="number" name="telpon" filename="telpon" :value="[old('telpon'),'']" :errors="$dataErrors" :required="true" />
                                    <small class="small-2 text-danger">Isi Kode negara 62 diikuti nomor ana ex:6281336...</small>
                                    <br>
                                    <small class="text-danger"></small>
                                </div>
                                <div class="col-md-12 mt-4 form-telpon">
                                    <?php echo captcha_img('flat'); ?> <br> 
                                    <input type="text" class="mt-4" label="Captcha" type="text" name="captcha" id="captcha" required="required" 
                                        style="padding: 5px; border: 1px solid #DDDDDD;" />
                                </div>
                                <!-- <div class="col-md-12">
                                <x-form.input-field
                                    label="Penanggung Jawab"
                                    type="text"
                                    name="penanggungJawab"
                                    filename="penanggung jawab"
                                    :value="[old('penanggungJawab'),'']"
                                    :errors="$dataErrors"
                                    :required="true"/>
                            </div>
                            <div class="col-md-12">
                                <x-form.textarea
                                    label="Catatan"
                                    name="catatan"
                                    filename="catatan"
                                    :value="[old('catatan'),'']"
                                    :errors="$dataErrors"/>
                            </div> -->
                                {{-- <div class="col-lg-12">
                                {!! htmlFormSnippet() !!}
                                @if ($errors->any())
                                    @php  $dataErrors = $errors->all();  @endphp
                                    @if(str_contains($error,'g-recaptcha-response'))
                                    <span class="text-danger"> Silahkan Centang telebih dahulu</span>
                                    @endif
                                @endif
                            </div> --}}
                            </div>

                        </div>
                        <div class="card-footer text-muted bg-info">
                            <button type="submit" class="btn btn-warning">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </section>

    <!-- Modal -->
    <!-- <div class="modal fade" id="CariTanggal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cari Tanggal Terdekat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cari-tanggal') }}" method="post" id="getTanggal">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Panca Wara</label>
                                  <select name="sapta" class="form-control">
                                        <option value="Redite">Redite</option>
                                        <option value="Soma">Soma</option>
                                        <option value="Anggara">Anggara</option>
                                        <option value="Buda">Buda</option>
                                        <option value="Respati">Respati</option>
                                        <option value="Sukra">Sukra</option>
                                        <option value="Saniscara">Saniscara</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Panca Wara</label>
                                  <select name="panca" class="form-control">
                                    <option value="Paing">Paing</option>
                                    <option value="Pon">Pon</option>
                                    <option value="Wage">Wage</option>
                                    <option value="Kliwon">Kliwon</option>
                                    <option value="Umanis (Legi)">Umanis (Legi)</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-3 wuku-container">

                            </div>
                            <div class="col-md-3 pt-4">
                                <button type="submit" class="btn btn-info">Cari</button>
                            </div>
                        </div>
                    </form>
                    <div class="row tanggal-container">

                    </div>
                </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div> 
            </div>
        </div>
    </div> -->

</div>
@endsection

@section('scripts')
<script>
    @if(old('acara_id')) {
        $('.jadwal-' + {
            {
                old('acara_id')
            }
        }).show();
    }
    @endif

    $('.listPeserta').hide();

    jQuery(document).ready(function($) {
        $('#getTanggal').submit(function(e) {
            e.preventDefault();
            $('#getTanggal button').html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  <span class="sr-only">Loading...</span>')
            $.post($(this).attr('action'), $(this).serialize(), function(data) {
                if (jQuery('[name="wuku"]').length == 0) {
                    $('.wuku-container').html('<label for="">Wuku</label>' + data);
                    $('#getTanggal .wuku-container select').addClass('form-control');
                } else {
                    $html = '';
                    for (let index = 0; index < data.length; index++) {
                        $html += '<div class="col-md-2"> <span wuku="' + data[index][1] + '" tanggal="' + data[index][0] + '"></span> </div>';
                    }
                    $('.tanggal-container').html(data);
                }
                $('#getTanggal button').html('Cari')
            }).fail(function() {
                $('#getTanggal button').html('Cari');
                alert('server error');
                $('.tanggal-container').html('');
            })
        })
        $(document).on('click', '.tanggal-weton', function(e) {
            let tanggal = new Date($(this).attr('tanggal'));
            month = tanggal.getMonth() < 9 ? '0' + (tanggal.getMonth() + 1) : (tanggal.getMonth() + 1);
            date = tanggal.getDate() < 10 ? '0' + tanggal.getDate() : tanggal.getDate();
            tanggal = tanggal.getFullYear() + '-' + month + '-' + date;
            const weton = $(this).attr('weton');
            $('[name="tanggal"]').val(tanggal);
            $('[name="dinan"]').val(weton);
            $('#CariTanggal').modal('hide');

        })
        $('[name="jumlahPeserta"]').keyup(function() {
            if ($(this).val() > 1)
                @if($acara -> sistem_kepesertaan != 'Satu Orang')
            $('.listPeserta').show();
            @else
            $(this).val(1);
            @endif
            else
                $('.listPeserta').hide();
        });
        $('[name="telpon"]').change(function() {
            let value = $(this).val();
            if (!value.includes('62') || value.length == 0) {
                $(this).val('');
                $('.form-telpon .text-danger').html('Nomor telpun harus berisi kode negara 62');
                $('.form-telpon input').addClass('border-danger');
            } else {
                $('.form-telpon .text-danger').html('');
                $('.form-telpon input').removeClass('border-danger');
            }
        });
    })

</script>
@endsection
