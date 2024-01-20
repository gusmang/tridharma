
@extends('layouts.app')

@section('body')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="row">
            <div class="col-lg-6">
                <a href="{{ route('halaman.create') }}" class="btn btn-info">Buat halaman</a>
            </div>
            <div class="col-lg-6"></div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <form action="{{ route('jadwal-acara.index') }}" method="get">
                    <div class="col">{{ __('LIST HALAMAN') }}</div>
                <div class="row d-none">
                    <div class="col">
                        <div class="form-group">
                          <select class="form-control" name="acara">
                            <option value="">--Pilih Acara--</option>
                          </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                          <select class="form-control" name="type">
                            <option value="">-- Pilih Type -- </option>
                            <option value="semua" {{ app('request')->input('type') == 'semua'? "selected":'' }}>Semua Tanggal</option>
                            <option value="akan-datang" {{ app('request')->input('type') == 'akan-datang'? "selected":'' }}>Yang Akan Datang</option>
                          </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                          <input type="date" name="tanggal" class="form-control" value="{{ app('request')->input('tanggal') }}">
                        </div>
                    </div>
                    <div class="col text-right">
                        <button type="submit" class="btn btn-info">Filter</button>
                        <a href="{{ route('jadwal-acara.index') }}" class="btn btn-info">Reset Filter</a>
                    </div>
                </div>
            </div>
            </form>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <th width="20">Order</th>
                        <th>Title</th>
                        <th>Di Buat</th>
                        <th>Terakhir Update</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($halamans as $key=>$halaman)
                        <tr>
                            <td>{{ $halaman->order }} @if($halaman->is_homepage) <i class="fa fa-home" aria-hidden="true"></i>  @endif</td>
                            <td>{{ $halaman->title }}</td>
                            <td>{{ date("d-m-Y @ H:i:s",strtotime($halaman->created_at)) }}</td>
                            <td>{{ date("d-m-Y @ H:i:s",strtotime($halaman->updated_at)) }}</td>
                            <td widtth="30" class="form-inline">
                                <x-form.edit-button url="{{ route('halaman.edit',$halaman->id) }}"/>
                                <x-form.delete-button url="{{ route('halaman.destroy',$halaman->id) }}" id="{{$halaman->id}}"/>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                </div>
            </div>
        </div>
    </div>
    <style>
        .all-left {
   text-align:left;
 }
 .all-left ul{
    padding-left:15px;
 }
 .pagination svg{
    width:30px;
 }
 .pagination a svg,
 .pagination a{
     color:var(--primary-color)
 }
 .pagination span{
    color:#858a8c;
 }
 .pagination>nav>div:first-child{
     display:none;
 }
    </style>
</div>
@endsection
