@extends('layouts.front')

@section('body')
<div class="container">
    <x-hero-section :pengaturan="$pengaturan"/>

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
            @if ($errors->any())
                @php  $dataErrors = $errors->all();  @endphp
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <div class="row mt-4">

            <div class="col-lg-12">
                <h1>{{ $acara->name }}</h1>
                <h5>
                    <strong>Punia : {{ number_format($acara->punia,0,',','.')  }}</strong>
                </h5>
                <div class="pt-3 pb-3">
                    <x-share-link url="{{ url()->full() }}" />
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h5>{{ __('Penjelasan') }}</h5>
                            </div>
                            <div class="card-body">
                                {!! $acara->penjelasan !!}
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5>{{ __('Yang Di dapat') }}</h5>
                            </div>
                            <div class="card-body">
                                {!! $acara->yang_di_dapat !!}
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-warning">
                                <h5>{{ __('Yang Di bawa') }}</h5>
                            </div>
                            <div class="card-body">
                                {!! $acara->yang_di_bawa !!}
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h5>{{ __('Susunan Acara') }}</h5>
                            </div>
                            <div class="card-body">
                                {!! $acara->susunan_acara !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h5>Jadwal</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table1">
                                    <tbody>
                                        <x-table.jadwal-list :acara="$acara"/>
                                    </tbody>
                                </table>

                                @if($acara->sistem_jadwal == 'Terjadwal' && count($acara->jadwals) == 0)
                                    <div class="alert alert-warning">
                                        Belum ada jadwal kegiatan pada acara ini.
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if(count($acara->dokumentasi) > 0 )
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5>Dokumentasi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($acara->dokumentasi as $photo)
                                            <div class="col-lg-4">
                                                <a href="{{ route('cdn.image.thumbnail', $photo->url) }}" target="_blank">
                                                    <img src="{{ route('cdn.image.thumbnail', $photo->url) }}" alt="" class="img-fluid">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>


    </section>

    <section class="gallery">
        <div class="row">
            @if($acara->photos)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-info">
                        <h5>FOTO GALERI</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($acara->photos as $photo)
                                <div class="col-lg-4 mt-3">
                                    <img src="{{ route('cdn.image.thumbnail', $photo->url) }}" alt="" class="img-fluid">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($halaman && $halaman->metas)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-info">
                        <h5>VIDEO GALERI</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($halaman->metas as $key=>$vidio)
                            @if($vidio->meta_key =='vidio')
                            <div class="col-lg-4 embed-responsive embed-responsive-4by3 mt-3 ml-3">
                                <iframe class="embed-responsive-item" src="{{ $vidio->url }}"></iframe>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection

