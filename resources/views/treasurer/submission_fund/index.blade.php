@extends('treasurer.master_treasurer')

@push('link')
<link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title', 'SITAW | Laporan Penyerahan Dana')

@section('content')
<div class="datatables" style="padding: 25px">

    {{-- Tabs Tahun --}}
    <ul class="nav nav-tabs" id="yearTabs">
        @foreach ([2025, 2024, 2023] as $tahun)
            <li class="nav-item">
                <button class="nav-link year-tab {{ request('year', date('Y')) == $tahun ? 'active' : '' }}"
                    data-year="{{ $tahun }}">{{ $tahun }}</button>
            </li>
        @endforeach
    </ul>

    {{-- Tombol Bulan --}}
    @php
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $selectedYear = request('year', date('Y'));
        $selectedMonth = request('month', date('n'));
        $selectedScope = request('usr_scope_id');
        $selectedStatus = request('pyn_status_submission');
    @endphp

    <div class="mt-3 d-flex flex-wrap gap-2" id="monthButtons">
        @foreach ($bulanList as $no => $namaBulan)
            <button class="btn btn-sm month-btn {{ $selectedMonth == $no ? 'btn-primary' : 'btn-outline-primary' }}"
                data-month="{{ $no }}">{{ $namaBulan }}</button>
        @endforeach
    </div>

    {{-- Dropdown Filter --}}
    <div class="mt-3 d-flex flex-wrap align-items-center gap-3">
        <select id="filterScope" class="form-select btn-sm border-primary" style="width: auto">
            <option value="">Semua RT</option>
            @foreach ($areaScope as $area)
                <option value="{{ $area->asc_id }}" {{ $selectedScope == $area->asc_id ? 'selected' : '' }}>
                    {{ $area->asc_level }} {{ $area->asc_number }}
                </option>
            @endforeach
        </select>

        <select id="filterStatus" class="form-select btn-sm border-primary" style="width: auto">
            <option value="">Semua Status</option>
            <option value="Menunggu Konfirmasi" {{ $selectedStatus == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
            <option value="Sudah Dikonfirmasi" {{ $selectedStatus == 'Sudah Dikonfirmasi' ? 'selected' : '' }}>Sudah Dikonfirmasi</option>
        </select>
    </div>

    {{-- Tabel --}}
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title mb-3">Daftar Kategori</h4>
            <div id="customButtonWrapper" class="d-flex justify-content-end mb-2"></div>

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
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('modernize/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let table;
    let selectedYear = @json($selectedYear);
    let selectedMonth = @json($selectedMonth);

    $(document).ready(function () {
        function updateTable() {
            table.ajax.reload();
            updateTotalDiserahkan();
        }

        table = $("#file_export").DataTable({
    dom: "<'row mb-3'<'col-md-6'><'col-md-6 text-end'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",
    ajax: {
        url: "{{ route('confirm_submission.getDataConfirm') }}",
        data: function (d) {
            d.year = selectedYear;
            d.month = selectedMonth;
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
        updateTotalDiserahkan();

        // Tahun
        $(document).on('click', '.year-tab', function () {
            selectedYear = $(this).data('year');
            $('.year-tab').removeClass('active');
            $(this).addClass('active');
            updateTable();
        });

        // Bulan
        $(document).on('click', '.month-btn', function () {
            selectedMonth = $(this).data('month');
            $('.month-btn').removeClass('btn-primary').addClass('btn-outline-primary');
            $(this).removeClass('btn-outline-primary').addClass('btn-primary');
            updateTable();
        });

        // Filter Scope & Status
        $('#filterScope, #filterStatus').on('change', function () {
            updateTable();
        });

        // Konfirmasi
        $(document).on('click', '.btn-konfirmasi', function (e) {
            e.preventDefault();
            const id = $(this).data('id');

            $.ajax({
                url: '/treasurer/confirm_submission/confirm/' + id,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    table.ajax.reload(null, false);
                    updateTotalDiserahkan();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal mengkonfirmasi!'
                    });
                }
            });
        });
    });

    function updateTotalDiserahkan() {
        $.ajax({
            url: '/treasurer/confirm_submission/total',
            method: 'GET',
            data: {
                year: selectedYear,
                month: selectedMonth,
                usr_scope_id: $('#filterScope').val(),
                pyn_status_submission: $('#filterStatus').val()
            },
            success: function (res) {
                $('#totalDiserahkan').text(res.total_format);
            },
            error: function () {
                $('#totalDiserahkan').text('Gagal ambil total');
            }
        });
    }
</script>
@endpush
