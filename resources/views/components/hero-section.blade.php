<section class="header">
    <div class="row">

        <div class="col-lg-3 col-4">
            <a href="/"><img src="{{ route('cdn.image', ['image'=> $pengaturan['feature_image']]) }}" alt="" class="img-fluid"></a>
        </div>

        <div class="col-4 xs-show"></div>
        <div class="col-4 xs-show">
            <img src="{{ route('cdn.image',['image'=>$pengaturan['logo']]) }}" alt="" class="img-fluid">
        </div>
        <div class="col-lg-6 text-center">
            <div class="content">
                <h1 > {!! $pengaturan? ( isset($pengaturan['nama_aplikasi'])?$pengaturan['nama_aplikasi']:'' ) : 'nama_aplikasi'  !!}</h1>
                {!! $pengaturan? ( isset($pengaturan['content'])?$pengaturan['content']:'' ) : 'Content'  !!}
                <div style="font-size:13px; border-top:1px solid #DDDDDD; margin-top:10px; padding-top:10px;"> {!! $pengaturan? ( isset($pengaturan['alamat'])?$pengaturan['alamat']:'' ) : 'nama_aplikasi'  !!} </div>
                <div style="font-size:13px; border-top:1px solid #DDDDDD; margin-top:10px; padding-top:10px;"></div>
            </div>
        </div>
        <div class="col-lg-3 xs-hide">
            <img src="{{ route('cdn.image',['image'=>$pengaturan['logo']]) }}" alt="" class="img-fluid">
        </div>
    </div>
</section>
