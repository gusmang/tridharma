<?php
     function getFormalDate($date = null)
    {
        if ($date == null) {
            return '';
        }
        $date_ar = explode("-", $date);
        $bulan_ar = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $date_ar[2] . " " . $bulan_ar[(int)$date_ar[1]] . " " . $date_ar[0];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Piagam {{ $peserta->nama }}</title>

    @include('pdf.style')

    <style>
        .display-font {
            font-family: 'Oswald', sans-serif;
        }

        @page {
            margin-top: 0.5cm;
            margin-bottom: 2.5cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            border: 1cm solid #000;
        }

        .text-thin {
            font-weight: normal;
        }

    </style>
</head>
<body style="border:double 30px solid">
    {{-- <div style="background-image:url('https://giriya.iddevweb.com/bingkai-sertifikat-31360.png');"> --}}
    <div style="position: relative;">

        <div style="position: absolute; z-index: 1; width: 100%; height: 100%;">
            {{-- <img src="https://giriya.iddevweb.com/bingkai-sertifikat-31360.png" width="100%" height="100%" /> --}}
            <img src="https://giriyatridharma.com/bingkai_new.jpeg" width="100%" height="100%" />
        </div>

        <div style="z-index: 5; position: absolute; bottom: 250px; left: 100px;">
            <img src="https://giriyatridharma.com/stempel.jpeg" style="max-width:150px" class="mx-auto d-block" />
        </div>

        {{-- @include('pdf.kop') --}}
        <div style="z-index: 10; position: absolute; padding: 40px 50px;">
            <br />
            <h3 class="text-center">PIAGAM PELAKSANAAN ACARA</h3>
            <div class="text-center mx-auto d-block" style="display:block;margin:0 auto;">
                <img src="https://giriyatridharma.com/om3.png" style="max-width:200px" class="mx-auto d-block" />
                <p>Om Awignam Astu Namo Siddham..</p>
            </div>
            <h4 class="text-center text-thin">Piagam ini kami berikan kepada:</h4>
            <h2 class="text-center">{{ $peserta->nama }}</h2>
            <h4 class="text-center text-thin">Telah melaksanakan/mengikuti acara</h4>
            <h2 class="text-center">{{ $peserta->acara->name }}</h2>

            <h3 class="text-center text-thin">Pada tanggal : <strong>{{ getFormalDate($peserta->tanggal) }}</strong></h3>
            <div style="height: 10px;"></div>
            <h3 class="text-center text-thin">Bertempat di :</h3>
            <h1 class="text-center text-strong"><strong>Giriya Tri Dharma Sakti</strong></h1>
            <h3 class="text-center text-thin">yang beralamat di:<br><strong> {!! ($pengaturan['alamat']) !!}</strong></h3>
            <h4 class="text-center text-thin"> Om Siddhirastu tat astu ya namah swaha.</h4>

            <br />
            <h4 class="text-center text-thin">Denpasar, {{ getFormalDate($peserta->tanggal) }}</h4>
            {{-- <br />
            <p>&nbsp;</p> --}}
            <center>
                <img src="https://giriyatridharma.com/tanda_tangan.jpeg" style="width:160; height: 80px;" class="mx-auto d-block" />
            </center>

            <h4 class="text-center text-thin"><strong>Ida Pandita Mpu A Gni Jaya Saktya Dharma Daksa</strong></h4>

        </div>
    </div>
</body>
</html>
