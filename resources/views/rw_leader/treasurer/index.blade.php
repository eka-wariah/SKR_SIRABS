@extends('rw_leader.master_rw-leader')

@push('link')
    <link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />
    <link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SITAW | Daftar Kategori Pembayaran
@endsection

@section('content')
<div class="datatables" style="padding: 25px">
    <div class="card">
        <div class="card-body">
            <div class="mb-5 position-relative">
                <h4 class="card-title mb-0">Daftar Kategori</h4>
                <a href="treasurer/create" class="btn btn-primary position-absolute top-0 end-0">Tambah Kategori</a>
            </div> 
            <p class="card-subtitle mb-3">
                
            </p>
            <div class="table-responsive">
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
        <thead>
          <tr>
            <th width="10%">No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>actions</th>
          </tr>
        </thead>
        <tbody>
            <!-- start row -->
            @foreach ( $treasurers as $no=> $treasurer)
            <tr>
                <td>{{$no+1}}</td>
                <td>{{ $treasurer->name }}</td>
                <td>{{ $treasurer->email }}</td>
                {{-- <td>{{ $trs_area_id->areaScope->nama_wilayah ?? '-' }}</td> --}}
                
                {{-- <td>
                   <a href="/rw_leader/treasurer/{{ $treasurer->trs_id }}/destroy" class="btn btn-danger">Jadikan Warga</a>
                </td> --}}
                <td>
                    @if ($treasurer->treasurer)
                <button type="button"
                    class="btn btn-danger delete-btn"
                    data-id="{{ $treasurer->treasurer->trs_id }}"
                    data-name="{{ $treasurer->name }}">
                    Jadikan Warga
                </button>
            @else
                <span class="text-muted">Tidak ada data</span>
            @endif
        </td>
            </tr>
            @endforeach
            <!-- end row -->
            
        </tbody>
      </table>
    </div>
  </div>
    </div>
</div>
    {{-- <div class="datatables">
        <div class="card">
            <div class="card-body">
                <div class="mb-5 position-relative">
                    <h4 class="card-title mb-0">Daftar Kategori</h4>
                    <a href="area_scope/create" class="btn btn-primary position-absolute top-0 end-0">Tambah Kategori</a>
                </div> 
                <p class="card-subtitle mb-3">
                    
                </p>
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th></th>
                                <th width="10%">No</th>
                                <th>Nama</th>
                                <th>Lingkup Wilayah</th>
                                <th>Aksi</th>
                                
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            <!-- start row -->
                            @foreach ( $treasurers as $no=> $treasurer)
                            <tr>
                                <td></td>
                                <td>{{$no+1}}</td>
                                <td>{{ $treasurer->name }}</td>
                                <td>{{ $treasurer->email }}</td>
                                {{-- <td>{{ $trs_area_id->areaScope->nama_wilayah ?? '-' }}</td> --}}
                                
                                {{-- <td>
                                     <a href="/rw_leader/treasurer/{{ $treasurer->trs_id}}/edit" class="btn btn-primary">Edit</a>
                                     <a href="/rw_leader/treasurer/{{ $treasurer->trs_id}}/destroy" class="btn btn-danger" data-confirm-delete="true">Delete</a>

                                </td> --}}


                                
                            {{-- </tr>
                            @endforeach --}}
                            <!-- end row -->
                            
                        {{-- </tbody>
                        <tfoot> --}}
                            <!-- start row -->
                            
{{-- 
                            <tr>
                                <th width="10%">No</th>
                                <th>Lingkup Wilayah</th>
                                <th>Nomor</th>
                                <th>Aksi</th>
                            </tr> --}}
                            <!-- end row -->
                        {{-- </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>  --}}
    
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- pastikan SweetAlert2 ada --}}
<script>
$(document).ready(function() {
    $('.delete-btn').click(function() {
        var treasurerId = $(this).data('id');
        var treasurerName = $(this).data('name');

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Ingin menjadikan " + treasurerName + " sebagai warga?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Jadikan Warga',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/rw_leader/treasurer/' + treasurerId + '/destroy',
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Berhasil!',
                            response.success,
                            'success'
                        ).then(() => {
                            location.reload(); // Reload halaman setelah sukses
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan. Silakan coba lagi.',
                            'error'
                        );
                    }
                });
            }
        })
    });
});
</script>

{{-- <script>
    $(document).ready(function() {
        // Handle tombol delete
        $('.delete-btn').click(function() {
            var treasurerId = $(this).data('id');  // Ambil ID dari tombol yang diklik

            // SweetAlert konfirmasi sebelum menghapus
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data bendahara ini akan dikembalikan menjadi warga!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik Ya, kirim AJAX DELETE
                    $.ajax({
                        url: '/rw_leader/treasurer/' + treasurerId + '/destroy', // URL untuk destroy
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}', // CSRF token untuk keamanan
                        },
                        success: function(response) {
                            // Jika sukses, tampilkan pesan sukses
                            Swal.fire(
                                'Berhasil!',
                                response.success,
                                'success'
                            );

                            // Hapus baris yang ada di tabel (opsional)
                            $('button[data-id="'+treasurerId+'"]').closest('tr').remove();
                        },
                        error: function(xhr) {
                            // Jika error, tampilkan pesan error
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus data.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script> --}}
@include('sweetalert::alert')

@endpush
