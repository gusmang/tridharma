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
                    <tr>
                        <th>Total Cash </th>
                        <th>Total Transfer</th>
                        <th>Total Diterima</th>
                        <th>Total Belum Diterima</th>
                    </tr>
                </thead>
                <tbody>
                    <td>Rp. 500.000,-</td>
                    <td>Rp. 1.000.000,-</td>
                    <td>Rp. 800.000,-</td>
                    <td>Rp. 900.000,-</td>
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
                    {{-- TOTAL : {{ count($pembayarans) }}
                    <Span class="ml-3">Jumlah pembayaran : {{ number_format($jumlah_pembayaran) }}</Span> --}}
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
    if (new_url.length > 1)
        jQuery('.pagination a').attr('href', a + '&acara' + new_url[1]);

</script>
@endsection
