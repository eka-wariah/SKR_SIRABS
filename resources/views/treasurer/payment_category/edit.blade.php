@extends('treasurer.master_treasurer')
@push('link')
<link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SiTAW | Edit Kategori
@endsection

@section('content')
   <div class="row" style="padding: 25px">
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
                    <input type="text" name="pym_name" value="{{$EditPaymentCategory->pym_name}}" class="form-control" id="exampleInputText1"  required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                    onchange="this.setCustomValidity('')">
                  </div>
                  @error('pym_name')
                    <div>error</div>
                  @enderror
                </div>

                <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Nama Kategori</label>
                    <div class="col-sm-9">
                        <input type="text" name="pym_total" class="form-control format-rupiah" value="{{ old('pym_total', 'Rp ' . number_format($EditPaymentCategory->pym_total ?? 0, 0, '', '.')) }}"
                        required oninvalid="this.setCustomValidity('Harga wajib diisi')" onchange="this.setCustomValidity('')">
                    </div>
                    @error('pym_total')
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
