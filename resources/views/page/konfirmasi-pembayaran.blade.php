@extends('layouts.front')

@section('body')
<div class="container">
    <x-hero-section :pengaturan="$pengaturan"/>
    
    <div class="row pb-10 text-center mb-10">
        <a href="<?php echo url('/'); ?>" target="_self" class="btn btn-primary">Halaman Utama</a>
    </div>
    
    @if(Request::query('jumlah_tagihan') != null)
        @if($peserta == null)
            <div class="alert alert-warning  mt-5 pt-3 pb-2">
                Tagihan tidak ditemukan berdasarkan nominal yang anda masukan
            </div>
        @endif

        @if($peserta != null )

            <form action="{{ route('konfirmasi.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="peserta_id" value="{{ $peserta->id }}" />
                @csrf
                <div class="row  mt-5 pt-3 pb-2">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                Tagihan Ditemukan
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $peserta->nama }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tanggal</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $peserta->tanggal }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Telepon</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $peserta->telpon }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Acara</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $peserta->acara->name }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Punia</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $peserta->punia }}" class="form-control" readonly />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Sudah Bayar</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $peserta->sudah_bayar == 1 ? "Sudah" : "Belum" }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nomor Urut</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $peserta->nomor_urut }}" class="form-control" readonly />
                                    </div>
                                </div>

                                <br/>
                                <strong>Tujuan Pembayaran</strong>

                                <p>Anda belum melakukan pembayaran? Silahkan transfer ke rekening berikut kemudian upload bukti pembayaran anda.</p>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama Bank</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ @$pengaturan['nama_bank'] }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nomor Rekening</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ @$pengaturan['norek_bank'] }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Atas Nama</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ @$pengaturan['pemilik_bank'] }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nominal</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $peserta->punia }}" class="form-control" readonly />
                                    </div>
                                </div>

                                <br/>

                                <strong>Pembayaran</strong>

                                @if ($errors->any())
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-8">
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tanggal Bayar</label>
                                    <div class="col-sm-8">
                                        <input type="date" id="tanggal_bayar" class="form-control" required name="tanggal_bayar" <?php echo $jmlBayar > 0 ? "disabled" : "" ?> />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nominal</label>
                                    <div class="col-sm-8">
                                        <input type="number" id="nominal_upload_bayar" class="form-control" value="{{ $peserta->punia }}" required name="nominal" <?php echo $jmlBayar > 0 ? "disabled" : "" ?> />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Bukti Bayar</label>
                                    <div class="col-sm-8">
                                        <input type="file" id="file_upload_bayar" class="form-control" accept="image/*" required name="bukti_bayar" <?php echo $jmlBayar > 0 ? "disabled" : "" ?> />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-primary" id="unggah_bukti_bayar" <?php echo $jmlBayar > 0 ? "disabled" : "" ?>>Unggah Bukti Bayar</button>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif

    @endif
    

    <form id="form-cari" method="GET" style="margin-top:30px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Konfirmasi Pembayaran
                    </div>
                    <div class="card-body">

                        <div class="alert alert-info">
                            Masukan jumlah tagihan anda kemudian tekan tombol cari untuk melihat daftar tagihan. Silahkan lakukan pembayaran sesuai rekening yang tertera, kemudian unggah bukti bayar tersebut pada formulir berikut ini.
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jumlah Tagihan</label>
                            <div class="col-sm-8">
                                <input type="number" value="{{ Request::query('jumlah_tagihan') }}" class="form-control" required name="jumlah_tagihan" id="jumlah_tagihan" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-8">
                                <button type="button" class="btn btn-success" onclick="cek_tagihan()">Cari Tagihan</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection

@section('scripts')
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.26/dist/sweetalert2.all.min.js
"></script>

<script>
    @if(Session::get('notif-success'))
            Swal.fire({
                icon: 'success',
                title: 'Pemberitahuan',
                text: 'Konfirmasi Pembayaran Sukses .. Silakan Menunggu Proses Validasi dari Admin',
                footer: '<small>Mohon tidak melakukan registrasi ulang lagi dengan kegiatan yang sama sampai ada pemberitahuan dari admin .. Terima kasih </small>'
            })
    @endif
    // $(document).ready(function(){

    // });
    function cek_tagihan(){
        $.ajax({
            type:"POST",
            url:"<?php echo url('cekPembayaran') ; ?>",
            data:"_token=<?php echo csrf_token() ?>&kode="+$("#jumlah_tagihan").val(),
            dataType:"json",
            success:function(data){
                if(data.jml == "0"){
                    $("#form-cari").submit();
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Pemberitahuan',
                        text: data.message,
                        footer: '<small>Mohon tidak melakukan registrasi ulang lagi dengan kegiatan yang sama sampai ada pemberitahuan dari admin .. Terima kasih </small>'
                    })
                }
            }
        })
    }
</script>

@endsection