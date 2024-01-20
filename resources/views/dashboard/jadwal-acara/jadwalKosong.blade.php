@extends('layouts.app')

@section('links')
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
@stop

@section('body')
    <div class="peserta">
        <div class="row">
            <div class="col">
                <h1>Jadwal Acara</h1>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="alert alert-info">
                    Berikut merupakan daftar acara yang perlu anda beri jadwal
                </div>

                <table class="table" id="datatable">
                    <thead>
                        <th>Nama Acara</th>
                        <th>Sistem Jadwal</th>
                        <th>Punia</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach($acaras as $k => $acara)
                            <tr>
                                <td>{{ $acara->name }}</td>
                                <td>{{ $acara->sistem_jadwal }}</td>
                                <td>{{ $acara->punia }}</td>
                                <td>
                                    <a href="{{ route('jadwal-acara.create', ['acara_id' => $acara->id]) }}" target="_blank" class="btn btn-primary">Buat Jadwal</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
               </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    <script>

        $(function() {
            $('#datatable').DataTable();
        });


    </script>
@endsection
