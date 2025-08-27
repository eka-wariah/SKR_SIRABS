@extends('wastebank_officer.master_officer')

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
    <h4>Tambah Pemasukan Kas</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cash.store') }}" method="POST">
        @csrf

        <input type="hidden" name="type" value="Masuk">

        <div class="mb-4 row align-items-center">
            <label for="amount_display" class="col-sm-3 col-form-label">Jumlah Uang (Rp)</label>
            <div class="col-sm-9">
              
                <input type="text" 
                       id="amount_display" 
                       class="form-control" 
                       placeholder="Contoh: 50.000" 
                       required>

                <input type="hidden" 
                       name="amount" 
                       id="amount">
            </div>
        </div>
        
        <div class="mb-4 row align-items-start">
            <label for="description" class="col-sm-3 col-form-label">Keterangan</label>
            <div class="col-sm-9">
                <textarea name="description" 
                          id="description" 
                          class="form-control" 
                          rows="3" 
                          placeholder="Contoh: Penjualan sampah, Donasi, dll" 
                          required 
                          oninvalid="this.setCustomValidity('Keterangan wajib diisi')" 
                          oninput="this.setCustomValidity('')"></textarea>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('cash.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
    </form>
</div>
      </div>
  </div>
</div>

@endsection

@push('script')
<script>
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa  = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return 'Rp ' + rupiah + (split[1] ? ',' + split[1] : '');
    }

    const displayInput = document.getElementById('amount_display');
    const hiddenInput = document.getElementById('amount');

    displayInput.addEventListener('input', function () {
        let numeric = this.value.replace(/[^0-9]/g, '');
        hiddenInput.value = numeric;
        this.value = formatRupiah(numeric);
    });
</script>
@endpush
