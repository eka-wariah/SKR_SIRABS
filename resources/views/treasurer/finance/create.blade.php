@extends('treasurer.master_treasurer')

@push('link')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container mt-4">
    <h4>Tambah Pemasukan</h4>

    <form action="{{ route('treasurer.finance.payment.store') }}" method="POST">
        @csrf

        <!-- Pilih Warga -->
        <div class="mb-3">
            <label>Nama Warga</label>
            <select name="user_id" class="form-select select2" id="selectWarga" required>
                <option value="" disabled selected>-- Pilih Warga --</option>
                @foreach($warga as $user)
                    <option value="{{ $user->usr_id }}">{{ $user->name }} - NIK {{ $user->nik }}</option>
                @endforeach
            </select>
        </div>

        <!-- Kategori Pembayaran -->
        <div class="mb-3">
            <label>Kategori Pembayaran</label>
            <select name="pyn_payment_category_id" class="form-select" id="kategoriPembayaran" required>
                @foreach($paymentCategories as $category)
                    <option value="{{ $category->pym_id }}" data-total="{{ $category->pym_total }}">
                        {{ $category->pym_name }}
                    </option>
                @endforeach
                <option value="combined">Gabungan Air & Sampah</option>
            </select>
        </div>

        <!-- Total Bayar -->
        <div class="mb-3">
            <label>Total Bayar</label>
            <input type="text" id="totalBayar" class="form-control" readonly>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection

@push('script')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi Select2 untuk select warga
            $('#selectWarga').select2({
                placeholder: 'Cari nama warga...',
                width: '100%'
            });

            const kategori = document.getElementById('kategoriPembayaran');
            const totalBayar = document.getElementById('totalBayar');

            function updateTotal() {
                const selected = kategori.options[kategori.selectedIndex];
                const total = selected.dataset.total || 0;

                if (kategori.value === 'combined') {
                    fetch('{{ route("api.payment.total") }}?type=combined')
                        .then(res => res.json())
                        .then(data => {
                            totalBayar.value = 'Rp ' + data.total.toLocaleString();
                        });
                } else {
                    totalBayar.value = 'Rp ' + parseInt(total).toLocaleString();
                }
            }

            kategori.addEventListener('change', updateTotal);
            updateTotal(); // jalankan saat halaman pertama kali load
        });
    </script>
@endpush
