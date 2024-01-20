
<div class="card n_category">
    <div id="slider1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($peserta->dokumentasi as $k => $dok)
            <div class="carousel-item {{ $k == 0 ? 'active' : '' }}">
                <img class="d-block w-100" src="{{ route('cdn.image.thumbnail', $dok->url) }}" alt="">
            </div>
            @endforeach
        </div>
    </div>
    <div class="card-body">
        <h5 class="card-title">
            <a href="javascript:void(0);">{{ $peserta->name }}</a>
        </h5>
        <p class="card-text">Acara yang diikuti oleh {{ $peserta->nama }}</p>
        <p class="card-text">
            <small class="text-muted">Dilakukan pada {{ $peserta->tanggal }}</small>
        </p>
    </div>
</div>

