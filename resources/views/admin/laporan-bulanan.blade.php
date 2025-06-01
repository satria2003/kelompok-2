@extends('admin') 

@section('content')
<div class="container">
    <h2 class="my-4">Laporan Pendapatan per Bulan</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Bulan</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendapatanBulanan as $row)
            <tr>
                <td>{{ $row->tahun }}</td>
                <td>{{ \Carbon\Carbon::create()->month($row->bulan)->locale('id')->isoFormat('MMMM') }}</td>
                <td>Rp {{ number_format($row->total, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.laporan.bulanan.pdf') }}" class="btn btn-danger">
        📄 Download PDF
    </a>
</div>
@endsection
