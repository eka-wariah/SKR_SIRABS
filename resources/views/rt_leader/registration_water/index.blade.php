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
<div class="datatables" style="padding: 25px">
    <div class="card">
        <div class="card-body">
    <h4 class="mb-3">Daftar Pengajuan Layanan Air Bersama</h4>
  
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Nama Warga</th>
          <th>Alamat</th>
          <th>Tanggal Daftar</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tbody>
            @forelse($pengajuan as $item)
                <tr>
                    <td>{{ $item->applicant->name }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->rgw_registration_date }}</td>
                    <td>
                        <span class="badge bg-info">{{ $item->rgw_status }}</span>
                    </td>
                    <td>
                        <a href="{{ route('rt_leader.registration_water.show', $item->rgw_id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data pengajuan layanan air.</td>
                </tr>
            @endforelse
      </tbody>
    </table>
  </div>
@endsection
