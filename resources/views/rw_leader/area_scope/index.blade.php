@extends('rw_leader.master_rw-leader')

@push('link')
    <link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />
    <link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endpush

@section('title')
    SITAW | Daftar Kategori Pembayaran
@endsection

@section('content')
<div class="datatables" style="padding: 25px">
    <div class="card">
        <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Daftar Ketua RT</h4>
        </div>
        <div class="card-body">
            <a href="/rw_leader/area_scope/create" class="btn btn-primary mb-3">+ Tambah Wilayah RT</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="table-rt">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th>Lingkup Wilayah</th>
                            <th>Nomor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $area_scope as $no=> $area_scope)
                        <tr>
                            
                            <td>{{$no+1}}</td>
                            <td>{{ $area_scope->asc_level}}</td>
                            <td>{{ $area_scope->asc_number}}</td>
                            <td>
                                 <a href="/rw_leader/area_scope/{{ $area_scope->asc_id}}/edit" class="btn btn-primary">Edit</a>
                                 <a href="/rw_leader/area_scope/{{ $area_scope->asc_id}}/destroy" class="btn btn-danger" data-confirm-delete="true">Delete</a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
@endsection



@push('script')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table-rt').DataTable();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{ asset('modernize/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="{{ asset('modernize/assets/js/datatable/datatable-advanced.init.js')}}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- pastikan SweetAlert2 ada --}}

@include('sweetalert::alert')

@endpush
