@extends('wastebank_officer.master_officer')

@push('link')
<link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />
    <link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title', 'SITAW | Laporan Penyerahan Dana')

@section('content')
<div class="datatables" style="padding: 25px">
 
         {{-- KANAN: Search Box --}}
<div class="d-flex align-items-end">
<div id="searchBoxWrapper"></div>
</div>




{{-- Wrapper Tombol Export --}}
<div class="d-flex justify-content-end mb-2">
<div id="customButtonWrapper"></div>
</div>

{{-- Tabel --}}


    {{-- Filter --}}
    {{-- <div class="d-flex flex-wrap gap-3 mb-4">
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
    <option value="Belum Diserahkan" {{ $status == 'Belum Diserahkan' ? 'selected' : '' }}>Belum Diserahkan</option>
    <option value="Menunggu Konfirmasi" {{ $status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
    <option value="Sudah Dikonfirmasi" {{ $status == 'Sudah Dikonfirmasi' ? 'selected' : '' }}>Sudah Dikonfirmasi</option>
    </select>
    </div> --}}

    {{-- Wrapper Tombol Export --}}
  

    {{-- Tabel --}}
    <div class="card">
        <div class="card-body">
            <div>
                <h4 class="card-title mb-0">Daftar Kategori</h4>
                <br>
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
                <option value="semua" {{ $status_deposit == 'semua' ? 'selected' : '' }}>Belum Diserahkan</option>
                <option value="tabung" {{ $status_deposit == 'tabung' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                <option value="tunai" {{ $status_deposit == 'tunai' ? 'selected' : '' }}>Sudah Dikonfirmasi</option>
                </select>
                </div>
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
                        <!-- start row -->
                        

                        <tr>
                            <th></th>
                            <th>Total Keseluruhan</th>
                            <th id="totalDiserahkan">Rp 0</th> <!-- ini yang nanti diganti dari JS -->
                            <th></th>
                            <th></th>
                        </tr>
                        <!-- end row -->
                    </tfoot>
                </table>
            
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
                    url: "{{ route('wastebank.report.data') }}",
                    data: function (d) {
                        d.year = $('#filterYear').val();
                        d.month = $('#filterMonth').val();
                        d.usr_scope_id = $('#filterScope').val();
                        d.wtb_deposit_type = $('#filterStatus').val();
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
    
            // Load total pertama kali
            updateTotalDiserahkan();
    
            // Handler tombol "Tandai Diserahkan"
            $(document).on('click', '.btn-tandai-disahkan', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
    
                $.ajax({
                    url: '/laporan/bank-sampah/tandai/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        table.ajax.reload();
                        updateTotalDiserahkan();
                        // Bisa ditambah notifikasi sukses di sini
                    }
                });
            });
        });
        function updateTotalDiserahkan() {
    $.ajax({
        url: "{{ route('wastebank.report.total') }}",
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
            $('#totalDiserahkan').text('gagal awokwowowk');
        }
    });
}
    </script>
    
@endpush
