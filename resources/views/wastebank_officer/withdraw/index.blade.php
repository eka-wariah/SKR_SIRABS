@extends('wastebank_officer.master_officer')

@push('link')
    <link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />
    <link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SITAW | Daftar Kategori Sampah
@endsection

@section('content')
<div class="datatables" style="padding: 25px">
    <div class="card">
        <div class="card-body">
            <div class="mb-5 position-relative">

    <h4>Penarikan Bank Sampah</h4>
    <div class="alert alert-info">
        <strong>Saldo Kas Tersedia:</strong> Rp {{ number_format($saldoTersedia, 0, ',', '.') }}
        <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Saldo Kas Tersedia adalah sisa dana bank sampah setelah pemasukan dikurangi pengeluaran."></i>
    </div>
    <div class="alert alert-warning">
        <strong>Total Saldo Warga:</strong> Rp {{ number_format($totalSaldoWarga, 0, ',', '.') }}
    </div>
   
    <label for="scope_id">Pilih RT:</label>
    <select id="scope_id" class="form-control mb-3">
        <option value="">-- Pilih RT --</option>
        @foreach($scopes as $scope)
            <option value="{{ $scope->asc_id }}">RT {{ $scope->asc_number }}</option>
        @endforeach
    </select>

    <div id="user-table"></div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YsYfObFJkF9nUO03Q2FJZzkUdGpU2nA8AVTUKjBkGw9QPS2rF2z0RLrJTZ6i1a+H" crossorigin="anonymous"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script>
document.getElementById('scope_id').addEventListener('change', function () {
    const scopeId = this.value;
    const tableDiv = document.getElementById('user-table');

    if (!scopeId) {
        tableDiv.innerHTML = '';
        return;
    }

    fetch(`/withdraw/users/${scopeId}`)
        .then(response => response.json())
        .then(users => {
            if (users.length === 0) {
                tableDiv.innerHTML = '<p>Tidak ada warga dengan saldo di RT ini.</p>';
                return;
            }

            let html = '<table class="table table-bordered"><thead><tr><th>Nama</th><th>Saldo</th><th>Penarikan</th></tr></thead><tbody>';
            users.forEach(user => {
                html += `<tr>
                    <td>${user.name}</td>
                    <td>Rp ${parseInt(user.total_money).toLocaleString('id-ID')}</td>
                    <td>
                        <a href="/wastebank_officer/withdraw/${user.usr_id}/create" class="btn btn-danger btn-sm">Tarik Saldo</a>
                    </td>
                </tr>`;
            });
            html += '</tbody></table>';
            tableDiv.innerHTML = html;
        });

});
</script>
@endpush