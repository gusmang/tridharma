<table>

    <tr>
        <td colspan="2">Nama Acara</td>
        <td>{{ $acara->name }}</td>
    </tr>
    <tr>
        <td colspan="2">Punia</td>
        <td>{{ $acara->punia }}</td>
    </tr>

    <tr>
        <td colspan="2">Periode Tanggal</td>
        <td>{{ $tanggal_mulai }} sampai {{ $tanggal_selesai }}</td>
    </tr>

    <tr>
        <td></td>
    </tr>

    <tr>
        <th><strong>No</strong></th>
        <th><strong>Nama Peserta</strong></th>
        <th><strong>Tanggal</strong></th>
        <th><strong>Jumlah Peserta</strong></th>
        <th><strong>Alamat</strong></th>
        <th><strong>Penanggung Jawab</strong></th>
        <th><strong>Telepon</strong></th>
        <th><strong>Punia</strong></th>
        <th><strong>Nomor Urut</strong></th>
    </tr>

    @foreach($peserta as $k => $v)
        <tr>
            <td>{{ ($k + 1) }}</td>
            <td>{{ $v->nama }}</td>
            <td>{{ $v->tanggal }}</td>
            <td>{{ $v->jumlah_peserta }}</td>
            <td>{{ $v->alamat }}</td>
            <td>{{ $v->penanggung_jawab }}</td>
            <td>{{ $v->telpon }}</td>
            <td>{{ $v->punia }}</td>
            <td>{{ $v->nomor_urut }}</td>
        </tr>
    @endforeach
</table>
