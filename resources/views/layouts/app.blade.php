<!doctype html>
<html lang="en">

<head>
    <title>Griya Tri Dharma | {{ isset($title)?$title:'Dashboard'}}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="description" content="Mooli Bootstrap 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities." />
    <meta name="author" content="GetBootstrap, design by: puffintheme.com" />

    <link rel="icon" href="/img/logo.jpg" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/vendor/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/vendor/animate-css/vivify.min.css" />
    <link rel="stylesheet" href="/assets/vendor/toastr/toastr.min.css" />
    @yield('links')

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="/assets/css/mooli.min.css" />
    <link rel="stylesheet" href="/css/admin.css" />
    <style>
        .scrum-body .scrum-task {
            cursor: auto;
        }

        a.dropdown-toggle.user-name:before {
            content: "";
            width: 15px;
            height: 15px;
            display: inline-block;
            border-radius: 50%;
        }

        a.dropdown-toggle.user-name:before {
            background: #0efb0e;
        }

    </style>
</head>

<body class="visible">

    <div id="body" class="theme-cyan">

        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img src="/img/logo.jpg" width="40" height="40" alt="Mooli"></div>
                <p>Please wait...</p>
            </div>
        </div>

        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>

        <div id="wrapper">

            <!-- Page top navbar -->
            <nav class="navbar navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-left">
                        <div class="navbar-btn">
                            <a href="index.html"><img src="/assets/images/icon.svg" alt="Mooli Logo" class="img-fluid logo"></a>
                            <button type="button" class="btn-toggle-offcanvas"><i class="fa fa-align-left"></i></button>
                        </div>
                    </div>
                    {{-- <div style="text-align:left; width: 62%; font-size: 12px;"> --}}
                    {{-- Belum Diterima : Rp. 1.050.000 <br />
                        Sudah Diterima : Rp. 1.250.000 --}}
                    {{-- </div> --}}
                    <div class="navbar-right">
                        <div id="navbar-menu">
                            <ul class="nav navbar-nav">
                                <li class="dropdown hidden-xs">
                                    <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">Buat</a>
                                    <div class="dropdown-menu pb-0 mt-0">
                                        <a class="dropdown-item pt-2 pb-2" href="{{ route('acara.create') }}">Acara</a>
                                        <a class="dropdown-item pt-2 pb-2" href="{{ route('jadwal-acara.create') }}">Jadwal Acara</a>
                                        <a class="dropdown-item pt-2 pb-2" href="{{ route('peserta.create') }}">Perserta</a>
                                    </div>
                                </li>
                                <li class="hidden-xs"><a href="javascript:void(0);" id="btnFullscreen" class="icon-menu"><i class="fa fa-arrows-alt"></i></a></li>
                                <li><a href="/auth/logout" class="icon-menu"><i class="fa fa-power-off"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main left sidebar menu -->
            <div id="left-sidebar" class="sidebar">
                <a href="#" class="menu_toggle"><i class="fa fa-angle-left"></i></a>
                <div class="navbar-brand">
                    <a href="/"><img src="/img/logo.jpg" alt="{{ __('Griya Tri Dharma') }}" class="img-fluid logo"><span>{{ __('Griya Tri Dharma') }}</span></a>
                    <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="lnr lnr-menu fa fa-chevron-circle-left"></i></button>
                </div>
                <div class="sidebar-scroll">
                    <div class="user-account">
                        <div class="user_div">
                            <img src="/assets/images/user.png" class="user-photo" alt="{{Auth::user()->first_name}} {{ Auth::user()->last_name}}">
                        </div>
                        <div class="dropdown">
                            <span> {{ Auth::user()->role}}</span>
                            <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"> <span></span> <strong>{{Auth::user()->first_name}} {{ Auth::user()->last_name}}</strong></a>
                            <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                                <li><a href="/profile"><i class="fa fa-user"></i>My Profile</a></li>
                                <li><a href="/profile/setting"><i class="fa fa-gear"></i>Settings</a></li>
                                <li class="divider"></li>
                                <li><a href="/auth/logout"><i class="fa fa-power-off"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <nav id="left-sidebar-nav" class="sidebar-nav" style="padding-bottom:80px;">
                        <ul id="main-menu" class="metismenu animation-li-delay">
                            <li class="header">Main</li>
                            @if(Auth::user()->role == 'admin')
                            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>


                            <li class="header">Acara</li>
                            <li><a href="{{ route('acara.index') }}"><i class="fa fa-calendar-o"></i> <span>Semua Acara</span></a></li>
                            <li><a href="{{ route('jadwal-acara.index') }}"><i class="fa fa-clock-o "></i> <span>Jadwal Acara</span></a></li>
                            <li><a href="{{ route('acara.create') }}"><i class="fa fa-plus-square-o"></i> <span>Tambah Acara</span></a></li>
                            <li><a href="{{ route('old-list-order.index').'?status=1&tanggal='.date('Y-m-d') }}"><i class="fa fa-list"></i> <span>List Pendaftaran</span></a></li>
                            <li><a href="{{ route('list-order.index').'?status=1&tanggal='.date('Y-m-d') }}"><i class="fa fa-list"></i> <span>List Pendaftaran Harian</span></a></li>
                            <li><a href="{{ route('list-terima.index').'?status=1&tanggal='.date('Y-m-d') }}"><i class="fa fa-user"></i> <span>list Terima Pembayaran</span></a></li>
                            <li><a href="{{ route('dokumentasi-acara.index').'?status=1&tanggal='.date('Y-m-d') }}"><i class="fa fa-photo"></i> <span>Agenda Acara</span></a></li>

                            <li class="header">Halaman</li>
                            <li><a href="{{ route('halaman.index') }}"><i class="fa fa-file-o"></i> <span>Semua halaman</span></a></li>
                            <li><a href="{{ route('halaman.create') }}"><i class="fa fa-plus"></i> <span>Buat halaman</span></a></li>


                            <li class="header">Report</li>
                            <li><a href="{{ route('peserta.index') }}"><i class="fa fa-users"></i> <span>Peserta</span></a></li>
                            {{-- <li><a href="{{ route('pembayaran.index') }}"><i class="fa fa-usd"></i> <span>Pembayaran</span></a></li> --}}
                            <li><a href="{{ route('pembayaran.index') }}"><i class="fa fa-usd"></i> <span>Pembayaran</span></a></li>
                            <li><a href="{{ route('laporan-acara.index') }}"><i class="fa  fa-check-square"></i> <span>Acara</span></a></li>
                            <li><a href="{{ route('transfer-cash.index') }}"><i class="fa  fa-check-square"></i> <span>Cash</span></a></li>

                            <li class="header"></li>
                            <li><a href="/dashboard/pengaturan"><i class="fa fa-gear"></i> <span>Pengaturan</span></a></li>
                            <li><a href="{{ route('user.index') }}"><i class="fa fa-user"></i> <span>user</span></a></li>

                            @else
                            <li class="header">Acara</li>
                            <li><a href="{{ route('old-list-order.index').'?status=1&tanggal='.date('Y-m-d') }}"><i class="fa fa-list"></i> <span>List Pendaftaran</span></a></li>
                            <li><a href="{{ route('list-order.index').'?status=1&tanggal='.date('Y-m-d') }}"><i class="fa fa-list"></i> <span>List Pendaftaran Baru</span></a></li>
                            <li><a href="{{ route('list-order.index').'?status=1&tanggal='.date('Y-m-d') }}"><i class="fa fa-list"></i> <span>List Pendaftaran Harian</span></a></li>
                            <li><a href="{{ route('dokumentasi-acara.index').'?status=1&tanggal='.date('Y-m-d') }}"><i class="fa fa-photo"></i> <span>Agenda Acara</span></a></li>

                            <li class="header">Report</li>
                            <li><a href="{{ route('transfer-cash.index') }}"><i class="fa  fa-check-square"></i> <span>Cash</span></a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main body part  -->
            <div id="main-content">
                <div class="container-fluid pt-3">
                    @yield('body')
                </div>
            </div>

        </div>

    </div>
    <!-- Javascript -->
    <script src="/assets/bundles/libscripts.bundle.js"></script>
    <script src="/assets/bundles/vendorscripts.bundle.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/toastr/toastr.js"></script>

    <!-- Vedor js file and create bundle with grunt  -->


    <!-- Project core js file minify with grunt -->
    <script src="/assets/bundles/mainscripts.bundle.js"></script>
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

        // @if($errors-> any())
        // toastr['warning'](' Validation Failed ');
        // @endif

    </script>
    <style>
        :root {
            --border-color: #d0d0d0;
        }

    </style>
</body>

</html>
