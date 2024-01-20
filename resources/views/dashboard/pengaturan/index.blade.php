
@extends('layouts.app')
@section('links')
<script src="https://cdn.tiny.cloud/1/7hvgpp2t8p14a5hcbrgxhv7u85cgijjwsqkyrx61tfwwgru1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
@section('body')
<form action="{{ route('pengaturan.store') }}" method="post"  enctype="multipart/form-data">
{{ csrf_field() }}
@if($datas)
{{ method_field('PUT') }}
@endif
<div class="row justify-content-center  mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="col">{{ __('Pengaturan') }}</div>
            </div>
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
            <div class="card-body">
                    <x-form.input-field
                        label="Nama Aplikasi"
                        type="text"
                        name="namaAplikasi"
                        filename="nama aplikasi"
                        :value="[old('namaAplikasi'), $datas?(array_key_exists('nama_aplikasi',$datas)?$datas['nama_aplikasi'][1]:''):'']"
                        :errors="$dataErrors"/>
                    <x-form.textarea
                        label="Content"
                        name="content"
                        filename="content"
                        :value="[old('content'), $datas?(array_key_exists('content',$datas)?$datas['content'][1]:''):'']"
                        :errors="$dataErrors"
                        class="wzig"/>
                    <x-form.input-field
                        label="SubTitle Aplikasi"
                        type="text"
                        name="subTitle"
                        filename="sub title"
                        :value="[old('subTitle'), $datas?(array_key_exists('subtitle_aplikasi', $datas)?$datas['subtitle_aplikasi'][1]:''):'']"
                        :errors="$dataErrors"/>
                    <x-form.textarea
                        label="Alamat"
                        name="alamat"
                        filename="alamat"
                        :value="[old('alamat'), $datas?(array_key_exists('alamat',$datas)?$datas['alamat'][1]:''):'']"
                        :errors="$dataErrors"
                        class="wzig"/>
                    <x-form.input-field
                        label="Maps"
                        type="text"
                        name="maps"
                        filename="maps"
                        :value="[old('maps'), $datas?(array_key_exists('maps',$datas) ? $datas['maps'][1]:''):'']"
                        :errors="$dataErrors"/>

                    <strong>Rekening Pembayaran</strong>
                    <x-form.input-field
                        label="Nama Bank"
                        type="text"
                        name="nama_bank"
                        filename="nama_bank"
                        :value="[old('nama_bank'), $datas?(array_key_exists('nama_bank',$datas) ? $datas['nama_bank'][1]:''):'']"
                        :errors="$dataErrors"/>
                    <x-form.input-field
                        label="Nomor Rekening"
                        type="text"
                        name="norek_bank"
                        filename="norek_bank"
                        :value="[old('norek_bank'), $datas?(array_key_exists('norek_bank',$datas) ? $datas['norek_bank'][1]:''):'']"
                        :errors="$dataErrors"/>
                    <x-form.input-field
                        label="Nama Pemilik Rekening"
                        type="text"
                        name="pemilik_bank"
                        filename="pemilik_bank"
                        :value="[old('pemilik_bank'), $datas?(array_key_exists('pemilik_bank',$datas) ? $datas['pemilik_bank'][1]:''):'']"
                        :errors="$dataErrors"/>
            </div>
        </div>


    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-header">
            {{ __('Photo') }}
            </div>

            <div class="card-body">
                <div class="form-group">
                    @if($datas && isset($datas['feature_image'][1]))
                        <img src="{{ route('cdn.image.w&h',['image'=>$datas['feature_image'][1],'width'=>206,'height'=>206]) }}" alt="" class="img-fluid">
                        <a href="{{ route('meta.delete').'?id='.$datas['feature_image'][0] }}" class="btn btn-danger btn-sm mt-3">X</a>
                    @else
                        <input type="file" class="form-control" name="featureImage" class="form-control" >
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header mt-3">
            {{ __('Logo') }}
            </div>

            <div class="card-body">
                <div class="form-group">
                    @if($datas && isset($datas['logo'][1]))
                        <img src="{{ route('cdn.image.w&h',['image'=>$datas['logo'][1],'width'=>206,'height'=>206]) }}" alt="" class="img-fluid">
                        <a href="{{ route('meta.delete').'?id='.$datas['logo'][0] }}" class="btn btn-danger btn-sm mt-3">X</a>
                    @else
                        <input type="file" class="form-control" name="logo" class="form-control" >
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row justify-content-center">
    <div class="col-mg-8 text-left">
        <button type="submit" class="btn btn-info">SUBMIT</button>
    </div>
</div>
</form>
@endsection
@section('scripts')
<script>
    tinymce.init({
        selector: '.wzig',
        menubar: false,
        height : "180",
        plugins: [
            'advlist', 'autolink', 'lists', 'link',  'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks','wordcount'
        ],
        toolbar: 'bold italic ' +
        ' bullist numlist| ' ,
            });

  </script>
@endsection
