
@extends('layouts.app')
@section('links')
{{-- <script src="https://cdn.tiny.cloud/1/7hvgpp2t8p14a5hcbrgxhv7u85cgijjwsqkyrx61tfwwgru1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> --}}

@endsection
@section('body')
<div class="row justify-content-center mt-3">
    <div class="col-lg-12">
        <a href="{{ route('acara.index') }}" class="btn btn-info">Kembali</a>
        @if($acara)
        <a href="{{ route('acara.create') }}" class="btn btn-info">Buat baru</a>
        @endif
        <div class="card mt-3">
            <div class="card-header">
            {{ __('FORM ACARA') }}
            </div>

            <div class="card-body">
                @php $dataErrors= [];  @endphp
            @if ($errors->any())
                @php $dataErrors= $errors->all();  @endphp
            @endif
                <form action="{{ $acara? route('acara.update',$acara->id) :route('acara.store') }}" method="post">
                    {{ csrf_field() }}
                    @if($acara)
                    {{ method_field('PUT') }}
                    @endif
                    <div class="row">

                        <div class="col-lg-12">
                            <x-form.input-field
                                label="Nama Acara"
                                type="text"
                                name="namaAcara"
                                filename="nama acara"
                                :value="[old('namaAcara'), $acara?$acara->name:'']"
                                :errors="$dataErrors"/>
                        </div>

                        <div class="col-lg-12">
                            <x-form.input-field
                                label="Urutan Tampilan di Publik"
                                type="number"
                                name="urutanTampilan"
                                filename="urutan tampilan"
                                :value="[old('urutanTampilan'), $acara? $acara->order:'']"
                                :errors="$dataErrors"/>
                        </div>

                        <div class="col-lg-12">
                            <x-form.textarea
                                label="Penjelasan"
                                name="penjelasan"
                                :value="[old('penjelasan'),$acara?$acara->penjelasan:'']"
                                :errors="$dataErrors"
                                filename="penjelasan"
                                />
                        </div>

                        <div class=" col-lg-12">
                            <x-form.textarea
                                label="Yang Didapat"
                                name="yangDidapat"
                                :value="[old('yangDidapat'),$acara?$acara->yang_di_dapat:'']"
                                :errors="$dataErrors"
                                filename="yang didapat"
                                />
                        </div>
                        <div class="form-group col-lg-12">
                            <x-form.textarea
                                label="Yang Dibawa"
                                name="yangDibawa"
                                :value="[old('yangDibawa'),$acara?$acara->yang_di_bawa:'']"
                                :errors="$dataErrors"
                                filename="yang dibawa"
                                />
                        </div>
                        <div class="form-group col-lg-12">
                            <x-form.textarea
                                label="Susunan Acara"
                                name="susunanAcara"
                                :value="[old('susunanAcara'),$acara?$acara->susunan_acara:'']"
                                :errors="$dataErrors"
                                filename="susunan acara"
                                />
                        </div>

                        <div class="form-group col-lg-12">
                            <label class="form-check-label">Sistem Jadwal</label>
                            <div class="form-inline">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="systemJadwal" id="system-jadwal1" value="Setiap Hari" {{ checked(old('systemJadwal')?old('systemJadwal'):($acara?$acara->sistem_jadwal:''),'Setiap Hari') }}>
                                    <label class="form-check-label" for="system-jadwal1">
                                        Setiap Hari
                                    </label>
                                </div>
                                <div class="form-check ml-4">
                                    <input class="form-check-input" type="radio" name="systemJadwal" id="system-jadwal2" value="Terjadwal" {{ checked(old('systemJadwal')?old('systemJadwal'):($acara?$acara->sistem_jadwal:''),'Terjadwal') }}>
                                    <label class="form-check-label" for="system-jadwal2">
                                        Terjadwal
                                    </label>
                                </div>
                            </div>
                            <x-form.error-notif :datas="$dataErrors" filename="system jadwal"/>
                        </div>

                        <div class="form-group col-lg-12">
                          <label for="">Sistem Kepesertaan</label>
                          <div class="form-inline">
                              <div class="form-check">
                                <input type="radio" class="form-check-input" name="sistemKepesertaan" id="sistem-kepesertaan" value="Satu Orang"  {{ checked(old('sistemKepesertaan')?old('sistemKepesertaan'):($acara?$acara->sistem_kepesertaan:''),'Satu Orang') }}>
                                <label class="form-check-label" for="sistem-kepesertaan">
                                    Selalu Satu Orang
                                </label>
                              </div>
                              <div class="form-check ml-3">
                                <input type="radio" class="form-check-input" name="sistemKepesertaan" id="sistem-kepesertaan2" value="Lebih Dari satu orang" {{ checked(old('sistemKepesertaan')?old('sistemKepesertaan'):($acara?$acara->sistem_kepesertaan:''),'Lebih Dari satu orang') }}>
                                <label class="form-check-label" for="sistem-kepesertaan2">
                                    Lebih Dari satu orang
                                </label>
                              </div>
                          </div>
                          <x-form.error-notif :datas="$dataErrors" filename="sistem kepesertaan"/>
                        </div>

                        <div class="form-group col-lg-3">
                            <x-form.input-field
                                label="Punia"
                                type="number"
                                name="punia"
                                filename="punia"
                                :value="[old('punia'),$acara? $acara->punia:'']"
                                :errors="$dataErrors"/>
                        </div>
                        <div class="form-group col-lg-12">
                            <x-form.input-field
                                label="Vidios"
                                type="text"
                                name="vidios"
                                filename="vidios"
                                :value="[old('vidios'),$acara? $acara->vidios:'']"
                                :errors="$dataErrors"/>
                            <small>Paste url youtube dan pisahkan dengan tanda koma (,) </small>
                        </div>

                        <div class="form-group col-lg-12">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="status_slider" value="1" @if($acara && $acara->status_slider == 1) checked @endif >
                                    Top Slider
                                </label>
                            </div>
                        </div>

                        <div class="col-12 pt-4 pb-2">
                            <Button type="submit" class="btn btn-info btn-lg">SUBMIT</Button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    @if($acara)
    <div class="col-lg-4 pt-5">
        @if($acara && $acara->sistem_jadwal == 'Terjadwal')
        <div class="card">
            <div class="card-header">
            {{ __('Jadwal Acara') }}
            </div>

            <div class="card-body">
                <form action="{{ route('jadwal-acara.store') }}" method="post" class="border p-2 rounded">
                    {{ csrf_field() }}
                    <input type="hidden" name="acara_id" value="{{ $acara?$acara->id:'' }}">
                    <input type="hidden" name="pleaseBack" value="true">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <x-form.input-field
                                label="Tanggal"
                                type="date"
                                name="tanggal"
                                filename="tanggal"
                                :value="[old('tanggal'), null]"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div>
                        <div class="col-lg-8">
                            <x-form.input-field
                                label="Detail"
                                type="text"
                                name="detail"
                                filename="detail"
                                :value="[old('detail'), null]"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>

                <table class="table mt-4">
                    <thead>
                        <th>Tanggal</th>
                        <th>Warige</th>
                        <th>Peserta</th>
                    </thead>
                    <tbody>
                        @if($acara)
                        @foreach($acara->jadwals as $jadwal)
                        <tr>
                            <td> <a href="{{ route('jadwal-acara.edit',$jadwal->id) }}">{{ date("d-m-Y",strtotime($jadwal -> tanggal)) }}</a> </td>
                            <td>{{ $jadwal -> dinan }}</td>
                            <td>{{ $jadwal -> jumlah_peserta }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="card mt-4">
            <div class="card-header">
            {{ __('Photo') }}
            </div>

            <div class="card-body">
                <div class="form-inline">
                    <form action="{{ route('media.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="model" value="acara">
                        <input type="hidden" name="model_id" value="{{ $acara->id}}">
                        <input type="hidden" name="is_photo" value="true">
                        <input type="file" class="form-control" name="file" class="form-control">
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </form>
                </div>
                <div class="row mt-3">
                    @if($acara)
                    @foreach($acara->photos as $photo)
                    <div class="col-lg-6  mt-2">
                        <img src="{{ route('cdn.image.w&h',['image'=>$photo->url,'width'=>227,'height'=>227]) }}" alt="" class="img-fluid">
                        <form action="{{ route('media.destroy',$photo->id) }}" method="post" class="text-center">
                            @csrf
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger btn-sm">X</button>
                        </form>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>
    @endif
</div>

@php
function checked($value,$data){
    if($value == $data)
      return 'checked';//$value.'|'.$data;
}
@endphp
@endsection
@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>

    // var CopyButton = function (context) {
    //     var ui = $.summernote.ui;
    //     // create button
    //     var button = ui.button({
    //         contents: '<i class="fa fa-copy"/>',
    //         tooltip: 'Copy',
    //         click: function () {
    //             var text = context.invoke('');
    //             navigator.clipboard.writeText(text);
    //         }
    //     });
    //     return button.render();
    // }


    var PasteButton = function (context) {
        var ui = $.summernote.ui;
        // create button
        var button = ui.button({
            contents: '<i class="fa fa-paste"/>',
            tooltip: 'Paste',
            click: function () {

                navigator.clipboard.readText().then((copiedText) => {
                    context.invoke('editor.insertText', copiedText);
                });
            }
        });
        return button.render();
    }

    $('textarea').summernote({
        height: 200,
        toolbar: [
          ['font', ['bold', 'underline', 'clear']],
          ['para', ['ul', 'ol']],
          ['table', ['table']],
          ['insert', ['link', 'picture']],
          ['custom', ['paste']]
        ],
        buttons: {
            paste: PasteButton,
            // copy : CopyButton
        }
    });
</script>
@endsection
