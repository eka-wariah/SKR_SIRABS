@extends('rt_leader.master_rt-leader')

@push('link')
    <link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />
    <link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SITAW | Data Warga per RT
@endsection

@section('content')
<div class="container mt-4">
    <h4>Daftar Lengkap Warga di RT {{ Auth::user()->areaScope->nama_rt ?? '-' }}</h4>

    {{-- Tabel datar semua warga --}}
    <div class="card mb-4">
        <div class="card-body">
            <table id="dataTable" class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>No. KK</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($warga as $w)
                    <tr>
                        <td>{{ $w->nik }}</td>
                        <td>{{ $w->name }}</td>
                        <td>{{ $w->household->no_kk ?? '-' }}</td>
                        <td>{{ $w->address }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tampilan grouped per KK --}}
    <h4 class="mt-5">Data Warga Dikelompokkan per KK</h4>

    @foreach($warga->groupBy('household_id') as $household_id => $members)
        <div class="card mb-3">
            <div class="card-header bg-light">
                <strong>No. KK:</strong> {{ $members->first()->household->no_kk ?? '-' }}<br>
                <strong>Alamat:</strong> {{ $members->first()->household->alamat ?? $members->first()->address }}
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    @foreach($members as $member)
                        <li>
                            <strong>NIK:</strong> {{ $member->nik }} –
                            <strong>Nama:</strong> {{ $member->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('script')
<script src="{{ asset('modernize/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('modernize/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true
        });
    });
</script>
@endpush
