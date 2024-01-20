<div class="card" style="border-radius: 10px; padding-bottom:20px;">

    @php
    $image = @$acara->photos[0];
    $image_url = @$image->url;
    if($image_url == null) {
    $image_url = "dummy.jpg";
    }

    $label_jadwal = $acara->sistem_jadwal;
    // if($label_jadwal == 'Terjadwal') {
    // $jadwal = $acara->jadwals->first();
    // if($jadwal != null) {
    // $label_jadwal = \App\Http\Helpers\Tools::getFormalDate($jadwal->tanggal);
    // }
    // }

    @endphp

    <img src="{{ route('cdn.image.w&h', ['image'=> $image_url, 'width'=> 360,'height'=> 250]) }}" class="card-img-top" alt="...">
    <div class="card-body pb-0" style="overflow: auto;  height:auto; padding:2px!important; margin:2px!important;">
        <p class="card-title" style="font-weight: 700;text-transform: uppercase;font-size: 14px;">
            <div class="row">
                <div class="col-md-12 col-12" style="margin-top:-10px;">
                    <b>
                        {{ $acara->name }}
                    </b>
                </div>
                <!-- <div class="col-md-3 col-4">
                    <i class="fa fa-link" style="color:#666666; font-size:18px; cursor:pointer;" class="whatsapp-links" 
                        onclick="copy_text('<?php //echo strip_tags(html_entity_decode($acara->penjelasan)).'<p></p>'.$acara->susunan_acara; ?>')">
                    </i>&nbsp;
                    <i class="fa fa-whatsapp" style="color:green; font-size:18px;  cursor:pointer;"
                    onclick="share_wa()">
                    </i>
                </div> -->
            </div>
        </p>
        <div class="row mb-2">
            <div class="col-md-12 col-12">
                <div class="row">
                    <div class="col-md-9 col-8">
                        {{ $label_jadwal }}
                    </div>
                    {{-- <div class="col-md-3 col-4" style="text-align:right;">
                        <i class="fa fa-link" style="color:#666666; font-size:18px; cursor:pointer;" class="whatsapp-links" onclick="copy_text('*<?php echo $acara->name.'*\nPunia : Rp. '.number_format($acara->punia,0,',','.').'\n\n*1. DAFTAR :*\n'.url('acara/'.$acara->slug).'\n\n*'.'2. PENJELASAN*\n\n'.strip_tags(html_entity_decode($acara->penjelasan)).'\n\n*3. Susunan Acara*\n\n'.trim(strip_tags(html_entity_decode(preg_replace('/&nbsp;/','',$acara->susunan_acara)))).'\n\n*4. Sarana Yang Dibawa*\n\n'.trim(strip_tags(html_entity_decode(preg_replace('/&nbsp;/','',$acara->yang_di_bawa)))).'\n\n*5. Sarana Yang Didapat*\n\n'.trim(strip_tags(html_entity_decode(preg_replace('/&nbsp;/','',$acara->yang_di_dapat)))); ?>')">
                        </i>&nbsp;
                        <i class="fa fa-whatsapp" style="color:green; font-size:18px;  cursor:pointer;" onclick="window.open('<?php echo 'whatsapp://send?text='.url('acara/'.$acara->slug); ?>')">
                        </i>
                    </div> --}}
                    <div class="alert alert-warning p-1">
                        Belum ada jadwal
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-right col-12 mt-2" style="text-align:right;">
                <strong>Rp. {{ number_format($acara->punia,0,',','.') }}</strong>
            </div>
        </div>
    </div>


    <div class="card-body pt-0">
        @if($label_jadwal != '')
        <div class="row" style="align-items:flex-end;">
            <div style="max-height:100px; width:100%; overflow:auto;">
                {{ strip_tags(html_entity_decode($acara->penjelasan)) }}
            </div>
        </div>
        @else
        <div class="row" style="align-items:flex-end;"></div>
        @endif
    </div>

    @if($label_jadwal == 'Terjadwal')
    @if(count($acara->jadwals) > 0)
    <div class="card-body pt-0 pb-0" style="background: #f9f9f9 !important; max-height: 100px; overflow-y: scroll; min-height: 100px;">
        <!-- <select class="></select> -->
        <table class="table table1">
            @foreach($acara->jadwals as $key=>$jadwal)
            <tr>
                <td style="border: none;padding-right:3px;">{{ date("d M Y",strtotime($jadwal->tanggal)) }}</td>
                <td style="border: none;" class="text-right">
                    @if($jadwal->is_closed)
                    <button class="btn btn-danger btn-sm"> Penuh</button>
                    @else
                    <a href="{{ route('daftar.index',['acara_id'=>$acara->id,'jadwal_id'=>$jadwal->id]) }}" class="btn btn-primary btn-sm mt-2"> Daftar</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @else
    <div class="card-body pt-0 pb-0">
        <div class="alert alert-warning p-1">
            Belum ada jadwal
        </div>
    </div>
    @endif
    @endif

    <div class="row" style="padding:0!important; margin:0!important;">
        <div class="col-md-12">
            {{-- @if($label_jadwal == 'Setiap Hari')
            <a href="/daftar/{{ $acara->id }}/acara" class="btn btn-primary btn-block" style="margin-top:10px;">Mendaftar</a>
            @endif --}}
            <div class="alert alert-warning p-1">
                Belum ada jadwal
            </div>
        </div>
        {{-- <div class="col-md-6">
            <a href="/acara/{{ $acara->slug }}" class="btn btn-default btn-block" style="margin-top:10px;">Detail</a>
    </div> --}}
</div>

</div>
