@extends('wastebank_officer.master_officer')

@section('title', 'Form Penarikan Saldo')

@section('content')
<div class="container py-4">
    <h4>Form Penarikan Saldo</h4>

    <form action="{{ route('withdraw.store') }}" method="POST">
        @csrf
        <input type="hidden" name="usr_id" value="{{ $user->usr_id }}">
        <input type="hidden" id="user_balance" value="{{ $user->total_money }}">
        <input type="hidden" id="amount_real" name="amount">

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" class="form-control" value="{{ $user->name }}" disabled>
        </div>

        <div class="mb-3">
            <label>Saldo Saat Ini</label>
            <input type="text" class="form-control" value="Rp {{ number_format($user->total_money, 0, ',', '.') }}" disabled>
        </div>

        <div class="mb-3">
            <label>Jumlah Penarikan</label>
            <input type="text" id="amount_input" class="form-control" placeholder="Rp 0" required>
            <small id="remaining_info" class="d-block mt-1 text-muted"></small>
        </div>


        <button class="btn btn-primary">Kirim Penarikan</button>
    </form>
</div>
@endsection

@push('script')
<script>
const amountInput = document.getElementById('amount_input');
const amountHidden = document.getElementById('amount_real');
const info = document.getElementById('remaining_info');
const saldoAwal = parseInt(document.getElementById('user_balance').value);

amountInput.addEventListener('input', function () {
    let raw = this.value.replace(/[^0-9]/g, '');
    if (!raw) {
        amountHidden.value = '';
        this.value = '';
        info.textContent = '';
        return;
    }

    const amount = parseInt(raw);
    this.value = 'Rp ' + amount.toLocaleString('id-ID');
    amountHidden.value = amount;

    if (amount > saldoAwal) {
        info.textContent = '⚠️ Jumlah melebihi saldo!';
        info.classList.add('text-danger');
        info.classList.remove('text-muted');
    } else {
        const sisa = saldoAwal - amount;
        info.textContent = `Sisa saldo setelah penarikan: Rp ${sisa.toLocaleString('id-ID')}`;
        info.classList.remove('text-danger');
        info.classList.add('text-muted');
    }
});
</script>
@endpush
