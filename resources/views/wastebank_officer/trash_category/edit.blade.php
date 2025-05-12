@extends('wastebank_officer.master_officer')
@push('link')
    
@endpush

@section('title')
    SiTAW | Edit Kategori
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
                  <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Nama Kategori</label>
                  <div class="col-sm-9">
                    <input type="text" name="trc_name" value="{{$EditTrashCategory->trc_name}}" class="form-control" id="exampleInputText1"  required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                    onchange="this.setCustomValidity('')">
                  </div>
                  @error('trc_name')
                    <div>error</div>
                  @enderror
                </div>

                <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Nama Kategori</label>
                    <div class="col-sm-9">
                      <input type="text" name="trc_price" value="{{$EditTrashCategory->trc_price}}" class="form-control" id="exampleInputText1"  required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('trc_price')
                      <div>error</div>
                    @enderror
                  </div>
                
                <div class="row">
                  <div class="col-sm-3"></div>
                  <div class="col-sm-9">
                    <button input type="submit" class="btn btn-primary" value="Kirim" id="">Kirim</button>
                  </div>
                </div>
              </div>
          </form>
          
        </div>
      </div>
   </div>
    
@endsection



@push('script')
    
@endpush
