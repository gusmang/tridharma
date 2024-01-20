@if($acara->sistem_jadwal == 'Terjadwal')

@foreach($acara->jadwals as $key=>$jadwal)
@if($max && $key>($max-1))
@php continue;  @endphp
@endif
<tr>
    <td>{{  date("d M Y",strtotime($jadwal->tanggal)) }}</td>
    <td>{{ $jadwal->dinan }}</td>
    <td>
        @if($jadwal->is_closed)
        <button class="btn btn-danger btn-sm"> Penuh</button>
        @else
        <a href="{{ route('daftar.index',['acara_id'=>$acara->id,'jadwal_id'=>$jadwal->id]) }}" class="btn btn-info btn-sm"> Daftar</a>
        @endif
    </td>
</tr>
@endforeach
@else
<tr>
    <td class="pt-3">Berjalan Setiap Hari.</td>
    <td class="pt-3">
        <a href="{{ route('daftar.index',['acara_id'=>$acara->id]) }}" class="btn btn-info"> Daftar</a>
    </td>
</tr>
@endif
