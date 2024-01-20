@extends('layouts.app')

@section('links')
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet" />
@stop

@section('body')
<div class="peserta">
    <div class="row">
        <div class="col">
            <h1 style="font-size:21px;">List Pendaftaran Harian</h1>
        </div>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">List Penerima</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div id="list_penerima_uang">
                        <div class="row">
                            <div class="col-md-12 col-12 mt-2">
                                <div class="col-md-6 col-12">
                                    Penerima Uang 1
                                </div>
                                <div class="col-md-6 col-12">
                                    Rp. 150.000
                                </div>
                            </div>

                            <div class="col-md-12 col-12 mt-2">
                                <div class="col-md-6 col-12">
                                    Penerima Uang 2
                                </div>
                                <div class="col-md-6 col-12">
                                    Rp. 550.000
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form method="get" id="form_filter">
                <div class="row">
                    <!-- <div class="col-6 ">
                            <div class="form-group">
                                <select class="form-control" name="acara">
                                    <option value="">--Pilih Acara--</option>
                                    @foreach($acaras as $acara)
                                        <option value="{{ $acara->id }}"

                                            @if(Request::query('acara_id') == $acara->id)
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
                                        <option value="{{ $k }}"
                                            @if(Request::query('tipe_order') == $k)
                                                selected
                                            @endif
                                        >{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> -->
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
                    <a class="nav-item nav-link <?php echo (isset($_GET['status']) && $_GET['status'] == 1) ? "active" : "";  ?>" id="nav-home-tab" onclick="link_tab(1)" aria-selected="true" style="font-size:11px; cursor:pointer;">Belum Bayar</a>
                    <a class="nav-item nav-link <?php echo (isset($_GET['status']) && $_GET['status'] == '2') ? "active" : "";  ?>" id="nav-profile-tab" onclick="link_tab(2)" aria-selected="false" style="font-size:11px; cursor:pointer;">List Terima Uang</a>
                    <a class="nav-item nav-link <?php echo (isset($_GET['status']) && $_GET['status'] == 3) ? "active" : "";  ?>" id="nav-batal-tab" onclick="link_tab(3)" aria-selected="false" style="font-size:11px; cursor:pointer;">Batal</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <!-- <div class="card-header">
                            Belum Bayar
                            </div> -->
                    <div id="accordion">
                        <?php
                        $no = 0;
                        $ktm = 0;
                        foreach ($list_acara as $rows) {
                            $no++;
                            if (isset($_GET['id_acara'])) {
                                if ($_GET['id_acara'] == $rows->id_acara) {
                                    $ktm = $no;
                                }
                            } else {
                                $ktm = 1;
                            }
                        ?>

                        <div class="card">
                            <div class="card-header" id="heading<?php echo $rows->id_acara; ?>">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" onclick="window.location = `list-order?status=<?php echo $_GET['status']; ?>&id_acara=<?php echo $rows->id_acara; ?>&tanggal=${$('#t_date_picker').val()}`">
                                        <?php echo $rows->name; ?> ( <?php echo $rows->jml_peserta; ?> )
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse<?php echo $rows->id_acara; ?>" class="collapse <?php echo $no == $ktm ? "show" : ""; ?>" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <?php
                                        if (isset($_GET['id_acara'])) {
                                            if ($_GET['id_acara'] == $rows->id_acara) { ?>
                                    <table class="table" id="datatable">
                                        <thead>
                                            <th>ID & Tanggal Bayar & Peserta</th>
                                            <th>No. Daftar</th>
                                            <!-- <th>Acara</th> -->
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
                                    <?php
                                            }
                                        } else {
                                            if ($ktm == 1) {
                                            ?>
                                    <table class="table" id="datatable">
                                        <thead>
                                            <th>ID & Tanggal Bayar & Peserta</th>
                                            <th>No. Daftar</th>
                                            <!-- <th>Acara</th> -->
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
                                    <?php
                                            }
                                        }
                                        ?>
                                </div>

                                <?php
                                    if ($_GET['status'] == "2") {
                                    ?>
                                <div style="padding:20px 0;">
                                    <h5 style="font-size:18px; text-align:center;"> Total Punia </h5>
                                    <hr />

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6 col-6 justify-content-center text-center">
                                                <h5 style="font-size:15px;"> Belum Diterima <p></p> Rp. {{ number_format(($totalBelumTerima),0,'.','.') }} </h5>
                                            </div>

                                            <div class="col-md-6 col-6 justify-content-center text-center">
                                                <h5 style="font-size:15px;"> Sudah Diterima <p></p> Rp. {{ number_format(($totalSudahTerima),0,'.','.') }} </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                    ?>

                            </div>
                        </div>
                        <?php
                        }
                        ?>

                        <!-- <div class="card">
                                    <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Collapsible Group Item #2
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                    </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Collapsible Group Item #3
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                    </div>
                                    </div>
                                </div> -->
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
        function cancel_order(id) {
            window.location = "<?php echo url('dashboard/cancel-order'); ?>" + "/" + id;
        }



        function link_tab(status) {
            let tanggal = "<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : date("
            Y - m - d "); ?>";
            window.location = "list-order?status=" + status + "&tanggal=" + tanggal;
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
            window.location = "list-order?status=1&tanggal=" + new_date;
        }

        let arrayBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        function formatTanggal(values) {
            let vals = values.split(" ");
            let arr_bln = vals[0].split("-");

            let bulan = arrayBulan[(parseInt(arr_bln[1]) - 1)];
            return arr_bln[2] + " " + bulan + " " + arr_bln[0];
        }


        function send_kwitansi(punia, name, nama, tanggal, created_at, id, phone, acara_id) {

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
                type: "POST"
                , data: "_token=<?php echo csrf_token(); ?>&acara_id=" + acara_id
                , url: "<?php echo url('dashboard/get_acara'); ?>"
                , dataType: "json"
                , success: function(data) {
                    window.open("https://api.WhatsApp.com/send?phone=" + phone + "&text=" + text + data.yang_di_bawa);
                }
            })

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
            loadDatatable("status=<?php echo isset($_GET['status']) ? $_GET['status'] : '1'; ?>&id_acara=<?php echo isset($_GET['id_acara']) ? $_GET['id_acara'] : $acara_id; ?>&tanggal=<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : ''; ?>");

            $('#form_filter').on("submit", function(e) {
                e.preventDefault();
                loadDatatable();
            })
        });

        function loadDatatable(param) {
            //var param  = $('#form_filter').serialize();
            var url = `{{ route('list-order.datatable') }}?${param}`;
            var config = {
                processing: true
                , serverSide: true
                , searching: false
                , ajax: url
                , responsive: true
                , lengthChange: false
                , columns: [{
                        data: 'nama'
                        , name: 'pesertas.nama'
                        , render: function(data, type, row) {
                            return `<b>${formatTanggal(row.tanggal)}</b><br />${row.nama}`;
                        }
                    }
                    , {
                        data: 'id'
                        , name: 'pesertas.id'
                    },
                    // {data: 'name', name: 'acaras.name'},
                    {
                        data: 'telpon'
                        , name: 'pesertas.telpon'
                        , render: function(data, type, row) {
                            return `<a href="https://wa.me/${row.telpon}" target="_blank"><i class="fa fa-whatsapp"></i> ${row.telpon.toString()} </a>`;
                        }
                    }
                    , {
                        data: 'punia'
                        , name: 'pesertas.punia'
                        , render: function(data, type, row) {
                            return `${formatRupiah(row.punia.toString() , "Rp. ")}`;
                        }
                    }
                    , {
                        data: 'dibayarkan'
                        , name: 'pesertas.dibayarkan'
                        , render: function(data, type, row) {
                            return `${formatRupiah(data.toString() , "Rp. ")}`;
                        }
                    }
                    , {
                        data: 'dibayarkan'
                        , name: 'pesertas.dibayarkan'
                        , render: function(data, type, row) {
                            return `${formatRupiah(((parseInt(row.punia) - parseInt(row.kode_bayar)) - parseInt(data)).toString() , "Rp. ")}`;
                        }
                    }
                    , {
                        data: 'jumlah_peserta'
                        , name: 'pesertas.jumlah_peserta'
                    }
                    , {
                        data: 'status_order'
                        , searchable: false
                        , orderable: false
                    }
                    , {
                        data: 'created_at'
                        , name: 'pesertas.created_at'
                        , render: function(data, type, row) {
                            return `${row.created_at}`;
                        }
                    }
                    , {
                        data: 'id'
                        , name: 'pesertas.id'
                        , render: function(data, type, row) {
                            // style="display:${row.sudah_bayar == 1 ? 'none' : 'inline-block'
                            return `<div><div>
                                    <a href="{{ url('dashboard/list-order/bayar') }}/${data}" style="display:${row.sudah_bayar == 1 ? 'none' : 'inline-block'}" class="btn btn-success">Bayar</a>
                                    <a href="{{ url('dashboard/list-order/bayar') }}/${data}" class="btn btn-info">Detail</a>
                                    <a href="javascript:void(0)" onclick="$('#myModal').modal('show');" class="btn btn-danger">List Penerima</a>
                                    </div></div>`;
                        }
                    }
                    , {
                        data: 'id'
                        , name: 'pesertas.id'
                        , render: function(data, type, row) {
                            return `<div>
                                    <div style="display:${row.sudah_bayar == 0 ? 'none' : 'inline-block'}">
                                        <a href="{{ route('list-order.index') }}/${data}" class="btn btn-info">Terima</a>
                                    </div>
                                    <div style="display:${row.sudah_bayar == 1 ? 'none' : 'inline-block'}"><button style="display:${row.sudah_bayar == 1 ? 'none' : 'inline-block'}" type="button" onclick="var conn = confirm('Yakin cancel data ini ?'); if(conn == true) { cancel_order(${data}) }" class="btn btn-danger">Batal</button>
                                    <a href="{{ route('list-order.index') }}/${data}" class="btn btn-warning">Cetak</a>
                                    <button style="display:${row.sudah_bayar == 1 ? 'inline-block' : 'none'}" onclick="send_kwitansi(\'${row.punia}\',\'${row.name}\',\'${row.nama}\',\'${row.tanggal}\',\'${row.created_at}\',\'${row.id}\',\'${row.telpon}\')" class="btn btn-success">Kwitansi</button>
                                    </div>
                                    <div style="display:${row.sudah_bayar == 0 ? 'none' : 'inline-block'}">
                                    -
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

            if (table2 == null) {
                table2 = $('#datatable2').DataTable(config);
            } else {
                table2.ajax.url(url).load();
            }

        }

    </script>
    @endsection
