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
  <h4 class="mb-3">Detail Pengajuan Layanan Air</h4>

  <div class="card">
    <div class="card-body">
      <p><strong>Nama:</strong> {{ $pengajuan->applicant->name }}</p>
      <p><strong>Alamat:</strong> {{ $pengajuan->address }}</p>
      <p><strong>Tanggal Daftar:</strong> {{ $pengajuan->rgw_registration_date }}</p>
      <p><strong>Catatan:</strong> {{ $pengajuan->rgw_notes }}</p>

      <p><strong>Status Saat Ini:</strong> 
        <span class="badge bg-warning">{{ $pengajuan->rgw_status }}</span>
      </p>

      {{-- Foto --}}
      @if($pengajuan->rgw_house_photo)
        <p><strong>Foto Rumah:</strong></p>
        <img src="{{ asset('storage/' . $pengajuan->rgw_house_photo) }}" width="300" class="img-thumbnail mb-3">
      @endif

      {{-- Form Update --}}
      <form action="{{ route('rt_leader.registration_water.update', $pengajuan->rgw_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label for="rgw_status" class="form-label">Ubah Status</label>
          <select name="rgw_status" id="rgw_status" class="form-select" required>
            <option value="Menunggu Verifikasi" {{ $pengajuan->rgw_status == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
            <option value="Sedang Proses Pemasangan" {{ $pengajuan->rgw_status == 'Sedang Proses Pemasangan' ? 'selected' : '' }}>Sedang Proses Pemasangan</option>
            <option value="Aktif" {{ $pengajuan->rgw_status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Ditolak" {{ $pengajuan->rgw_status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
          </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
      </form>

      <hr>

      {{-- Kontak --}}
      <p class="mt-3">Hubungi Warga:</p>
      @php
        $phone = $pengajuan->applicant->phone;
        $email = $pengajuan->applicant->email;
      @endphp

      @if($phone)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phone) }}" target="_blank" class="btn btn-success btn-sm me-2">
          <i class="bi bi-whatsapp"></i> WhatsApp
        </a>
      @endif

      <a href="mailto:{{ $email }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-envelope"></i> Email
      </a>
    </div>
  </div>
</div>
@endsection
