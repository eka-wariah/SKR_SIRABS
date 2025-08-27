@extends('treasurer.master_treasurer')

@push('link')
    
@endpush

@section('title')
    SiTAW | Tambah Kategori
@endsection

@section('content')
   <div class="row"style="padding: 20px">
    <div class="col-lg-12">
        <div class="card">
          <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Tambah Kategori</h4>
          </div>
          <form action="" method="post">
            @csrf
            <div class="card-body">
                <div class="mb-4 row align-items-center">
                  <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Nama Kategori Pembayaran</label>
                  <div class="col-sm-9">
                    <input type="text" name="pym_name" class="form-control" id="exampleInputText1" placeholder="" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" onchange="this.setCustomValidity('')">
                  </div>
                  @error('pym_name')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Harga /bln</label>
                    <div class="col-sm-9">
                      <input type="text" name="pym_total" class="form-control format-rupiah" value="{{ old('pym_total', 'Rp ' . number_format($CreatePaymentCategory->pym_total ?? 0, 0, '', '.')) }}"placeholder="" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" onchange="this.setCustomValidity('')">
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('pym_total')
                    <div class="text-danger">{{ $message }}</div>
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
@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const inputs = document.querySelectorAll('.format-rupiah');

        inputs.forEach(function(input) {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^,\d]/g, '');
                value = value.replace(/^0+/, '');
                let split = value.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                e.target.value = 'Rp ' + rupiah;
            });
        });
    });
</script>
@endpush

    
@endpush
