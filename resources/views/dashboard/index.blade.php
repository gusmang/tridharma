@extends('layouts.app')

@section('links')
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
@stop

@section('body')

<div class="row">
    <div class="col">
        <h1>Dashboard</h1>
    </div>
</div>

<div class="row clearfix">
    <!-- <div class="col-lg-4 col-md-6">
		<div class="card">
			<div class="card-body top_counter">
				<div class="icon bg-success text-white">
					<i class="fa fa-check"></i>
				</div>
				<div class="content text-dark">
					<span>Konfirmasi Bayar</span>
					<h5 class="number mb-0">{{ $sudah_bayar }} <small><a href="{{ route('list-order.index') }}?tipe_order=terbayar">Detail</a></small></h5>

				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card">
			<div class="card-body top_counter">
				<div class="icon bg-warning text-white">
					<i class="fa fa-clock-o"></i>
				</div>
				<div class="content text-dark">
					<span>Belum Bayar</span>
					<h5 class="number mb-0">{{ $belum_bayar }} <small><a href="{{ route('list-order.index') }}?tipe_order=belum_bayar">Detail</a></small></h5>

				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="card">
			<div class="card-body top_counter">
				<div class="icon bg-danger text-white">
					<i class="fa fa-warning"></i>
				</div>
				<div class="content text-dark">
					<span>Lewat Tanggal</span>
					<h5 class="number mb-0">{{ $lewat_tanggal }} <small><a href="{{ route('list-order.index') }}?tipe_order=batal">Detail</a></small></h5>

				</div>
			</div>
		</div>
	</div> -->
</div>

<div class="card">
    <div class="card-header">
        Daftar Pembayaran Peserta

    </div>
    <div class="card-header">

        <form method="get" id="form_filter">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="col-md-9 col-12">
                        <!-- <div class="row justify-content-center">
                                    <div class="col-2 col-md-1 d-flex justify-content-center" style="align-items:center; cursor:pointer;" onclick="filterDates(1)">
                                        <i class="fa fa-chevron-left"></i>
                                    </div>
                                    <div class="col-8 col-md-10 d-flex justify-content-center">
                                        <input type="date" name="t_date_picker" id="t_date_picker" value="<?php //echo date('Y-m-d'); 
                                                                                                            ?>" class="form-control" style="background:white;" />
                                    </div>
                                    <div class="col-2 col-md-1 d-flex justify-content-center"  style="align-items:center; cursor:pointer;" onclick="filterDates(0)">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </div> -->
                    </div>
                </div>
                <!-- <div class="col">
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
                            <div class="form-group mb-0">
                                <select class="form-control" name="tipe_order">
                                    @foreach($tipe_order as $k => $v)
                                        <option value="{{ $k }}"
                                            @if(Request::query('tipe_order') == $k)
                                                selected
                                            @endif
                                        >{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col text-right">
                            <button type="submit" class="btn btn-info">Filter</button>
                            <a href="" class="btn btn-success">Reset Filter</a>
                        </div> -->
            </div>
        </form>
    </div>
    <div class="card-body">


        <!-- <table class="table" id="datatable">
                    <thead>
                        <th>Tanggal Order</th>
                        <th>Nama</th>
                        <th>Acara</th>
                        <th>Telp/Wa</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
               </table> -->
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
                <th>Action 3</th>
            </thead>
        </table>

    </div>
</div>


@endsection

@section('scripts')
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
<script src="<?php echo asset('js/moment.js'); ?>" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>


<script>
    var table = null;
    var startdate = moment().subtract(1, "days").format("YYYY-MM-DD");

    var nowsdate = moment().format("YYYY-MM-DD");
    var acara_bawa = "";

    function approved(url, punia, name, nama, tanggal, created_at, id, phone, acara_id) {
        var conns = confirm("Confirm Transaksi ini ?");

        if (conns) {
            send_kwitansi(punia, name, nama, tanggal, created_at, id, phone, acara_id, url);
            //window.location = url;
        }
    }

    $("#t_date_picker").val(startdate);

    function filterDates(action) {
        var new_date = moment($("#t_date_picker").val(), "YYYY-MM-DD").add(1, 'days').format("YYYY-MM-DD");

        if (action == 1) {
            new_date = moment($("#t_date_picker").val(), "YYYY-MM-DD").subtract(1, 'days').format("YYYY-MM-DD");
        }

        //alert(new_date);
        $("#t_date_picker").val(new_date);
        loadDatatable("dateFilter=" + new_date);
    }



    $(function() {
        loadDatatable("dateFilter=" + startdate);

        $('#form_filter').on("submit", function(e) {
            e.preventDefault();
            loadDatatable();
        })
    });

    // function loadDatatable() {
    //     var param  = $('#form_filter').serialize();
    //     var url    = `{{ route('list-order.datatable') }}?${param}`;
    //     var config = {
    //         processing: true,
    //         serverSide: true,
    //         ajax      : url,
    //         responsive: true,
    //         columns   : [
    //             {data: 'created_at', name: 'pesertas.created_at'},
    //             {data: 'nama', name: 'pesertas.nama'},
    //             {data: 'name', name: 'acaras.name'},
    //             {data: 'telpon', name: 'pesertas.telpon'},
    //             {data: 'status_order', searchable : false, orderable : false},
    //             {
    //                 data: 'id', name: 'pesertas.id',
    //                 render : function(data) {
    //                     return `<a target="_blank" href="{{ route('list-order.index') }}/${data}" class="btn btn-info">Detail</a>`;
    //                 }
    //             },
    //         ]
    //     }

    //     if(table == null) {
    //         table = $('#datatable').DataTable(config);
    //     } else {
    //         table.ajax.url(url).load();
    //     }

    // }

    function cancel_order(id) {
        window.location = "<?php echo url('dashboard/cancel-order'); ?>" + "/" + id;
    }

    let arrayBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    function formatTanggal(values) {
        let vals = values.split(" ");
        let arr_bln = vals[0].split("-");

        let bulan = arrayBulan[(parseInt(arr_bln[1]) - 1)];
        return arr_bln[2] + " " + bulan + " " + arr_bln[0];
    }

    function send_kwitansi(punia, name, nama, tanggal, created_at, id, phone, acara_id, url) {
        //let rows = JSON.parse(data);
        let text = "Giriya Tri Dharma Sakti %0a" +
            "Jl Narakesuma Gang VII No 3 Denpasar%0a%0a" +
            "*TANDA TERIMA PEMBAYARAN*%0a" +
            "Telah diterima pembayaran sejumlah uang : " + formatRupiah(punia, "Rp. ") + "%0a" +
            "Untuk Pembayaran : " + name + "%0a" +
            "Nama Acara : " + name + "%0a" +
            "Nama Peserta: " + nama + "%0a" +
            "Tanggal : " + formatTanggal(tanggal) + "%0a" +
            "Jumlah Tagihan : " + formatRupiah(punia, "Rp. ") + "%0a" +
            "Sisa Tagihan : " + "0" + "%0a" +
            "Pembayaran diterima oleh: " + "%0a" +
            "Metode bayar : " + "transfer" + "%0a" +
            "Tanggal bayar : " + formatTanggal(created_at) + "%0a" +
            "No kwitansi : " + id + "%0a%0a" +
            "*YANG PERLU DIBAWA*%0a";

        $.ajax({
            type: "POST",
            data: "_token=<?php echo csrf_token(); ?>&acara_id=" + acara_id,
            url: "<?php echo url('dashboard/get_acara'); ?>",
            dataType: "json",
            success: function(data) {
                window.open("https://api.WhatsApp.com/send?phone=" + phone + "&text=" + text + data.yang_di_bawa);
                window.location = url;
            }
        })


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

    function loadDatatable(params) {
        var param = $('#form_filter').serialize();
        var url = `{{ route('list-order.datatableUpload') }}?${params}`;
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
                // {data: 'telpon', name: 'pesertas.telpon'},
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
                        return `<a href="{{ route('list-order.index') }}/${data}" class="btn btn-info">Detail</a>`;
                    }
                },
                {
                    data: 'id',
                    name: 'pesertas.id',
                    render: function(data, type, row) {
                        return `<button style="display:${row.sudah_bayar == 1 ? 'none' : 'inline-block'}" type="button" onclick="var conn = confirm('Yakin cancel data ini ?'); if(conn == true) { cancel_order(${data}) }" class="btn btn-danger">Batal</button>
                                    <a href="{{ route('list-order.index') }}/${data}" class="btn btn-warning">Cetak</a>
                                    <button  onclick="send_kwitansi(\'${row.punia}\',\'${row.name}\',\'${row.nama}\',\'${row.tanggal}\',\'${row.created_at}\',\'${row.id}\',\'${row.telpon}\',\'${row.acara_id}\')" class="btn btn-success">Kwitansi</button>`;
                    }
                },
                {
                    data: 'id',
                    name: 'pesertas.id',
                    render: function(data, type, row) {
                        return `<a href="${row.bukti_transfer}" data-fancybox data-caption="Bukti Pembayaran #${data}" class="btn btn-primary">Foto</a>
                                    <a style="display:${row.sudah_bayar == 0 ? 'inline-block' : 'none'}" href="javascript:void(0)" onclick="approved('${row.approve_url}' , \'${row.punia}\',\'${row.name}\',\'${row.nama}\',\'${row.tanggal}\',\'${row.created_at}\',\'${row.id}\',\'${row.telpon}\',\'${row.acara_id}\')" class="btn btn-success">Confirm</a>
                                    <a style="display:${row.sudah_bayar == 0 ? 'inline-block' : 'none'}" href="${row.reject_url}" class="btn btn-danger">Reject</a>`;
                    }
                },
            ]
        }

        if (table == null) {
            table = $('#datatable').DataTable(config);
        } else {
            table.ajax.url(url).load();
        }

        // Fancybox.bind("[data-fancybox]", {
        // // Your custom options
        // });

    }

    $(document).ready(function() {
        Fancybox.bind("[data-fancybox]", {
            // Your custom options
        });
    })
</script>
@endsection