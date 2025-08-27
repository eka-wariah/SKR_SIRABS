@extends('wastebank_officer.master_officer')

@push('link')
    
@endpush

@section('title')
    SiTAW | Edit Setoran Bank Sampah
@endsection

@section('content')
<div class="row" style="padding: 25px">
    <div class="col-lg-12">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <h4 class="card-title mb-0">Edit Setoran Bank Sampah</h4>
            </div>

            <form action="{{ route('waste_bank.update', $waste_bank->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    {{-- PILIH WARGA --}}
                    <label class="form-label col-sm-3 col-form-label" for="usr_id">Pilih Warga</label>
                    <select name="usr_id" class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->usr_id }}" {{ $user->usr_id == $waste_bank->wtb_name_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- HASIL TIMBANGAN --}}
                    <div class="mb-3 mt-3">
                        <label class="form-label col-sm-3 col-form-label">Hasil Timbangan</label>
                        <div id="kategori-container">
                            @foreach ($waste_bank->details as $index => $detail)
                                <div class="kategori-item row mb-2">
                                    <div class="col-md-5">
                                        <select name="categories[{{ $index }}][trc_id]" class="form-control">
                                            @foreach ($trash_category as $trash)
                                                <option value="{{ $trash->trc_id }}" {{ $trash->trc_id == $detail->trc_id ? 'selected' : '' }}>
                                                    {{ $trash->trc_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="number" step="0.1" name="categories[{{ $index }}][berat]" class="form-control" value="{{ $detail->berat }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-kategori">-</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- TOTAL --}}
                    <div class="mb-3">
                        <label class="form-label">Total Uang yang Didapatkan</label>
                        <input type="text" id="total-uang" class="form-control" readonly>
                    </div>

                    {{-- METODE SETOR --}}
                    <div class="mb-3">
                        <label class="form-label col-sm-3 col-form-label">Metode Penyetoran</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="deposit_type" value="tabung" {{ $waste_bank->wtb_deposit_type == 'tabung' ? 'checked' : '' }}>
                            <label class="form-check-label">Ditabung ke Saldo</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="deposit_type" value="tunai" {{ $waste_bank->wtb_deposit_type == 'tunai' ? 'checked' : '' }}>
                            <label class="form-check-label">Diambil Tunai (tidak ditabung)</label>
                        </div>
                    </div>

                    {{-- TOMBOL --}}
                    <div class="row">
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-secondary mt-3" id="tambah-kategori">+ Tambah Kategori</button>
                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
<script>
    let i = {{ count($waste_bank->details) }};

    const hargaPerKategori = {
        @foreach ($trash_category as $trash)
            "{{ $trash->trc_id }}": {{ $trash->trc_price }},
        @endforeach
    };

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('.kategori-item').forEach(function (item) {
            const trcSelect = item.querySelector('select[name*="[trc_id]"]');
            const beratInput = item.querySelector('input[name*="[berat]"]');

            const trcId = trcSelect.value;
            const berat = parseFloat(beratInput.value) || 0;
            const harga = hargaPerKategori[trcId] || 0;

            const subtotal = berat * harga;
            total += subtotal;
        });

        document.getElementById('total-uang').value = formatRupiah(total);
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(angka);
    }

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
        hitungTotal();
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-kategori')) {
            const item = e.target.closest('.kategori-item');
            if (document.querySelectorAll('.kategori-item').length > 1) {
                item.remove();
                hitungTotal();
            }
        }
    });

    document.addEventListener('input', function (e) {
        if (e.target.matches('select[name*="[trc_id]"], input[name*="[berat]"]')) {
            hitungTotal();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        hitungTotal();
    });
</script>
@endpush
@endsection
