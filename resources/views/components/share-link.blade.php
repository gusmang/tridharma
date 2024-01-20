<div class="inline-block">
    <a href="{{ $url }}" class="btn btn-success copyUrl"> <i class="fa fa-globe"></i> </a>
    <a href="https://www.facebook.com/share.php?u={{ $url }}" class="btn btn-primary" target="_BLANK"> <i class="fa fa-facebook"></i> </a>
    <a href="https://twitter.com/intent/tweet?url={{ $url }}" class="btn btn-info" target="_BLANK"> <i class="fa fa-twitter"></i> </a>
    <a href="mailto:?subject=&amp;body=Check Link Berikut {{ $url }}" class="btn btn-secondary" target="_BLANK"> <i class="fa fa-envelope"></i> </a>
    <a href="whatsapp://send?text={{ $url }}" class="btn btn-success" target="_BLANK"> <i class="fa fa-whatsapp"></i> </a>
</div>
@section('scripts')
    <script>
        jQuery('.copyUrl').on('click',function(e){
            e.preventDefault();
            var copyText = jQuery(this).attr('href');
            navigator.clipboard.writeText(copyText);
            toastr['info']('Copy url berhasil, silahakan paste urlnya');
        })
    </script>
@endsection
