@extends('layouts.app')

@section('links')
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
@stop

@section('body')
    <div class="peserta">
        <div class="row">
            <div class="col">
                <h1>Laporan Acara</h1>
            </div>
        </div>

        <div class="card">
            <div class="card-header pb-0">
                <form method="get" id="form_filter">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <input type="date" name="tanggal_mulai" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <input type="date" name="tanggal_selesai" class="form-control">
                            </div>
                        </div>
                        <div class="col text-right">
                            <button type="submit" class="btn btn-info">Filter</button>
                            <a href="{{ route('laporan-acara.index') }}" class="btn btn-success">Reset Filter</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
               <table class="table" id="datatable">
                    <thead>
                        <th>Acara</th>
                        <th>Jumlah Pembayaran</th>
                        <th>Jumlah Peserta</th>
                        <th>Total Nominal</th>
                        <th></th>
                    </thead>
               </table>
            </div>
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
            var url    = `{{ route('laporan-acara.datatable') }}?${param}`;
            var config = {
                processing: true,
                serverSide: true,
                ajax      : url,
                responsive: true,
                columns   : [
                    {data: 'name', name: 'acaras.name'},
                    {data: 't_pembayaran', searchable : false, orderable : false},
                    {data: 't_peserta', searchable : false, orderable : false},
                    {data: 't_nominal', searchable : false, orderable : false},
                    {
                        data: 'aksi', name: 'acaras.id',
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
