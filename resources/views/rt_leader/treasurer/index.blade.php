@extends('rt_leader.master_rt-leader')
@section('title', 'Kelola Bendahara RT')

@section('content')
<div class="container py-4">
  <h4 class="mb-4 fw-semibold">Bendahara RT Anda</h4>

  @if ($treasurer)
    <div class="content-wrapper">
        <div class="card mb-6">
          <div class="card-body pt-12">
      
            {{-- Avatar dan Nama --}}
            <div class="user-avatar-section">
              <div class="d-flex align-items-center flex-column">
                <img
                  class="img-fluid rounded mb-4"
                  src="{{ asset('vuexy/assets/img/avatars/1.png') }}"
                  height="120"
                  width="120"
                  alt="User avatar" />
                <div class="user-info text-center">
                  <h5>{{ $treasurer->name }}</h5>
                  <span class="badge bg-label-secondary">Bendahara</span>
                </div>
              </div>
            </div>
      
            {{-- Detail Pengguna --}}
            <h5 class="pb-4 border-bottom mb-4">Detail</h5>
            <div class="info-container">
              <ul class="list-unstyled mb-6">
                <li class="mb-2"><span class="h6">Username:</span> <span>{{ $treasurer->name }}</span></li>
                <li class="mb-2"><span class="h6">Email:</span> <span>{{ $treasurer->email }}</span></li>
                <li class="mb-2"><span class="h6">Status:</span> <span>Aktif</span></li>
                <li class="mb-2"><span class="h6">Role:</span> <span>Bendahara</span></li>
                <li class="mb-2"><span class="h6">Wilayah RT:</span> <span>{{ $treasurer->treasurer->areaScope ? $treasurer->treasurer->areaScope->asc_level . ' ' . $treasurer->treasurer->areaScope->asc_number : '-' }}</span></li>
                <li class="mb-2"><span class="h6">Diangkat Sejak</span> <span>{{ $treasurer->treasurer->created_at ? $treasurer->treasurer->created_at->translatedFormat('d F Y') : '-' }}</span></li>
              </ul>
              
              {{-- Tombol Aksi --}}
              <div class="d-flex justify-content-center">
                <a href="javascript:;" class="btn btn-label-danger suspend-user">
                    Jadikan Warga
                </a>
              </div>
            </div>
      
          </div>
        </div>
      </div>
      
  @else
    <div class="alert alert-warning mb-4">
      Belum ada bendahara untuk RT ini. Silakan pilih warga sebagai bendahara.
    </div>
    <a href="{{ route('treasurer.create') }}" class="btn btn-primary">Pilih Bendahara</a>
  @endif
</div>
@endsection

@push('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function () {
    $('.delete-btn').click(function () {
      const id = $(this).data('id');
      const name = $(this).data('name');

      Swal.fire({
        title: 'Yakin?',
        text: `Ingin menghapus ${name} sebagai bendahara?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: `/rt_leader/treasurer/${id}/destroy`,
            method: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function (res) {
              Swal.fire('Berhasil!', res.success, 'success').then(() => location.reload());
            },
            error: function () {
              Swal.fire('Gagal', 'Terjadi kesalahan.', 'error');
            }
          });
        }
      });
    });
  });
</script>
@endpush
