@extends('layouts.app')

@section('body')
    <div class="pembayaran">
        <div class="row">
            <div class="col">
                <h1>{{ __('Pembayaran') }}</h1>
            </div>
            <div class="col text-right">
                {{-- <a href="{{ route('pembayaran.create') }}" class="btn btn-info">{{ __('Pembayaran baru') }}</a> --}}
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <form action="{{ route('pembayaran.index') }}" method="get">
                    <input type="hidden" name="page" value="{{ Request::input('page') }}">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                            <select class="form-control" name="acara">
                                <option value="">--Pilih Type--</option>
                                <option value="">Perbulan</option>
                                <option value="">Perhari</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-2  xs-6">
                            <div class="form-group">
                                <input type="date" name="tanggal" class="form-control" value="{{ app('request')->input('tanggal') }}">
                            </div>
                        </div>
                        <div class="col-lg-2  xs-6">
                            <div class="form-group">
                            <input type="date" name="tanggal" class="form-control" value="{{ app('request')->input('tanggal') }}">
                            </div>
                        </div>
                        <div class="col text-right">
                            <button type="submit" class="btn btn-info">Filter</button>
                            <a href="{{ route('pembayaran.index') }}" class="btn btn-success">Reset Filter</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive">
               <table class="table">
                   <thead>
                       <th>Nama</th>
                       <th>Acara</th>
                       <th>tanggal bayar</th>
                       <th>Punia</th>
                       {{-- <th></th> --}}
                   </thead>
                   <tbody>
                    @php $jumlah_pembayaran = 0; @endphp
                       @foreach($pembayarans  as $pembayaran)
                       @php $jumlah_pembayaran +=$pembayaran->nominal; @endphp
                       <tr>
                           <td>{{ $pembayaran->peserta->nama }}</td>
                           <td>{{ $pembayaran->peserta->acara->name }} </td>
                           <td>{{ date("d-m-Y",strtotime($pembayaran->tanggal_bayar)) }}</td>
                           <td>{{ number_format($pembayaran->nominal) }}</td>
                           {{-- <td>
                               <x-form.edit-button url="{{ route('pembayaran.edit',$pembayaran->id) }}"/>
                           </td> --}}
                       </tr>
                       @endforeach
                   </tbody>
               </table>
            </div>
            <div class="card-footer text-muted">
                <div class="row">
                    <div class="col">
                        @if($pembayarans)
                        <div class="pagination mb-3">
                            {{$pembayarans->onEachSide(5)->links()}}
                        </div>
                        @endif
                    </div>
                    <div class="col text-right">
                        TOTAL : {{ count($pembayarans) }}
                        <Span class="ml-3">Jumlah pembayaran : {{ number_format($jumlah_pembayaran) }}</Span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        let url = window.location.href;
        let new_url = url.split('&acara')
        let a = jQuery('.pagination a').attr('href');
        if(new_url.length>1)
            jQuery('.pagination a').attr('href',a+'&acara'+new_url[1]);
    </script>
@endsection
