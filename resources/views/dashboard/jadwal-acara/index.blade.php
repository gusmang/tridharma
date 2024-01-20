
@extends('layouts.app')
@section('links')
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
@stop
@section('body')
        <div class="row">
            <div class="col-lg-6">
                <a href="{{ route('jadwal-acara.create') }}" class="btn btn-info">Buat jadwal</a>
                <a href="{{ route('jadwal-acara.jadwal-kosong') }}" class="btn btn-primary">Acara Jadwal Kosong</a>
            </div>
            <div class="col-lg-6"></div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <form action="{{ route('jadwal-acara.index') }}" method="get">
                <div class="row">
                    <div class="col-12 pb-3">{{ __('JADWAL ACARA') }}</div>
                    <div class="col">
                        <div class="form-group">
                          <select class="form-control" name="acara">
                            <option value="">--Pilih Acara--</option>
                            @foreach($acaras as $acara)
                            <option value="{{ $acara->id }}" {{ app('request')->input('acara') == $acara->id? "selected":'' }} >{{ $acara->name }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col xs-6">
                        <div class="form-group">
                          <select class="form-control" name="type">
                            <option value="">-- Pilih Type -- </option>
                            <option value="semua" {{ app('request')->input('type') == 'semua'? "selected":'' }}>Semua Tanggal</option>
                            <option value="akan-datang" {{ app('request')->input('type') == 'akan-datang'? "selected":'' }}>Yang Akan Datang</option>
                          </select>
                        </div>
                    </div>
                    <div class="col  xs-6">
                        <div class="form-group">
                          <input type="date" name="tanggal" class="form-control" value="{{ app('request')->input('tanggal') }}">
                        </div>
                    </div>
                    <div class="col text-right">
                        <button type="submit" class="btn btn-info">Filter</button>
                        <a href="{{ route('jadwal-acara.index') }}" class="btn btn-info">Reset Filter</a>
                    </div>
                </div>
                </form>
            </div>

            <div class="card-body">
                <table class="table" id="datatable">
                    <thead>
                        <th width="20" class="xs-hide">No</th>
                        <th>Acara</th>
                        <th>Tanggal</th>
                        <th>Dinan</th>
                        <th>Peserta</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($jadwals as $key=>$jadwal)
                        <tr class="@if($jadwal->is_closed) text-danger  @endif" >
                            <td class="xs-hide">{{ $key+1 }}</td>
                            <td>{{ $jadwal->acara->name }}</td>
                            <td>{{ date("d-m-Y",strtotime($jadwal->tanggal)) }}</td>
                            <td>{{ $jadwal->dinan }}</td>
                            <td>{{ $jadwal->jumlah_peserta }}</td>
                            <td widtth="30" class="form-inline">
                                <a href="{{ route('jadwal-acara.edit',$jadwal->id) }}" class="btn btn-warning btn-sm">edit</a>
                                <form action="{{ route('jadwal-acara.destroy',$jadwal->id) }}" method="post" id="hapusAcara{{$jadwal->id}}">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button type="button" dataId="hapusAcara{{$jadwal->id}}" class="btn btn-danger btn-sm ml-3 hapusAcara"><i class="fa fa-trash"></i> </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{$jadwals->onEachSide(5)->links()}}
                </div>
            </div>
        </div>
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
<script>
     $(function(){
         $('.hapusAcara').on('click',function(){
             if(confirm('Yakin mau menghapus jadwal ini?')){
                $('#'+$(this).attr('dataId')).submit();
             }
         })
         $('#datatable').DataTable({
                responsive: true,
            });
     })
</script>
@endsection
