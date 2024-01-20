@extends('layouts.app')

@section('links')
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
@stop

@section('body')
    <div class="peserta">
        <div class="row">
            <div class="col">
                <h1>Peserta</h1>
            </div>
            <div class="col text-right">
                <a href="{{ route('peserta.create') }}" class="btn btn-info">Peserta baru</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <form action="{{ route('peserta.index') }}" method="get" id="form_filter">
                    <input type="hidden" name="page" value="{{ Request::input('page') }}">
                    <div class="row">
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
                        <div class="col xs-6 d-none">
                            <div class="form-group">
                            <select class="form-control" name="type">
                                <option value="">-- Pilih Type -- </option>
                                <option value="semua" {{ app('request')->input('type') == 'semua'? "selected":'' }}>Semua Tanggal</option>
                                <option value="akan-datang" {{ app('request')->input('type') == 'akan-datang'? "selected":'' }}>Yang Akan Datang</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-2  xs-6">
                            <div class="form-group">
                            <input type="date" name="tanggal" class="form-control" value="{{ app('request')->input('tanggal') }}">
                            </div>
                        </div>
                        <div class="colform-group">
                          <select class="form-control" name="status_peserta" id="">
                            <option value="">--Pilih Status Kepesertaan</option>
                            <option value="1">Sudah Terdaftar</option>
                            <option value="2">Upload Konfirmasi Pembayaran</option>
                            <option value="3">Selesai Kegiatan</option>
                            <option value="4">Batal</option>
                          </select>
                        </div>
                        <div class="col text-right">
                            <button type="submit" class="btn btn-info">Filter</button>
                            <a href="{{ route('peserta.index') }}" class="btn btn-success">Reset Filter</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
               <table class="table" id="datatable">
                    <thead>
                        <th>Nama</th>
                        <th>Nomor Urut</th>
                        <th>Tanggal</th>
                        <th>Status Peserta</th>
                        <th>Acara</th>
                        <th>Telp/Wa</th>
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
            var url    = `{{ route('peserta.datatable') }}?${param}`;
            var config = {
                processing: true,
                serverSide: true,
                ajax      : url,
                responsive: true,
                columns   : [
                    {data: 'nama', name: 'pesertas.nama'},
                    {data: 'nomor_urut', name: 'pesertas.nomor_urut'},
                    {data: 'tanggal', name: 'pesertas.tanggal'},
                    {data: 'status_peserta', sortable : false, orderable : false},
                    {data: 'name', name: 'acaras.name'},
                    {data: 'telpon', name: 'pesertas.telpon'},
                    {data: 'aksi', name: 'pesertas.id'},
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
