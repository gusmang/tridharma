<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="author" content="wayansukerta.com" />
<x-meta-s-e-o :metas="$pengaturan"/>
<!-- VENDOR CSS -->
<link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/assets/vendor/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="/assets/vendor/animate-css/vivify.min.css" />
<link rel="stylesheet" href="/assets/vendor/toastr/toastr.min.css" />
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.26/dist/sweetalert2.min.css" rel="stylesheet">

@yield('links')

<!-- MAIN CSS -->
<link rel="stylesheet" href="/assets/css/mooli.min.css" />
<link rel="stylesheet" href="/css/app.css" />
<link rel="stylesheet" href="/css/custom.css" />

<style>
    .float-bottom {
        position: fixed;
        bottom: 10px;
        right: 10px;
    }
</style>
</head>
<body class="visible">

<div id="body" class="theme-cyan">

    <!-- Page Loader -->
    {{-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="/img/logo.jpg" width="40" height="40" alt="Mooli"></div>
            <p>Please wait...</p>
        </div>
    </div> --}}

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <div id="wrapper">
        <!-- Main body part  -->
        <div id="main-content">
            
            @yield('body')

            <div class="footer mt-5 pt-3 pb-2" style="background: #00B4DB;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #0083B0, #00B4DB);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #0083B0, #00B4DB); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
">
                <div class="container ">
                    <div class="row mt-5 mb-5">
                        <div class="col-lg-6 pt-5">
                        <h3>{{ $pengaturan? ( isset($pengaturan['nama_aplikasi'])?$pengaturan['nama_aplikasi']:'' ) : 'nama_aplikasi'  }}</h3>
                        <h5 class="mb-5">{!! $pengaturan? ( isset($pengaturan['subtitle_aplikasi'])?$pengaturan['subtitle_aplikasi']:'' ) : 'nama_aplikasi'  !!}</h5>
                        {!! $pengaturan? ( isset($pengaturan['alamat'])?$pengaturan['alamat']:'' ) : 'nama_aplikasi'  !!}
                        <a href="" class="btn btn-light rounded-circle"><i class="fa fa-facebook"></i></a>
                        <a href="" class="btn btn-light rounded-circle"><i class="fa fa-instagram"></i></a>
                        </div>
                        <div class="col-lg-6">
                        {!! $pengaturan? ( isset($pengaturan['maps'])?$pengaturan['maps']:'' ) : 'nama_aplikasi'  !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="float-bottom">


        </div>

    </div>


    <nav class="navbar navbar-dark bg-secondary navbar-expand d-md-none d-lg-none d-xl-none fixed-bottom" style="background: #ffff !important;padding:10px 0;">
        <ul class="nav justify-content-center w-100">
          <li class="nav-item mr-1 ml-1">
            <a href="https://api.whatsapp.com/send/?phone=628123905621" role="button" class="btn btn-success" target="_blank"><i class="fa fa-whatsapp text-light"></i> <span style="font-size: 11px;">Whatsapp kami</span></a>
          </li>
          <li class="nav-item mr-1 ml-1">
            <a href="{{ route('konfirmasi.pembayaran') }}" role="button" class="btn btn-warning"><span style="font-size: 11px;">Konfirmasi Bayar</span></a>
          </li>

          <li class="nav-item mr-1 ml-1">
            <a href="{{ route('konfirmasi.sertifikat') }}" role="button" class="btn btn-info"><span style="font-size: 11px;">Piagam</span></a>
          </li>
        </ul>
    </nav>

</div>
<!-- Javascript -->
<script src="/assets/bundles/libscripts.bundle.js"></script>
<script src="/assets/bundles/vendorscripts.bundle.js"></script>
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/toastr/toastr.js"></script>
@yield('scripts')
<script>
    @if(Session::get('notif-success'))
        toastr['success'](' {{Session::get("notif-success")}} ');
    @endif
    @if(Session::get('notif-info'))
    toastr['info'](' {{Session::get("notif-info")}} ');
    @endif
    @if(Session::get('notif-warning'))
    toastr['warning'](' {{Session::get("notif-warning")}} ');
    @endif
    @if(Session::get('notif-danger'))
    toastr['danger'](' {{Session::get("notif-danger")}} ');
    @endif

    @if ($errors->any())
    toastr['warning'](' Validation Failed ');
    @endif
</script>
<script>

    function searchData(){
        window.location = "<?php echo url('/'); ?>" + "?sr="+$("#inputUpacara").val();
    }

    function copy_text(copyText){
        navigator.clipboard.writeText(copyText);
        toastr['info']('Copy text berhasil, silahakan paste textnya');
    }

    $("#inputUpacara").keypress(function(e) {
        if(e.which == 13) {
            window.location = "<?php echo url('/'); ?>" + "?sr="+this.value
        }
    });

    jQuery(document).ready(function($){
        $(window).on('load',function(){
            $(".page-loader-wrapper").fadeOut('slow');
        })
    })
</script>
<style>
    #main-content {
        width: 100%;
        margin-top: 0;
        padding: 0;
    }
    .navbar-fixed-top{
        width:100%;
        margin: 0;
    }
    .table1 td {
        padding:0;
    }


    /*
    h5.card-title {
        font-size: 12px;
        font-weight: 700;
        min-height: 32px;
    }

    p.card-text {
        font-size: 12px;
        color: #28a745;
        font-weight: 600;
    }

    .card-body {
        padding: 10px;
    }
    */
</style>
</body>
</html>
