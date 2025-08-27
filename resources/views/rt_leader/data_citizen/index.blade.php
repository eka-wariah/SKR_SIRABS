@extends('rt_leader.master_rt-leader')

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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Data Warga {{ Auth::user()->areaScope->asc_level }} {{ str_pad(Auth::user()->areaScope->asc_number, 2, '0', STR_PAD_LEFT) }}</h4>
                    {{-- <a href="{{ route('rt_leader.citizen.create') }}" class="btn btn-primary">➕ Tambah Data Warga</a> --}}
                </div>
            
                {{-- Tombol toggle --}}
                <div class="btn-group mb-4" role="group" aria-label="Tombol View">
                    <button type="button" class="btn btn-outline-primary active" id="btn-lengkap">📋 Data Lengkap Warga</button>
                    <button type="button" class="btn btn-outline-secondary" id="btn-perkk">👪 Data Warga per KK</button>
                </div>
                <div id="view-lengkap">
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>No. KK</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($warga as $w)
                            <tr>
                                <td>{{ $w->nik }}</td>
                                <td>{{ $w->first_name }} {{ $w->last_name }}</td>
                                <td>{{ $w->household->no_kk ?? '-' }}</td>
                                <td>{{ $w->address }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
     {{-- Tampilan per KK (hidden awalnya) --}}
     <div id="view-perkk" style="display: none;">
        @foreach($kkPaginated as $members)
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <strong>No. KK:</strong> {{ $members->first()->household->no_kk ?? '-' }}
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>RT</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $index => $member)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $member->nik }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->areaScope->asc_number ?? '-' }}</td>
                                    <td>{{ $member->address ?? $member->household->alamat ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
    
    {{-- Tampilkan pagination --}}
    <div class="d-flex justify-content-center">
        {{ $kkPaginated->links() }}
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

<script src="{{ asset('modernize/assets/js/datatable/datatable-advanced.init.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({ responsive: true });

        // Toggle views
        $('#btn-lengkap').on('click', function() {
            $('#view-lengkap').show();
            $('#view-perkk').hide();
            $(this).addClass('btn-primary').removeClass('btn-outline-primary');
            $('#btn-perkk').removeClass('btn-primary').addClass('btn-outline-secondary');
        });

        $('#btn-perkk').on('click', function() {
            $('#view-perkk').show();
            $('#view-lengkap').hide();
            $(this).addClass('btn-primary').removeClass('btn-outline-secondary');
            $('#btn-lengkap').removeClass('btn-primary').addClass('btn-outline-primary');
        });
    });
</script>
@endpush
