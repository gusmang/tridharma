
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

                <form action="{{ route('jadwal-acara.store') }}" method="post" >
                    {{ csrf_field() }}

                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Acara</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="acara_id" >
                                <option value="">--Pilih Acara -- </option>
                                @foreach($acaras as $acara)
                                <option value="{{ $acara->id }}"
                                    {{ $jadwal? ($jadwal->acara_id ==$acara->id ? "selected":'' ):'' }}

                                    {{ $jadwal == null && Request::query('acara_id') == $acara->id ? 'selected' : '' }}
                                >{{ $acara->name }}</option>
                                @endforeach
                            </select>
                            <x-form.error-notif :datas="$dataErrors" :filename="'acara id'"/>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Daftar Acara</label>
                        <div class="col-sm-10">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kalender</th>
                                        <th>Keterangan</th>
                                        <th>
                                            <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="addTr(this)">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table_target">
                                    @for ($i = 0; $i < 5; $i++)
                                        <tr>
                                            <td>
                                                <input type="date" name="tanggal[]" class="form-control input-sm" required/>
                                            </td>
                                            <td>
                                                <input type="text" name="detail[]" class="form-control input-sm" required/>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteTr(this)">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
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

<script>
    function deleteTr(ele) {
        $(ele).closest('tr').remove();
    }

    function addTr() {
        var item = `
        <tr>
            <td>
                <input type="date" name="tanggal[]" class="form-control input-sm" required/>
            </td>
            <td>
                <input type="text" name="detail[]" class="form-control input-sm" required/>
            </td>
            <td>
                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteTr(this)">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
        `;

        $('#table_target').append(item);
    }
</script>
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
