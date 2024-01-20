<div>

    @if($telepon == null || $telepon == "")
        -
    @else
        <a href="https://wa.me/{{ $telepon }}" target="_blank"><i class="fa fa-whatsapp"></i> {{ $telepon }}</a>
    @endif
</div>
