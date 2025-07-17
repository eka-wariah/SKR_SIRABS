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
<div class="container mt-4" style="padding: 25px">
    <div class="card">
        <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Daftar Ketua RT</h4>
        </div>
        <div class="card-body">
            <a href="/rw_leader/data_rt/create" class="btn btn-primary mb-3">+ Tambah Ketua RT</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="table-rt">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Ketua RT</th>
                            <th>Nomor RT</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataRT as $i => $rt)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $rt->name }}</td>
                            <td>{{ $rt->areaScope->asc_level ?? '-' }} {{ $rt->areaScope->asc_number ?? '-' }}</td>
                            <td>{{ $rt->email }}</td>
                            <td>{{ $rt->phone ?? '-' }}</td>
                            <td>
                                <a href="javascript:;" 
                                   class="btn btn-danger delete-btn" 
                                   data-id="{{ $rt->usr_id }}" 
                                   data-name="{{ $rt->name }}">
                                   Hapus Sebagai RT
                                </a>
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
<script>
$(document).ready(function() {
    $('.delete-btn').click(function() {
        var RTId = $(this).data('id');
        var RTName = $(this).data('name');

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Ingin menjadikan " + RTName + " sebagai warga?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Jadikan Warga',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/rw_leader/data_rt/' + RTId,
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
