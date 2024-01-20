<form action="{{$url}}" method="post" id="hapusAcara{{$id}}" style="display: inline-block;">
    @csrf
    {{ method_field('DELETE') }}
    <button type="button" dataId="hapusAcara{{$id}}" class="btn btn-danger ml-1 hapusAcara" data-toggle="tooltip"  title="Hapus Data">
        <i class="fa fa-trash"></i>
    </button>
</form>

@section('scripts')
 <script>
     $(function(){
         $('.hapusAcara').on('click',function(){
             if(confirm('Yakin mau menghapus data ini?')){
                $('#'+$(this).attr('dataId')).submit();
             }
         })
     })
 </script>
@endsection

