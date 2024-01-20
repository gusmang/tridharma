@extends('layouts.front')

@section('body')

<link rel="stylesheet" href="{{ asset('assets/vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css') }}" />


<div class="container">
    <x-hero-section :pengaturan="$pengaturan" />

    <div class="row" style="margin-top: -30px; position: -webkit-sticky; position: sticky; top: 0; margin-bottom:20px; z-index:999; background:#f1f1f1; padding:20px 0;">

        <div class="col-md-1 col-2 d-flex justify-content-center" style="height:55px; align-items:center;">
            <a href="{{ url('/') }}"> <i class="fa fa-home" style="font-size:36px;"></i> </a>
        </div>

        <div class="col-md-11 col-10" style="position:relative;">
            <input type="text" style="color:#000000;" value="<?php echo isset($_GET['sr']) ? $_GET['sr'] : ""; ?>" id="inputUpacara" class="form-control bg-white px-3 py-3" placeholder="Input Pencarian Upacara .." />

            <div style="position:absolute; right:40px; top:10px; font-size:21px;" onclick="searchData()">
                <i class="fa fa-search"></i>
            </div>
            <div style="position:absolute; right:20px; top:10px; font-size:21px;" onclick="searchData()">
                <a href="{{ url('/') }}"> X </a>
            </div>

        </div>

    </div>

    <section>

        <div class="owl-carousel">
            @foreach($slider as $k => $acara)
            @php
            $image = @$acara->photos[0];
            $image_url = @$image->url;
            if($image_url == null) {
            $image_url = "dummy.jpg";
            }
            @endphp

            <div class="card" style="border-radius: 10px; overflow: hidden;">
                <img src="{{ route('cdn.image.w&h',['image'=> $image_url, 'width'=> 400,'height'=> 300]) }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-title" style="font-weight: 700;text-transform: uppercase;font-size: 14px;">{{ $acara->name }}</p>
                    <p class="card-text">{{ $acara->sistem_jadwal }}</p>

                    <div class="row">
                        <div class="col">
                            <p class="card-text">Rp. {{ number_format($acara->punia,0,',','.') }}</span></p>
                        </div>
                        <div class="col text-right">
                            <a href="/acara/{{ $acara->slug }}" class="btn btn-default">PEMESANAN</a>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </div>

    </section>

    <section class="list-acara" style="margin-top:0;">

        @php
        $index = 0;
        @endphp

        @foreach($acaras as $acara)

        @if($index == 0)
        <div class="row mt-8">
            @endif

            <div class="col-md-3 col-sm-6 col-xs-6 col-6" style="margin:-12px 0 0 0; padding:1px;overflow:auto;">
                <x-acara-thumbnail :acara="$acara"></x-acara-thumbnail>
            </div>

            @php
            $index++;
            @endphp

            @if($index == 4)
        </div>
        @php
        $index = 0;
        @endphp
        @endif

        @endforeach

        @if($index != 0)
</div>
@endif
</section>


<!-- CTA -->
<div class="card social theme-bg gradient rounded">
    <div class="profile-header d-sm-flex justify-content-between justify-content-center">
        <div class="d-flex">
            <div class="mr-3">
                <img src="{{ route('cdn.image', ['image'=> $pengaturan['feature_image']]) }}" class="rounded" alt="">
            </div>
            <div class="details">
                <h5 class="mb-0">Agenda Harian</h5>
                <span class="text-light">Lihat Daftar Agenda Harian dari Acara yang sudah dilakukan.</span>
            </div>
        </div>
        <div>
            <a href="{{ route('agenda.index') }}" class="btn btn-dark">Lihat Agenda</a>
        </div>
    </div>
</div>
<!-- End CTA -->

</div>
@endsection


@section('scripts')
<script src="{{ asset('assets/vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".owl-carousel").owlCarousel({
            margin: 10
            , loop: true
            , items: 1.5
            , autoplay: true
            , autoplayTimeout: 2000
            , autoplayHoverPause: true
        });
    });

    $(function() {
        // (Optional) Active an item if it has the class "is-active"
        $(".accordion2 > .accordion-item.is-active").children(".accordion-panel").slideDown();

        $(".accordion2 > .accordion-item").click(function() {
            // Cancel the siblings
            $(this).siblings(".accordion-item").removeClass("is-active").children(".accordion-panel").slideUp();
            // Toggle the item
            $(this).toggleClass("is-active").children(".accordion-panel").slideToggle("ease-out");
        });
    });

</script>
@endsection
