@extends('wastebank_officer.master_officer')
@push('link')
    
@endpush
@section('content')
<div class="container">
    <h3>Setor Sampah</h3>

    <form action="" method="post">
        @csrf

        <div class="mb-3">
            <label class="form-label col-sm-3 col-form-label" for="usr_id">Pilih Warga</label>
            <select name="usr_id" class="form-control">
              @foreach ($users as $user)
                  <option value="{{ $user->usr_id }}" 
                      {{ $user->usr_id == $EditWasteBank->wtb_name_id ? 'selected' : '' }}>
                      {{ $user->name }}
                  </option>
              @endforeach
          </select>
        </div>

        <div class="mb-3">
            <label class="form-label col-sm-3 col-form-label" for="usr_id">Hasil Timbangan</label>
            <div id="kategori-container">
              @foreach ($EditWasteBank->details as $i => $detail)
                  <div class="kategori-item row mb-2">
                      <div class="col-md-5">
                          <select name="categories[{{ $i }}][trc_id]" class="form-control">
                              @foreach ($trash_category as $category)
                                  <option value="{{ $category->trc_id }}" {{ $detail->trc_id == $category->trc_id ? 'selected' : '' }}>
                                      {{ $category->trc_name }}
                                  </option>
                              @endforeach
                          </select>
                      </div>
                      <div class="col-md-5">
                          <input type="number" step="0.1" name="categories[{{ $i }}][berat]" class="form-control" value="{{ $detail->berat }}">
                      </div>
                      <div class="col-md-2">
                          <button type="button" class="btn btn-danger remove-kategori">-</button>
                      </div>
                  </div>
              @endforeach
          </div>
        <div class="row">
          
            <div class="col-sm-9">
                <button type="button" class="btn btn-secondary mt-3" id="tambah-kategori">+ Tambah Kategori</button>
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </div>
          </div>

      
    </form>
</div>

@push('script')
    
@endpush

@endsection


