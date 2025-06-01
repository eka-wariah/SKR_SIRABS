@extends('citizen.master_citizen')

@push('link')
    
@endpush

@section('title')
    SiTAW | Tambah Kategori
@endsection

@section('content')
<div class="row" style="padding: 25px">
    <div class="col-lg-12">
        <div class="card">
          <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Tambah Kategori</h4>
          </div>

    <form action="/citizen/payment/create_via_Bank" method="POST">
        @csrf
        <div class="card-body">
        <input type="hidden" name="metode_bayar" value="digital">

        <div class="mb-4 row align-items-center">
            <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Nama</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
            </div>
          </div>

          <div class="mb-4 row align-items-center">
            <label for="kategori" class="form-label col-sm-3 col-form-label">Kategori Pembayaran</label>
            <div class="col-sm-9">
            <select name="payment_category_id" id="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($PaymentCategory as $kategori)
                    <option value="{{ $kategori->pym_id }}" data-total="{{ $kategori->pym_total }}">
                        {{ $kategori->pym_name }} - Rp {{ number_format($kategori->pym_total, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>
          </div>

        <div class="mb-4 row align-items-center">
            <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Jumlah Bayar</label>
            <div class="col-sm-9">
            <input type="hidden" name="jumlah_bayar" id="jumlah_bayar"> <!-- untuk dikirim ke backend -->
            <input type="text" id="jumlah_bayar_display" class="form-control" readonly> <!-- tampilkan ke user -->
            </div>
        </div>


        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
              <button type="submit" class="btn btn-primary" value="Kirim" id="">Kirim</button>
              
            </div>
          </div>
    </form>
</div>
    </div>
</div>
    
@endsection



@push('script')
<script>
    function formatRupiah(angka) {
        return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
    }

    document.getElementById('kategori').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const total = selectedOption.getAttribute('data-total');

        // Set nilai asli (untuk form)
        document.getElementById('jumlah_bayar').value = total;

        // Tampilkan dalam format rupiah
        document.getElementById('jumlah_bayar_display').value = formatRupiah(total);
    });
</script> 
@endpush
