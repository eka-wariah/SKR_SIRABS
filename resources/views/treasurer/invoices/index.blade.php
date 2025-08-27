{{-- @extends('treasurer.master_treasurer')

@push('link')
<link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title', 'SITAW | Laporan Penyerahan Dana')

@section('content')
<div class="datatables" style="padding: 25px">
    <div class="card">
        <div class="card-body">
            <div class="mb-5 position-relative">
<h4 class="card-title mb-0">Daftar Tagihan Warga RT {{ Auth::user()->usr_scope_id }}</h4>

<div class="table-responsive">
<table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
    <thead>
        <tr>
            <th width="10%">No Invoice</th>
            <th>Warga</th>
            <th>Periode</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($invoices as $inv)
            <tr>
                <td>{{ $inv->invoice_number }}</td>
                <td>{{ $inv->owner()?->name ?? '-' }}</td>
                <td>{{ $inv->periode }}</td>
                <td>{{ $inv->formatted_amount }}</td>
                <td>{{ ucfirst($inv->status) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Tidak ada tagihan</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>

{{ $invoices->links() }}
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{ asset('modernize/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="{{ asset('modernize/assets/js/datatable/datatable-advanced.init.js')}}"></script>



@endpush
 --}}

 @extends('treasurer.master_treasurer')

@push('link')
<link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title', 'SITAW | Laporan Penyerahan Dana')

@section('content')
<div class="datatables" style="padding: 25px">
    <div class="card">
        <div class="card-body">
            <div class="mb-5 position-relative">
                <h4 class="card-title mb-3">Daftar Tagihan Warga RT {{ Auth::user()->usr_scope_id }}</h4>

                {{-- Filter --}}
                <form id="filterForm" class="row g-2 mb-4">
                    <div class="col-md-3">
                        <select name="year" class="form-control">
                            <option value="">-- Pilih Tahun --</option>
                            @foreach(range(date('Y'), date('Y') - 5) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="month" class="form-control">
                            <option value="">-- Pilih Bulan --</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">-- Pilih Status --</option>
                            <option value="pending">Belum dibayar</option>
                            <option value="lunas">Lunas</option>
                        </select>
                    </div>
                </form>

                {{-- Tabel --}}
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th width="10%">No Invoice</th>
                                <th>Warga</th>
                                <th>Periode</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{ asset('modernize/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
    let table = $('#file_export').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('treasurer.invoices.index') }}",
            data: function (d) {
                d.year = $('select[name=year]').val();
                d.month = $('select[name=month]').val();
                d.status = $('select[name=status]').val();
            }
        },
        columns: [
            { data: 'invoice_number', name: 'invoice_number' },
            { data: 'warga', name: 'warga' },
            { data: 'periode', name: 'periode' },
            { data: 'formatted_amount', name: 'formatted_amount' },
            { 
                data: 'status', 
                name: 'status',
                render: function (data) {
                    let badgeClass = 'bg-secondary';
                    if (data === 'paid') badgeClass = 'bg-success';
                    else if (data === 'overdue') badgeClass = 'bg-danger';
                    else if (data === 'cancelled') badgeClass = 'bg-warning text-dark';
                    return `<span class="badge ${badgeClass}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                }
            }
        ]
    });

    // Reload otomatis saat filter berubah
    $('#filterForm select').on('change', function () {
        table.ajax.reload();
    });
});
</script>
@endpush

