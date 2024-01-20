@extends('layouts.app')

@section('links')
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet" />
@stop

@section('body')
<div class="peserta">
    <div class="row">
        <div class="col">
            <h1>List Pendaftaran</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form method="get" id="form_filter">
                <div class="row">
                    <div class="col-6 ">
                        <div class="form-group">
                            <select class="form-control" name="acara">
                                <option value="">--Pilih Acara--</option>
                                @foreach($acaras as $acara)
                                <option value="{{ $acara->id }}" @if(Request::query('acara_id')==$acara->id)
                                    selected
                                    @endif
                                    >{{ $acara->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <select class="form-control" name="tipe_order">
                                @foreach($tipe_order as $k => $v)
                                <option value="{{ $k }}" @if(Request::query('tipe_order')==$k) selected @endif>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-info">Filter</button>
                        <a href="{{ route('list-order.index') }}" class="btn btn-success">Reset Filter</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table class="table" id="datatable">
                <thead>
                    <th>ID & Tanggal Bayar & Peserta</th>
                    <th>No. Daftar</th>
                    <th>Acara</th>
                    <th>Telp/Wa</th>
                    <th>Punia</th>
                    <th>Jumlah Bayar</th>
                    <th>Sisa</th>
                    <th>Jml Peserta</th>
                    <th>Status</th>
                    <th>Tanggal Order</th>
                    <th>Action 1</th>
                    <th>Action 2</th>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
<script>
    function cancel_order(id) {
        window.location = "<?php echo url('dashboard/cancel-order'); ?>" + "/" + id;
    }

    var table = null;

    let arrayBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    function formatTanggal(values) {
        let vals = values.split(" ");
        let arr_bln = vals[0].split("-");

        let bulan = arrayBulan[(parseInt(arr_bln[1]) - 1)];
        return arr_bln[2] + " " + bulan + " " + arr_bln[0];
    }

    function send_kwitansi(punia, name, nama, tanggal, created_at, id, phone) {
        //let rows = JSON.parse(data);
        let text = "Giriya Tri Dharma Sakti %0a" +
            "Jl Narakesuma Gang VII No 3 Denpasar%0a" +
            "*TANDA TERIMA PEMBAYARAN*%0a" +
            "Telah diterima pembayaran sejumlah uang : " + formatRupiah(punia, "Rp. ") + "%0a" +
            "Untuk Pembayaran : " + name + "%0a" +
            "Nama Acara : " + name + "%0a" +
            "Nama Peserta: " + nama + "%0a" +
            "Tanggal : " + formatTanggal(tanggal) + "%0a" +
            "Jumlah Tagihan : " + formatRupiah(punia, "Rp. ") + "%0a" +
            "Sisa Tagihan : " + "0" + "%0a" +
            "Pembayaran diterima oleh: " + "%0a" +
            "Metode bayar : " + "cash/transfer" + "%0a" +
            "Tanggal bayar : " + formatTanggal(created_at) + "%0a" +
            "No kwitansi : " + id

        window.open("https://api.WhatsApp.com/send?phone=6289670164667&text=" + text);
    }

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(function() {
        loadDatatable();

        $('#form_filter').on("submit", function(e) {
            e.preventDefault();
            loadDatatable();
        })
    });

    function loadDatatable() {
        var param = $('#form_filter').serialize();
        var url = `{{ route('old-list-order.datatable') }}?${param}`;
        var config = {
            processing: true,
            serverSide: true,
            ajax: url,
            responsive: true,
            columns: [{
                    data: 'nama',
                    name: 'pesertas.nama',
                    render: function(data, type, row) {
                        return `<b>${formatTanggal(row.tanggal)}</b><br />${row.nama}`;
                    }
                },
                {
                    data: 'id',
                    name: 'pesertas.id'
                },
                {
                    data: 'name',
                    name: 'acaras.name'
                },
                {
                    data: 'telpon',
                    name: 'pesertas.telpon',
                    render: function(data, type, row) {
                        return `<a href="https://wa.me/${row.telpon}" target="_blank"><i class="fa fa-whatsapp"></i> ${row.telpon.toString()} </a>`;
                    }
                },
                {
                    data: 'punia',
                    name: 'pesertas.punia',
                    render: function(data, type, row) {
                        return `${formatRupiah(row.punia.toString() , "Rp. ")}`;
                    }
                },
                {
                    data: 'dibayarkan',
                    name: 'pesertas.dibayarkan',
                    render: function(data, type, row) {
                        return `${formatRupiah(data.toString() , "Rp. ")}`;
                    }
                },
                {
                    data: 'dibayarkan',
                    name: 'pesertas.dibayarkan',
                    render: function(data, type, row) {
                        return `${formatRupiah(((parseInt(row.punia) - parseInt(row.kode_bayar)) - parseInt(data)).toString() , "Rp. ")}`;
                    }
                },
                {
                    data: 'jumlah_peserta',
                    name: 'pesertas.jumlah_peserta'
                },
                {
                    data: 'status_order',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'created_at',
                    name: 'pesertas.created_at',
                    render: function(data, type, row) {
                        return `${row.created_at}`;
                    }
                },
                {
                    data: 'id',
                    name: 'pesertas.id',
                    render: function(data, type, row) {
                        return `<a href="{{ url('dashboard/list-order/bayar') }}/${data}" style="display:${row.sudah_bayar == 1 ? 'none' : 'inline-block'}" class="btn btn-success">Bayar</a>
                                <a href="{{ route('list-order.index') }}/${data}" class="btn btn-info">Detail</a>`;
                    }
                },
                {
                    data: 'id',
                    name: 'pesertas.id',
                    render: function(data, type, row) {
                        return `<button style="display:${row.sudah_bayar == 1 ? 'none' : 'inline-block'}" type="button" onclick="var conn = confirm('Yakin cancel data ini ?'); if(conn == true) { cancel_order(${data}) }" class="btn btn-danger">Batal</button>
                                <a href="{{ route('list-order.index') }}/${data}" class="btn btn-warning">Cetak</a>
                                <button style="display:${row.sudah_bayar == 1 ? 'inline-block' : 'none'}"
                                     onclick="send_kwitansi(\'${row.punia}\',\'${row.name}\',\'${row.nama}\',\'${row.tanggal}\',\'${row.created_at}\',\'${row.id}\',\'${row.telpon}\',\'${row.acara_id}\')"  class="btn btn-success">
                                     Kwitansi
                                </button>`;
                    }
                },
            ]
        }

        if (table == null) {
            table = $('#datatable').DataTable(config);
        } else {
            table.ajax.url(url).load();
        }

    }
</script>
@endsection