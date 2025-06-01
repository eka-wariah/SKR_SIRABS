
@extends('citizen.master_citizen')

@push('link')
    
@endpush

@section('title')
    SiTAW | Tambah Kategori
@endsection

@section('content')
<div class="container">
    <h4>Edit Profil</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
        
            <form action="{{ route('profile.update_photo') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
             <div class="card mb-6">
          <!-- Account -->
          <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-6">
                {{-- Foto Profil --}}
                <img
        src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('vuexy/assets/img/avatars/16.jpg') }}"
        alt="user-avatar"
        class="d-block w-px-100 h-px-100 rounded"
        id="uploadedAvatar" />
            
        <div class="button-wrapper">
          <label for="profile_photo" class="btn btn-primary me-3 mb-4" tabindex="0">
            <span class="d-none d-sm-block">Upload new photo</span>
            <i class="icon-base ti tabler-upload d-block d-sm-none"></i>
            <input type="file" id="profile_photo" name="profile_photo" class="account-file-input" hidden accept="image/png, image/jpeg" />
          </label>
          
          <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
        </div>
        
      </div>
    </div>

<div class="card-body pt-4">
<div class="row gy-4 gx-6 mb-6">
  {{-- Nama --}}
  <div class="col-md-6">
    <label for="name" class="form-label">Nama</label>
    <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" autofocus />
  </div>

  <div class="col-md-6">
    <label for="email" class="form-label">E-mail</label>
    <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" />
  </div>

  <div class="col-md-6">
    <label class="form-label" for="gender">Jenis Kelamin</label>
    <select name="gender" class="select2 form-select">
      <option value="">Select</option>
      <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
      <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
    </select>
  </div>

   {{-- Phone --}}
   <div class="col-md-6">
    <label class="form-label" for="phone">Phone Number</label>
    <div class="input-group input-group-merge">
      <span class="input-group-text">ID (+62)</span>
    <input type="text" id="phone" name="phone" class="form-control"  placeholder="81234567890"  value="{{ old('phone', $user->phone) }}" />
  </div>
</div>
</div>
 {{-- Alamat --}}
 <div class="row">
  <div class="col-md-4">
    <label for="address" class="form-label">Alamat Lengkap</label>
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="address" name="address" placeholder="Jl. Mawar No. 10, Kp. Sukamaju" value="{{ old('address', $user->address) }}">
      <label for="address">Jalan, Nama Kampung, No. Rumah</label>
    </div>
  </div>

  {{-- RT --}}
  <div class="col-md-2">
    <label for="usr_scope_id" class="form-label">RT</label>
    <div class="form-label">
      <select name="usr_scope_id" class="form-select">
        @foreach ($areaScopes as $area)
          <option value="{{ $area->asc_id }}" {{ old('usr_scope_id', $user->usr_scope_id) == $area->asc_id ? 'selected' : '' }}>
            {{ $area->asc_level }} {{ $area->asc_number }}
          </option>
        @endforeach
      </select>
      {{-- <label for="usr_scope_id">RT</label> --}}
    </div>
  </div>

  {{-- RW (tetap) --}}
  <div class="col-md-2">
    <label class="form-label">RW</label>
    <input type="text" class="form-control" value="RW 04" disabled>
  </div>

  {{-- Desa --}}
  <div class="col-md-4">
    <label for="desa" class="form-label">Desa</label>
    <div class="form-label">
      <input type="text" class="form-control" id="village" name="village" placeholder="Desa Mekarsari" value="{{ old('village', $user->village) }}">
      
    </div>
  </div>

  {{-- Kecamatan --}}
  <div class="col-md-4">
    <label for="kecamatan" class="form-label">Kecamatan</label>
    <div class="form-label">
      <input type="text" class="form-control" id="subdistrict" name="subdistrict" placeholder="Kec. Cibinong" value="{{ old('subdistrict', $user->subdistrict) }}">
  
    </div>
  </div>

  {{-- Kabupaten --}}
  <div class="col-md-4">
    <label for="kabupaten" class="form-label">Kabupaten</label>
    <div class="form-label">
      <input type="text" class="form-control" id="regency" name="regency" placeholder="Kab. Bandung" value="{{ old('regency', $user->regency) }}">
    
    </div>
  </div>
</div>
<div class="mt-2">
  <button type="submit" class="btn btn-primary me-3">Simpan</button>
  <button type="reset" class="btn btn-label-secondary">Batal</button>
</div>
</div>
</form>       
</div>
@endsection

@push('script')

<script>
  document.getElementById('profile_photo').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
      const imgPreview = document.getElementById('uploadedAvatar');
      imgPreview.src = URL.createObjectURL(file);
    }
  });
  </script>

    
@endpush