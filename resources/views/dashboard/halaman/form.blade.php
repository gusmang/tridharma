
@extends('layouts.app')
@section('links')
<script src="https://cdn.tiny.cloud/1/7hvgpp2t8p14a5hcbrgxhv7u85cgijjwsqkyrx61tfwwgru1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<style>
    .sticky{
        position: sticky;
        top: 67px;
    }
</style>
@endsection
@section('body')
<form action="{{ $halaman ? route('halaman.update',$halaman->id):route('halaman.store') }}" method="POST" enctype="multipart/form-data">
<div class="row justify-content-center mt-1">
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
    <div class="col-lg-6 ">
        <a href="{{ route('halaman.index') }}" class="btn btn-info">{{ __('Kembali') }}</a>
        @if($halaman)
        <a href="{{ route('halaman.create') }}" class="btn btn-info">{{ __('Buat Baru') }}</a>
        @endif
        <div class="card mt-3">
            <div class="card-header">
            {{ __('Edit Halaman') }}
            </div>

            <div class="card-body">
                    {{ csrf_field() }}
                    @if($halaman)
                    {{ method_field('PUT') }}
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            <x-form.input-field
                                :label="'Title'"
                                :type="'text'"
                                :name="'title'"
                                :filename="'title'"
                                :value="[old('title'), $halaman?$halaman->title:'']"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div>
                        <div class="col-lg-12">
                            <x-form.textarea
                                label="Content"
                                name="content"
                                filename="content"
                                :value="[old('content'), $halaman?$halaman->content:'']"
                                :errors="$dataErrors"
                                class="wzig"/>
                        </div>
                    </div>

                    <div class="meta-container">
                        @if($halaman)
                        @foreach($halaman->metas as $key => $meta)
                        <div class="row meta-content">
                            <div class="col-lg-4">
                                <label for="">Key</label>
                                <input type="text" name="{{ $meta->is_photo ?'':'metaKey[]' }}" class="form-control" value="{{ $meta->meta_key}}">
                                <div class="form-inline mt-2">
                                    <input type="text"
                                      class="form-control order " disabled value="{{ $meta->order }}" size="2" >
                                    <button type="button" class="btn btn-info setOrderMeta" data_id="{{ $meta->id }}" >Set Order</button>
                                    <button type="button" class="btn btn-danger deleteMeta"  data_id="{{ $meta->id }}">Hapus</button>
                                </div>
                            </div>
                            @if($meta->is_photo)
                            <div class="col-lg-8">
                                <img src="{{ asset('storage/full/'.$meta->meta_value) }}" alt="" class="img-fluid">
                            </div>
                            @else
                            <div class="col-lg-8">
                                <label for="">Value</label>
                                <textarea name="metaValue[]" id="" cols="30" rows="10" class="form-control wzig">{{ $meta->meta_value}}</textarea>
                            </div>
                            @endif
                        </div>
                        @endforeach
                        @endif
                    </div>
            </div>
        </div>
    </div>

    <div class="col-lg-2 mt-5">
        <div class="card">
            <div class="card-header">
                {{__('Feature Image')}}
            </div>
            <div class="card-body">
               <div class="form-group">
                 @if($halaman && $halaman->feature_image)
                    <img src="{{ asset('storage/full/'.$halaman->feature_image) }}" alt="" class="img-fluid">
                    <a href="{{ route('halaman.hapus-feature-image',$halaman->id) }}" class="btn btn-danger btn-sm mt-2" data-toggle="tooltip" title="{{ __('Hapus Gambar') }}">X</a>
                 @else
                 <input type="file" class="form-control-file" name="featureImage" id="" placeholder="" aria-describedby="fileHelpId">
                 @endif
               </div>
            </div>
        </div>
        <div class="sticky">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="form-group">
                      <label for="">Order</label>
                      <input type="number"
                        class="form-control" name="order" id=""  value="{{ $halaman? $halaman->order:0 }}">
                    </div>
                    <div class="form-group">
                      <label for="">Acara</label>
                      <select class="form-control" name="acara" >
                        <option></option>
                        @foreach($acaras as $acara)
                        <option value="{{ $acara->id }}" @if(old('acara')==$acara->id) selected @elseif($halaman && $halaman->acara_id==$acara->id)) selected @endif >{{ $acara->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="is_homepage" id="" value="true" {{ $halaman ? ($halaman->is_homepage?"checked":''):'' }}>
                        Homeapage
                      </label>
                    </div>
                   <button type="button" class="btn btn-primary mt-3 addSection" data-toggle="modal" data-target="#metaForm">TAMBAH SECTION </button>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                   <button type="submit" class="btn btn-info">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>
</div>

</form>
<!-- Modal -->
<div class="modal fade" id="metaForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input metaType" name="metaType" value="text" >
                    Type Text
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input  metaType" name="metaType" value="photo" >
                    Type Photo
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input  metaType" name="metaType" value="vidio" >
                    Type Vidio
                  </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary metaSelect">OK</button>
            </div>
        </div>
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
    loadInitialTinyMCE();
    if(jQuery('.meta-content').length == 0){
        addMetaHtml('text');
    }

    jQuery(document).ready(function($){
        $('.setOrderMeta').click(function(){
            let order = prompt("Set order");
            const id = $(this).attr('data_id');
            if(order!=null){
                if(!isNaN(order)){
                    window.location.href="{{ route('meta.set-order') }}?id="+id+"&order="+order
                }
            }
        })
        $('.deleteMeta').click(function(){
            const id = $(this).attr('data_id');
            if(confirm("Yakin Mengahapus data ini?")){
                window.location.href="{{ route('meta.delete') }}?id="+id;
            }
        })
        $('.metaSelect').click(function(){
            let value = $('.metaType:checked').val();
            if(value ==='text')
                addMetaHtml('text');
            else if (value==='photo')
                addMetaHtml('photo');
            else if (value==='vidio')
                addMetaHtml('vidio');
            else
                alert('Pilihan kosong');

            $('#metaForm').modal('hide');
            $('.metaType').prop('checked', false);
        })
    })

    function addMetaHtml(type){
        let text = '<div class="row meta-content"> <div class="col-lg-4">'+
                '    <label for="">Key</label>'+
                '    <input type="text" name="metaKey[]" class="form-control">'+
                '</div>'+
                '<div class="col-lg-8">'+
                '    <label for="">Value</label>'+
                '    <textarea name="metaValue[]" id="" cols="30" rows="10" class="form-control wzig"></textarea>'+
                '</div> </div>';
        let photo = '<div class="row meta-content"> <div class="col-lg-4">'+
                '    <label for="">Key</label>'+
                '    <input type="text" name="metaKeyFile[]" class="form-control" value="photo">'+
                '</div>'+
                '<div class="col-lg-8">'+
                '    <label for="">Value</label>'+
                '    <input type="file" name="metaValueFile[]" class="form-control">'+
                '</div> </div>';
        let vidio = '<div class="row meta-content"> <div class="col-lg-4">'+
                '    <label for="">Key</label>'+
                '    <input type="text" name="metaKey[]" class="form-control" value="vidio">'+
                '</div>'+
                '<div class="col-lg-8">'+
                '    <label for="">Value</label>'+
                '    <input type="text" name="metaValue[]" class="form-control">'+
                '</div> </div>';
        switch (type) {
            case 'text':
                $('.meta-container').append(text);
                break;

            case 'photo':
                $('.meta-container').append(photo);
                break;

            case 'vidio':
                $('.meta-container').append(vidio);
                break;

            default:
                break;
        }
        loadInitialTinyMCE();
    }

    function loadInitialTinyMCE(){
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
    }
  </script>
@endsection
