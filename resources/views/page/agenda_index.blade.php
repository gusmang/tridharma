@extends('layouts.front')

@section('body')
<div class="container">
    <x-hero-section :pengaturan="$pengaturan" />

    <div class="col-md-12 col-12" style="position:relative;">
        <input type="text" style="color:#000000;" value="<?php echo isset($_GET['sr']) ? $_GET['sr'] : ""; ?>" id="inputUpacara" class="form-control bg-white px-3 py-3" placeholder="Input Pencarian Upacara .." />

        <div style="position:absolute; right:40px; top:10px; font-size:21px;" onclick="searchData()">
            <i class="fa fa-search"></i>
        </div>
        <div style="position:absolute; right:20px; top:10px; font-size:21px;" onclick="searchData()">
            <a href="{{ url('/') }}"> X </a>
        </div>

    </div>

    <section class="mt-5">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <h1>Agenda Acara</h1>
                    <span>Daftar Kegiatan telah berlangsung</span>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="basic-url">Pilih Acara</label>
                                <select class="form-control" name="acara">
                                    <option value="">--Semua Acara--</option>
                                    @foreach($acaras as $acara)
                                    <option value="{{ $acara->id }}" {{ app('request')->input('acara') == $acara->id? "selected":'' }}>{{ $acara->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 xs-6">
                            <div class="form-group">
                                <label for="basic-url">Tanggal Awal</label>
                                <input type="date" name="tanggal_mulai" class="form-control" value="{{ app('request')->input('tanggal_mulai') }}">
                            </div>
                        </div>
                        <div class="col-lg-3  xs-6">
                            <div class="form-group">
                                <label for="basic-url">Tanggal Akhir</label>
                                <input type="date" name="tanggal_selesai" class="form-control" value="{{ app('request')->input('tanggal_selesai') }}">
                            </div>
                        </div>
                        <div class="col text-right">
                            <button type="submit" class="btn btn-info">Filter</button>
                            <a href="{{ route('agenda.index') }}" class="btn btn-success">Reset Filter</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="row clearfix">
            <div class="col-12">
                <div class="card-columns">
                    @foreach($peserta as $v)
                    <x-peserta-dokumentasi :peserta="$v"></x-peserta-dokumentasi>
                    @endforeach
                </div>
            </div>
        </div>

        @if(count($peserta) == 0)
        <div class="alert alert-warning">
            Belum ada Agenda berdasarkan data yang anda cari.
        </div>
        @endif
        @if($peserta->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pb-0">
                        {!! $peserta->links() !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

    </section>

</div>
@endsection
