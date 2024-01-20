@extends('layouts.app')

@section('links')
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
@stop

@section('body')

<div class="row">
    <div class="col">
        <h1>Dokumentasi Acara</h1>
    </div>
</div>


<div class="card">
    <div class="card-header">
        Daftar Kegiatan Selesai
    </div>
    <div class="card-header">

        <form method="get" id="form_filter">
            <div class="row">
                <div class="col">
                    <div class="form-group mb-0">
                        <select class="form-control" name="acara">
                            <option value="">--Pilih Acara--</option>
                            @foreach($acaras as $acara)
                                <option value="{{ $acara->id }}">{{ $acara->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-info">Filter</button>
                    <a href="" class="btn btn-success">Reset Filter</a>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">


       <table class="table" id="datatable">
            <thead>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Acara</th>
                <th>Telp/Wa</th>
                <th>Status Dokumentasi</th>
                <th></th>
            </thead>
       </table>
    </div>
</div>


@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    <script>

        var table = null;

        $(function() {
            loadDatatable();
            $('#form_filter').on("submit", function(e) {
                e.preventDefault();
                loadDatatable();
            })
        });

        function loadDatatable() {
            var param  = $('#form_filter').serialize();
            var url    = `{{ route('dokumentasi-acara.datatable') }}?${param}`;
            var config = {
                processing: true,
                serverSide: true,
                ajax      : url,
                responsive: true,
                columns   : [
                    {data: 'tanggal', name: 'pesertas.tanggal'},
                    {data: 'nama', name: 'pesertas.nama'},
                    {data: 'name', name: 'acaras.name'},
                    {data: 'telpon', name: 'pesertas.telpon'},
                    {
                        data: 'status_dokumentasi',
                        searchable : false,
                        orderable : false,
                        render : function(data) {
                            if(data == 0) {
                                return '<span class="badge badge-warning">Belum Ada</span>'
                            }
                            return '<span class="badge badge-success">Sudah Ada</span>'
                        }
                    },
                    {
                        data: 'id', name: 'pesertas.id',
                        render : function(data) {
                            return `<a target="_blank" href="{{ route('dokumentasi-acara.index') }}/${data}" class="btn btn-info">Detail</a>`;
                        }
                    },
                ]
            }

            if(table == null) {
                table = $('#datatable').DataTable(config);
            } else {
                table.ajax.url(url).load();
            }

        }

    </script>
@endsection
