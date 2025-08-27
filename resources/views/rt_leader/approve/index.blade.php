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
    <h4 class="mb-3">Daftar Warga yang Belum di Verifikasi</h4>
  
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>RT</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pendingUsers as $user)
        <tr>
          <td>{{ $user->first_name }} {{ $user->last_name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->usr_scope_id }}</td>
          <td>
            <form action="{{ route('rt.approve.user', $user->usr_id) }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-success btn-sm">Setujui</button>
            </form>
          </td>
        </tr>
        @empty
      <tr>
          <td colspan="5" class="text-center text-muted">Belum ada data verifikasi warga</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
