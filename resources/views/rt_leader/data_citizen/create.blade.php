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
    <h4 class="mb-3">Tambah Data Warga</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('rt_leader.citizen.create') }}">
        @csrf

        <div class="col-sm-6 mb-3">
            <label class="form-label">Nama Depan</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" required />
          </div>
          <div class="col-sm-6 mb-3">
            <label class="form-label">Nama Belakang</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" />
          </div>
        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" name="nik" class="form-control" inputmode="numeric" pattern="[0-9]*" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)" required>
        </div>

        <div class="mb-3">
            <label for="kk" class="form-label">No KK</label>
            <input type="text" name="kk" class="form-control" inputmode="numeric" pattern="[0-9]*" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)" required>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Jenis Kelamin</label>
            <select name="gender" class="form-select" required>
                <option value="">Pilih</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
