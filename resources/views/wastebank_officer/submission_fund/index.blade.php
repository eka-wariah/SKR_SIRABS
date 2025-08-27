@extends('wastebank_officer.master_officer')

@push('link')
<link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css') }}" />
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title', 'SITAW | Laporan Penyerahan Dana')

@section('content')
<div class="datatables" style="padding: 25px">
    <div class="d-flex flex-wrap gap-3 mb-3">
        <select id="filterYear" class="form-select w-auto">
            @foreach ([2025, 2024, 2023] as $tahun)
                <option value="{{ $tahun }}" {{ request('year', date('Y')) == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
            @endforeach
        </select>

        <select id="filterMonth" class="form-select w-auto">
            @foreach ([1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'] as $num => $bulan)
                <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>{{ $bulan }}</option>
            @endforeach
        </select>

        <select id="filterScope" class="form-select w-auto">
            <option value="">Semua RT</option>
            @foreach ($areaScope as $area)
                <option value="{{ $area->asc_id }}">{{ $area->asc_level }} {{ $area->asc_number }}</option>
            @endforeach
        </select>

        <select id="filterStatus" class="form-select w-auto">
            <option value="">Semua Status</option>
            <option value="Belum Diserahkan">Belum Diserahkan</option>
            <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
            <option value="Sudah Dikonfirmasi">Sudah Dikonfirmasi</option>
        </select>
    </div>

    <div class="table-responsive">
        <table id="file_export" class="table table-bordered table-striped text-nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Warga</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Total Keseluruhan</th>
                    <th id="totalDiserahkan">Rp 0</th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@push('script')
<script>
    let table;
    $(document).ready(function () {
        table = $("#file_export").DataTable({
            dom: '<"d-flex justify-content-start gap-2 mb-3"B>frtip',
            buttons: [
                { extend: 'copy', text: 'Copy', className: 'btn btn-primary' },
                { extend: 'csv', text: 'CSV', className: 'btn btn-primary' },
                { extend: 'excel', text: 'Excel', className: 'btn btn-primary' },
                { extend: 'pdf', text: 'PDF', className: 'btn btn-primary' },
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'btn btn-primary',
                    title: 'Laporan Penyerahan Dana',
                    customize: function (win) {
                        const footer = $('#file_export tfoot').html();
                        $(win.document.body).find('table').append(`<tfoot>${footer}</tfoot>`);
                    }
                }
            ],
            ajax: {
                url: "{{ route('submission.data') }}",
                data: function (d) {
                    d.year = $('#filterYear').val();
                    d.month = $('#filterMonth').val();
                    d.usr_scope_id = $('#filterScope').val();
                    d.pyn_status_submission = $('#filterStatus').val();
                },
                dataSrc: 'data'
            },
            columns: [
                { data: 'index' },
                { data: 'nama' },
                { data: 'jumlah' },
                { data: 'status' },
                { data: 'aksi' }
            ],
            columnDefs: [
                { targets: [3, 4], orderable: false, searchable: false }
            ]
        });

        table.buttons().container().appendTo('#customButtonWrapper');

        $('#filterYear, #filterMonth, #filterScope, #filterStatus').on('change', function () {
            table.ajax.reload();
            updateTotalDiserahkan();
        });

        updateTotalDiserahkan();

        $(document).on('click', '.btn-tandai-disahkan', function (e) {
            e.preventDefault();
            let id = $(this).data('id');

            $.ajax({
                url: '/submission/tandai/' + id,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function (res) {
                    table.ajax.reload();
                    updateTotalDiserahkan();
                }
            });
        });
    });

    function updateTotalDiserahkan() {
        $.ajax({
            url: '/submission/total',
            method: 'GET',
            data: {
                year: $('#filterYear').val(),
                month: $('#filterMonth').val(),
                usr_scope_id: $('#filterScope').val() || null,
                pyn_status_submission: $('#filterStatus').val() || null
            },
            success: function (res) {
                $('#totalDiserahkan').text(res.total_format);
            },
            error: function () {
                $('#totalDiserahkan').text('Gagal memuat');
            }
        });
    }
</script>
@endpush
