@extends('layouts.app')

@section('links')
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet" />
@stop

@section('body')
<div class="peserta">
    <div class="row">
        <div class="col">
            <h4>Report Pembayaran Cash</h4>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form onsubmit="change_acara(this); return false;">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Agenda</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row"></div>
                            <div class="col-md-12"><b> No. Daftar : </b> </div>
                            <div class="col-md-12">
                                <div id="no_acara"> </div>
                                <input type="hidden" name="no_daftar" id="no_daftar" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="row"></div>
                            <div class="col-md-12"><b> Tanggal Acara : </b></div>
                            <div class="col-md-12">
                                <input type="date" name="date_tanggal_acara" id="date_tanggal_acara" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form method="get" id="form_filter">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="col-md-9 col-12">
                            <div class="row justify-content-center">
                                <div class="col-2 col-md-1 d-flex justify-content-center" style="align-items:center; cursor:pointer;" onclick="filterDates(1)">
                                    <i class="fa fa-chevron-left"></i>
                                </div>
                                <div class="col-8 col-md-10 d-flex justify-content-center">
                                    <input onchange="filterDates(2)" type="date" name="t_date_picker" id="t_date_picker" value="<?php echo !isset($_GET['tanggal']) ? date('Y-m-d') : $_GET['tanggal']; ?>" class="form-control" style="background:white;" />
                                </div>
                                <div class="col-2 col-md-1 d-flex justify-content-center" style="align-items:center; cursor:pointer;" onclick="filterDates(0)">
                                    <i class="fa fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12 text-right">
                            <button type="submit" class="btn btn-info">Filter</button>
                            <a href="{{ route('list-order.index') }}" class="btn btn-success">Reset Filter</a>
                        </div> -->
                </div>
            </form>
        </div>
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link <?php echo (isset($_GET['status']) && $_GET['status'] == 1) ? "active" : "";  ?>" id="nav-home-tab" onclick="link_tab(1)" aria-selected="true" style="font-size:11px; cursor:pointer;">Belum Terima</a>
                    <a class="nav-item nav-link <?php echo (isset($_GET['status']) && $_GET['status'] == 2) ? "active" : "";  ?>" id="nav-home-prof" onclick="link_tab(2)" aria-selected="true" style="font-size:11px; cursor:pointer;">Sudah Diterima</a>

                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div style="font-size: 12px;">Total Belum Diterima : Rp. <?php echo $jmlTotal; ?></div>
                    <table class="table" id="datatable">
                        <thead>
                            <th>Nama Peserta</th>
                            <th>Nominal</th>
                            <th>Nama penerima</th>
                            <th>Tanggal Acara</th>
                            <th>Telp/Wa</th>
                            <th>Punia</th>
                            <th>Jml Peserta</th>
                            <th>Nomor Urut</th>
                            <th>Action 1</th>
                            <th>Action 2</th>
                        </thead>
                    </table>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
<script src="<?php echo asset('js/moment.js'); ?>" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<script>
    let status_login = "<?php echo Auth::user()->role; ?>";

    function cancel_order(id) {
        window.location = "<?php echo url('dashboard/cancel-order'); ?>" + "/" + id;
    }

    function link_tab(status) {
        let tanggal = "<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'); ?>";
        window.location = "transfer-cash?status=" + status + "&tanggal=" + tanggal;
    }

    var table = null;
    var table2 = null;
    var startdate = moment().subtract(1, "days").format("YYYY-MM-DD");

    var nowsdate = moment().format("YYYY-MM-DD");

    //$("#t_date_picker").val(startdate);

    function filterDates(action) {
        var new_date = moment($("#t_date_picker").val(), "YYYY-MM-DD").format("YYYY-MM-DD");

        if (action == 1) {
            new_date = moment($("#t_date_picker").val(), "YYYY-MM-DD").subtract(1, 'days').format("YYYY-MM-DD");
        } else if (action == 0) {
            new_date = moment($("#t_date_picker").val(), "YYYY-MM-DD").add(1, 'days').format("YYYY-MM-DD");
        }

        //alert(new_date);
        $("#t_date_picker").val(new_date);
        //loadDatatable("dateFilter="+new_date);
        window.location = "transfer-cash?status=1&tanggal=" + new_date;
    }

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
        var number_string = angka.replace(/[^,\d]/g, '').toString()
            , split = number_string.split(',')
            , sisa = split[0].length % 3
            , rupiah = split[0].substr(0, sisa)
            , ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(function() {
        loadDatatable("status=<?php echo isset($_GET['status']) ? $_GET['status'] : '1'; ?>&tanggal=<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : ''; ?>");

        $('#form_filter').on("submit", function(e) {
            e.preventDefault();
            loadDatatable();
        })
    });

    function showModals(id, kode, tanggal) {
        $('#myModal').modal('show');
        $("#no_acara").html(id);
        $("#date_tanggal_acara").val(tanggal);
        $("#no_daftar").val(id);
    }

    function change_acara(form) {
        var serialize_params = $(form).serialize();

        $.ajax({
            type: "POST"
            , url: "<?php echo url('dashboard/change-agenda'); ?>"
            , data: serialize_params
            , dataType: "json"
            , success: function(data) {
                if (data.status == 200) {
                    loadDatatable("status=<?php echo isset($_GET['status']) ? $_GET['status'] : '1'; ?>&tanggal=<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : ''; ?>");
                }
            }

        })
    }

    function loadDatatable(param) {
        //var param  = $('#form_filter').serialize();
        var url = `{{ route('report-cash.datatable') }}?${param}`;
        var config = {
            processing: true
            , serverSide: true
            , ajax: url
            , responsive: true
            , lengthChange: false
            , searching: false
            , info: false
            , paging: false
            , columns: [{
                    data: 'nama_peserta'
                    , name: 'nama_peserta'
                    , render: function(data, type, row) {
                        return `${row.nama_peserta}`;
                    }
                }
                , {
                    data: 'nominal'
                    , name: 'nominal'
                    , render: function(data, type, row) {
                        return `${formatRupiah(data.toString(), "Rp. ")}`;
                    }
                }
                , {
                    data: 'nama_penerima'
                    , name: 'nama_penerima'
                }
                , {
                    data: 'tanggal'
                    , name: 'tanggal'
                }
                , {
                    data: 'telpon'
                    , name: 'pesertas.telpon'
                    , render: function(data, type, row) {
                        return `<a href="https://wa.me/${row.telpon}" target="_blank"><i class="fa fa-whatsapp"></i> ${row.telpon.toString()} </a>`;
                    }
                }
                , {
                    data: 'punia'
                    , name: 'punia'
                    , render: function(data, type, row) {
                        return `${formatRupiah(data.toString(), "Rp. ")}`;
                    }
                }
                , {
                    data: 'jumlah_peserta'
                    , name: 'jumlah_peserta'
                }
                , {
                    data: 'nomor_urut'
                    , name: 'nomor_urut'
                }
                , {
                    data: 'id'
                    , name: 'id'
                    , render: function(data, type, row) {
                        return `<div>
                                    <a href="{{ url('dashboard/dokumentasi-acara/bayar') }}/${data}" style="display:${row.sudah_bayar == 1 && status_login == 'admin' ? 'none' : 'inline-block'}" class="btn btn-success">Terima</a>
                                    <a href="{{ url('dashboard/dokumentasi-acara/bayar') }}/${data}" style="display:${row.sudah_bayar == 1 ? 'none' : 'inline-block'}" class="btn btn-danger">Bayar</a>
                                    <a href="{{ url('dashboard/list-order/bayar') }}/${data}" style="display:${row.is_cash == 1 ? 'inline-block' : 'none'}" class="btn btn-danger">Detail</a>
                                    <div style="display:${row.sudah_bayar == 0 ? 'none' : 'inline-block'}">
                                        <a href="{{ route('dokumentasi-acara.index') }}/${data}" class="btn btn-info">Upload</a>
                                    </div>
                                    </div>`;
                    }
                }
                , {
                    data: 'id'
                    , name: 'pesertas.id'
                    , render: function(data, type, row) {
                        return `<div>
                                    <div style="display:${row.sudah_bayar == 1 ? 'none' : 'inline-block'}"><button style="display:${row.sudah_bayar == 1 ? 'none' : 'inline-block'}" type="button" onclick="var conn = confirm('Yakin cancel data ini ?'); if(conn == true) { cancel_order(${data}) }" class="btn btn-danger">Batal</button>
                                    <a href="javascript:void(0)" class="btn btn-success" onClick="showModals(${row.id},${row.kode_bayar},'${row.tanggal}')"> Edit</a>
                                    <a href="{{ route('dokumentasi-acara.index') }}/${data}" class="btn btn-warning">Cetak</a>
                                    
                                    <button style="display:${row.sudah_bayar == 1 ? 'inline-block' : 'none'}" onclick="send_kwitansi(\'${row.punia}\',\'${row.name}\',\'${row.nama}\',\'${row.tanggal}\',\'${row.created_at}\',\'${row.id}\',\'${row.telpon}\')" class="btn btn-success">Kwitansi</button>
                                    </div>
                                    <div style="display:${row.sudah_bayar == 0 ? 'none' : 'inline-block'}">
                                    <a href="javascript:void(0)" class="btn btn-success" onClick="showModals(${row.id},${row.kode_bayar},'${row.tanggal}')"> Edit</a>
                                    </div>
                                    </div>`;
                    }
                }
            , ]
        }

        if (table == null) {
            table = $('#datatable').DataTable(config);
        } else {
            table.ajax.url(url).load();
        }

        /*if (table2 == null) {
            table2 = $('#datatable2').DataTable(config);
        } else {
            table2.ajax.url(url).load();
        }*/

    }

</script>
@endsection
