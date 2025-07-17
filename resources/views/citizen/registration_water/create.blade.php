@extends('citizen.master_citizen')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Pendaftaran Layanan Air SIBEL</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($existing)
        <div class="alert alert-info">
            KK Anda sudah mendaftar pada <strong>{{ $existing->registration_date }}</strong> dengan status <strong>{{ $existing->status }}</strong>.
        </div>
    @else
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama Pengaju --}}
            <div class="mb-3">
                <label class="form-label">Nama Pengaju</label>
                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
            </div>

          {{-- ALAMAT --}}
<div class="mb-3">
    <label class="form-label">Alamat</label>
  
    @if($defaultAddress)
    <textarea name="address" id="address" class="form-control" rows="2" required>{{ old('address', $defaultAddress) }}</textarea>
    <input type="hidden" name="address_option" value="user">
    <small class="text-muted">Alamat diambil dari profil, tapi bisa kamu ubah jika perlu.</small>
    @else
      {{-- Manual input jika user tidak punya alamat --}}
      <textarea name="address" id="address" class="form-control" rows="2" required>{{ old('address') }}</textarea>
      <input type="hidden" name="address_option" value="manual">
      <small class="text-muted">Isi alamat rumah secara lengkap.</small>
    @endif
  </div>

            {{-- Catatan --}}
            <div class="mb-3">
                <label for="rgw_notes" class="form-label">Catatan Tambahan</label>
                <textarea name="rgw_notes" id="rgw_notes" class="form-control" rows="3">{{ old('rgw_notes') }}</textarea>
            </div>

            {{-- Foto Rumah --}}
            <div class="mb-3">
                <label for="rgw_house_photo" class="form-label">Foto Rumah (untuk pemasangan)</label>
                <input type="file" name="rgw_house_photo" id="rgw_house_photo" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Kirim Permohonan</button>
        </form>
    @endif
</div>
@endsection

@push('script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const radioUser = document.getElementById('use_user_address');
    const radioManual = document.getElementById('manual_address');
    const textarea = document.getElementById('address');
    const defaultAddress = @json($defaultAddress);

    if (radioUser && radioManual) {
      radioUser.addEventListener('change', () => {
        textarea.value = defaultAddress;
        textarea.readOnly = false;
      });

      radioManual.addEventListener('change', () => {
        textarea.value = '';
        textarea.readOnly = false;
      });
    }
  });
</script>
@endpush
