
@extends('layouts.app')
@section('links')
{{-- <script src="https://cdn.tiny.cloud/1/7hvgpp2t8p14a5hcbrgxhv7u85cgijjwsqkyrx61tfwwgru1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> --}}
@endsection
@section('body')
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


        <a href="{{ route('jadwal-acara.index') }}" class="btn btn-info">{{ __('Kembali') }}</a>

        <div class="card mt-3">
            <div class="card-header">
            {{ __('Jadwal Acara') }} {{  $jadwal ? $jadwal->acara->name : '' }}
            </div>

            <div class="card-body">

                <form action="{{ route('jadwal-acara.update',$jadwal->id) }}" method="post" >
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status Pendaftaran</label>
                        <div class="col-sm-8">
                            <div class="form-check">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" name="tutup" value="1" @if($jadwal && $jadwal->is_closed) checked @endif >
                                  Pendaftaran di tutup
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <x-form.input-field
                                :type="'date'"
                                :name="'tanggal'"
                                :filename="'tanggal'"
                                :value="[old('tanggal'), $jadwal?$jadwal->tanggal:'']"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Detail</label>
                        <div class="col-sm-8">
                            <x-form.input-field
                                :type="'text'"
                                :name="'detail'"
                                :filename="'detail'"
                                :value="[old('detail'), $jadwal?$jadwal->dinan:'']"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>


@php
function checked($value,$data){
    if($value == $data)
      return 'checked';//$value.'|'.$data;
}
@endphp
@endsection
@section('scripts')
{{-- <script>
    tinymce.init({
        selector: 'textarea',
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link',  'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks','wordcount'
        ],
        toolbar: 'bold italic ' +
        ' bullist numlist| ' ,
            });
  </script> --}}
@endsection
