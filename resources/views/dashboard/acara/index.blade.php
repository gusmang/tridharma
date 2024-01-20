
@extends('layouts.app')


@section('links')
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
@stop

@section('body')
<div class="row">
    <div class="col-lg-6">
        <a href="{{ route('acara.create') }}" class="btn btn-info">Buat Acara</a>
        <a href="{{ route('jadwal-acara.create') }}" class="btn btn-info">Buat Jadwal Acara</a>
    </div>
    <div class="col-lg-6"></div>
</div>

<br/>



<div class="card">
    <div class="card-header">
        <form method="get">
            <div class="row">
                <div class="col">
                    <select class="form-control" name="sistem_jadwal">
                        <option selected>Semua Sistem Jadwal</option>
                        <option value="Terjadwal">Terjadwal</option>
                        <option value="Setiap Hari">Setiap Hari</option>
                    </select>
                </div>
                <div class="col text-right">
                    <button type="submit" class="btn btn-info">Filter</button>
                    <a href="{{ route('acara.index') }}" class="btn btn-success">Reset Filter</a>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table" id="datatable">
            <thead>
                <th>Nama</th>
                <th>Punia</th>
                <th>Sistem Jadwal</th>
                <th>Buat Jadwal</th>
                <th>Sistem Kepesertaan</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                @foreach($acaras as $acara)
                <tr>
                    <td>{{ $acara->name }}</td>
                    <td>{{ $acara->punia }}</td>
                    <td>{{ $acara->sistem_jadwal }}</td>
                    <td>
                        @if($acara->sistem_jadwal == 'Terjadwal')
                            <a href="{{ route('jadwal-acara.create') }}?acara_id={{ $acara->id }}" class="btn btn-link btn-sm">Buat Jadwal</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($acara->sistem_kepesertaan == 'Lebih Dari satu orang')
                            <i class="fa fa-users"></i>
                        @else
                            <i class="fa fa-user"></i>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('acara.show', $acara->id) }}" class="btn btn-success btn-sm">Detail</a>
                        <a href="{{ route('acara.edit', $acara->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('jadwal-acara.index') }}?acara={{ $acara->id }}" class="btn btn-primary btn-sm ml-1"><i class="fa fa-calendar"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
     </div>
</div>


@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    <script>
        var table = null;
        $(function() {
            $('#datatable').DataTable({
                responsive: true,
            });
        });

    </script>
@endsection
