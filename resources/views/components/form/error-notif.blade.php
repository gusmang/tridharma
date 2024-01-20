@foreach($datas as $data)
@if(str_contains($data,$filename))
<small class="text-danger">{{ $data}}</small>
@endif
@endforeach
