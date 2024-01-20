@extends('layouts.front')

@section('body')
<div class="container">
    <x-hero-section :pengaturan="$pengaturan"/>

    <div class="row">

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

    <section class="list-acara mt-5">
        @php $peserta = Session::get('peserta') @endphp
        <div class="row ">
            <div class="col-lg-10">
                <div class="card">

                    <div class="card-header bg-info">
                        <h1>Selamat , pendaftaran anda sukses</h1>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-5">Nomor Pendaftaran</div>
                            <div class="col-1"> : </div>
                            <div class="col-lg-9 col-md-8 col-6">{{ $peserta->id }}</div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <div class="col-lg-2 col-md-3 col-5">Acara</div>
                            <div class="col-1"> : </div>
                            <div class="col-lg-9 col-md-8 col-6">{{ $peserta->acara->name }}</div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <div class="col-lg-2 col-md-3 col-5">Tanggal/Jadwal</div>
                            <div class="col-1"> : </div>
                            <div class="col-lg-9 col-md-8 col-6">{{ $peserta->tanggal }}@if($peserta->jadwal) / {{ $peserta->jadwal->dinan }} @endif </div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <div class="col-lg-2 col-md-3 col-5">Nama Peserta</div>
                            <div class="col-1"> : </div>
                            <div class="col-lg-9 col-md-8 col-6">{{ $peserta->nama }} </div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <div class="col-lg-2 col-md-3 col-5">Jumlah Peserta</div>
                            <div class="col-1"> : </div>
                            <div class="col-lg-9 col-md-8 col-6">{{ $peserta->jumlah_peserta }} </div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <div class="col-lg-2 col-md-3 col-5">Alamat</div>
                            <div class="col-1"> : </div>
                            <div class="col-lg-9 col-md-8 col-6">{{ $peserta->alamat }} </div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <div class="col-lg-2 col-md-3 col-5">HP / WA</div>
                            <div class="col-1"> : </div>
                            <div class="col-lg-9 col-md-8 col-6">{{ $peserta->telpon }} </div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <!-- <div class="col-lg-2 col-md-3 col-5">Penanggung Jawab</div>
                            <div class="col-1"> : </div>
                            <div class="col-lg-9 col-md-8 col-6">{{ $peserta->penanggung_jawab }} </div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <div class="col-lg-2 col-md-3 col-5">Catatan</div>
                            <div class="col-1"> : </div>
                            <div class="col-lg-9 col-md-8 col-6">{{ $peserta->catatan }} </div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div> -->

                            <div class="col-lg-2 col-md-3 col-5">Punia</div>
                            <div class="col-1"> : </div>
                            <div class="col-lg-9 col-md-8 col-6">Rp. {!! number_format($peserta->punia - $peserta->kode_bayar, 0, ",","." ) !!} </div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>
<!-- 
                            <div class="col-2">Acara</div>
                            <div class="col-10">: {{ $peserta->acara->name}}</div>

                            <div class="col-2">Tanggal/Jadwal</div>
                            <div class="col-10">: {{ $peserta->tanggal }}@if($peserta->jadwal) / {{ $peserta->jadwal->dinan }} @endif </div>

                            <div class="col-2">Nama Peserta</div>
                            <div class="col-10">: {{ $peserta->nama }}</div> -->

                            <!-- <div class="col-2">Jumlah Peserta</div>
                            <div class="col-10">: {{ $peserta->jumlah_peserta }}</div>

                            <div class="col-2">Alamat</div>
                            <div class="col-10">: {{ $peserta->alamat }}</div>

                            <div class="col-2">HP / WA</div>
                            <div class="col-10">: {{ $peserta->telpon }}</div>

                            <div class="col-2">Penanggung Jawab</div>
                            <div class="col-10">: {{ $peserta->penanggung_jawab }}</div>

                            <div class="col-2">Catatan</div>
                            <div class="col-10">: {{ $peserta->catatan }}</div>

                            <div class="col-2">Punia</div>
                            {{-- <div class="col-lg-10">: Rp. {!! number_format($peserta->punia - $peserta->kode_bayar, 0, ",","." ) !!} + <span class="bg-warning">{{ $peserta->kode_bayar }}</span></div> --}}
                            <div class="col-10">: Rp. {!! number_format($peserta->punia - $peserta->kode_bayar, 0, ",","." ) !!}</div> -->

                            <div class="col-12 pt-4">
                                Silahkan melakukan transfer ke rekening di bawah ini untuk mendapat nomor urut:
                            </div>
                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <div class="col-lg-2 col-md-3 col-5">Nama Bank</div>
                            <div class="col-1">:</div>
                            <div class="col-lg-9 col-md-8 col-6">{{ @$pengaturan['nama_bank'] }}</div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <div class="col-lg-2 col-md-3 col-5">Nomor Rekening</div>
                            <div class="col-1">:</div>
                            <div class="col-lg-9 col-md-8 col-6">{{ @$pengaturan['norek_bank'] }}</div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <div class="col-lg-2 col-md-3 col-5">Atas Nama</div>
                            <div class="col-1">:</div>
                            <div class="col-lg-9 col-md-8 col-6">{{ @$pengaturan['pemilik_bank'] }}</div>

                            <div class="col-12" style="margin:10px 0; border-top:1px solid #EEEEEE;"></div>

                            <div class="col-lg-2 col-md-3 col-5">Nominal Bayar</div>
                            <div class="col-1">:</div>
                            <div class="col-lg-9 col-md-8 col-6">Rp. <h4 style="display:inline-block" ><span class="bg-warning">{{ number_format($peserta->punia, 0, ",",".") }}</span></h4></div>
                            
                            <!-- <div class="col-2">Nomor Rekening</div>
                            <div class="col-10">: {{ @$pengaturan['norek_bank'] }}</div> -->

                            <!-- <div class="col-2">Atas Nama</div>
                            <div class="col-10">: {{ @$pengaturan['pemilik_bank'] }}</div>

                            <div class="col-2">Nominal Bayar</div>
                            <div class="col-10">: Rp. <h4 style="display:inline-block" ><span class="bg-warning">{{ number_format($peserta->punia, 0, ",",".") }}</span></h4></div> -->
                        </div>

                    </div>

                    <div class="card-footer">
                        <a href="{{ route('konfirmasi.pembayaran') }}?jumlah_tagihan={{ $peserta->punia }}" class="btn btn-primary">Konfirmasi Pembayaran</a>
                    </div>

                </div>
            </div>
        </div>



    </section>


</div>
@endsection


@section('scripts')

<script>
    $(document).ready(function(){

        $.ajax({
            type:"POST",
            url:"<?php echo url('cekPembayaran') ; ?>",
            data:"_token=<?php echo csrf_token() ?>&kode=<?php echo $peserta->kode_bayar; ?>&id=<?php echo $peserta->id; ?>",
            dataType:"json",
            success:function(data){
            }
        })

    });
</script>

@endsection