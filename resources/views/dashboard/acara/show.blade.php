@extends('layouts.app')

@section('links')
@stop

@section('body')
    <div class="peserta">
        <div class="row">
            <div class="col">
                <h1>Detail Acara</h1>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                Detail Acara
            </div>
            <div class="card-body">
                <table class="table mb-0">
                    <tr>
                        <td style="width: 200px">Nama Acara</td>
                        <td style="width: 10px;">:</td>
                        <td>{{ $acara->name }}</td>
                    </tr>
                    <tr>
                        <td>Penjelasan</td>
                        <td>:</td>
                        <td>{!! $acara->penjelasan !!}</td>
                    </tr>
                    <tr>
                        <td>Yang Didapat</td>
                        <td>:</td>
                        <td>{!! $acara->yang_di_dapat !!}</td>
                    </tr>
                    <tr>
                        <td>Yang Dibawa</td>
                        <td>:</td>
                        <td>{!! $acara->yang_di_bawa !!}</td>
                    </tr>
                    <tr>
                        <td>Susunan Acara</td>
                        <td>:</td>
                        <td>{!! $acara->susunan_acara !!}</td>
                    </tr>
                    <tr>
                        <td>Sistem Jadwal</td>
                        <td>:</td>
                        <td>{!! $acara->sistem_jadwal !!}</td>
                    </tr>
                    <tr>
                        <td>Punia</td>
                        <td>:</td>
                        <td>{!! $acara->punia !!}</td>
                    </tr>
                </table>

            </div>
        </div>

        <div class="card">
            <div class="card-body form-inline">
                <a href="{{ route('acara.edit', $acara->id) }}" class="btn btn-warning mr-2">Edit</a>

                <form action="{{ route('acara.destroy',$acara->id) }}" method="post" class="mr-2 form-inline">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger">Hapus Acara</button>
                </form>

                @if($acara->sistem_jadwal == 'Terjadwal')
                    <a href="{{ route('jadwal-acara.create') }}?acara_id={{ $acara->id }}" class="btn btn-primary">Tambah Acara</a>
                @endif

                <a href="{{ route('list-order.index') }}?acara_id={{ $acara->id }}" class="btn btn-info ml-2">Daftar Order</a>

            </div>
        </div>
        @if($acara->sistem_jadwal == 'Terjadwal')

            <div class="card">
                <div class="card-header">
                    Daftar Jadwal
                </div>
                <div class="card-body1">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Dinan</th>
                                <th>Jumlah Peserta</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($acara->jadwals as $jadwal)
                                <tr class="@if($jadwal->is_closed) text-danger  @endif" >
                                    <td>{{ date("d-m-Y",strtotime($jadwal->tanggal)) }}</td>
                                    <td>{{ $jadwal->dinan }}</td>
                                    <td>{{ $jadwal->jumlah_peserta }}</td>
                                    <td >
                                        <div class="form-inline">
                                        <a href="{{ route('jadwal-acara.edit',$jadwal->id) }}" class="btn btn-warning btn-sm">edit</a>
                                        <form action="{{ route('jadwal-acara.destroy',$jadwal->id) }}" method="post">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger btn-sm ml-3"><i class="fa fa-trash"></i> </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>

        @endif
    </div>




@endsection

@section('scripts')
    <script>

        var table = null;

        $(function() {

        });


    </script>
@endsection
