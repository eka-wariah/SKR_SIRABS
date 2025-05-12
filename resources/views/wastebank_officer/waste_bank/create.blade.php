@extends('wastebank_officer.master_officer')
@push('link')
    
@endpush
@section('content')
<div class="container">
    <h3>Setor Sampah</h3>

    <form method="POST" action="{{ route('waste_bank.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label col-sm-3 col-form-label" for="usr_id">Pilih Warga</label>
            <select name="usr_id" class="form-control">
                @foreach ($users as $user)
                    <option value="{{ $user->usr_id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label col-sm-3 col-form-label" for="usr_id">Hasil Timbangan</label>
        <div id="kategori-container">
            <div class="kategori-item row mb-2">
                <div class="col-md-5">
                    <select name="categories[0][trc_id]" class="form-control">
                        @foreach ($trash_category as $trash_category)
                            <option value="{{ $trash_category->trc_id }}">{{ $trash_category->trc_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="number" step="0.1" name="categories[0][berat]" class="form-control" placeholder="Berat (kg)">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-kategori">-</button>
                </div>
                
            </div>
           
        </div>
        </div>
        <div class="row">
          
            <div class="col-sm-9">
                <button type="button" class="btn btn-secondary mt-3" id="tambah-kategori">+ Tambah Kategori</button>
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </div>
          </div>

      
    </form>
</div>

{{-- <script>
    let i = 1;
    document.getElementById('tambah-kategori').addEventListener('click', function () {
        const container = document.getElementById('kategori-container');
        const clone = container.firstElementChild.cloneNode(true);
        clone.querySelectorAll('select, input').forEach(el => {
            const name = el.getAttribute('name');
            el.setAttribute('name', name.replace(/\[\d+\]/, `[${i}]`));
            el.value = '';
        });
        container.appendChild(clone);
        i++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-kategori')) {
            const item = e.target.closest('.kategori-item');
            if (document.querySelectorAll('.kategori-item').length > 1) {
                item.remove();
            }
        }
    });
</script> --}}
@push('script')
    
@endpush
@endsection


{{-- @extends('wastebank_officer.master_petugas')

@push('link')
    
@endpush

@section('title')
    SiTAW | Tambah Kategori
@endsection

@section('content')
   <div class="row">
    <div class="col-lg-12">
        <div class="card">
          <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Tambah Kategori</h4>
          </div>
          <form action="" method="post">
            @csrf
            <div class="card-body">
                <div class="mb-4 row align-items-center">
                  <label for="Select" class="form-label col-sm-3 col-form-label">Nama Warga</label>
                  <div class="col-sm-9">
                  <select id="Select" name="usr_id" class="form-control" required>
                  <option hidden  value="">Pilih Nama Warga</option>
                  @foreach ($users as  $users)
                    <option value="{{ $users->usr_id }}">{{ $users->name }}</option>
                  @endforeach
                  </select>
                  @error('bsh_nama_id')
                      <div id="bsh_id" class="form-text">{{ $message }}</div>
                  @enderror
                  </div>
              </div>
                <div class="mb-4 row align-items-center">
                    <label for="Select" class="form-label col-sm-3 col-form-label">Kategori Sampah</label>
                    <div class="col-sm-9">
                    <select id="Select" name="trc_id" class="form-control" required>
                    <option hidden  value="">Pilih Kategori Sampah</option>
                    @foreach ($trash_category as  $trash_category)
                      <option value="{{ $trash_category->trc_id }}">{{ $trash_category->trc_name }}</option>
                    @endforeach
                    </select>
                    @error('wtb_category_trash_id')
                        <div id="wtb_id" class="form-text">{{ $message }}</div>
                    @enderror
                    </div>
                </div>
                <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">total sampah/kg</label>
                    <div class="col-sm-9">
                      <input type="number" name="wtb_total_wate" class="form-control" id="exampleInputText1" placeholder="" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('wtb_total_wate')
                      <div>error</div>
                    @enderror
                  </div>
                  
                
                <div class="row">
                  <div class="col-sm-3"></div>
                  <div class="col-sm-9">
                    <input type="submit" class="btn btn-primary" value="Kirim" id="">
                  </div>
                </div>
              </div>
          </form>
          
        </div>
      </div>
   </div>
    
@endsection



@push('script')
    
@endpush --}}
