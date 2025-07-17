@extends('citizen.master_citizen')

@section('content')
{{-- <div class="container mt-4">
    <h4>Semua Notifikasi</h4>
    <ul class="list-group mt-3">
        @forelse($notifications as $notif)
            <li class="list-group-item d-flex justify-content-between">
                <div>
                    <strong>{{ $notif->title }}</strong><br>
                    <small>{{ $notif->message }}</small><br>
                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                </div>
                <form action="{{ route('notifications.delete', $notif->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </li>
        @empty
            <li class="list-group-item text-center">Tidak ada notifikasi.</li>
        @endforelse
    </ul>

    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
</div> --}}
<div class="row">
    <div class="col-md-4 app-invoice border-end">
      <ul class="overflow-auto invoice-users" data-simplebar>
        @foreach ($notifications as $notif)
        <li>
          <a href="javascript:void(0)"
             class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
             data-id="{{ $notif->id }}">
            <div class="btn btn-{{ $notif->type === 'success' ? 'success' : ($notif->type === 'warning' ? 'warning' : 'secondary') }} round rounded-circle d-flex align-items-center justify-content-center px-2">
              <i class="ti ti-bell fs-6"></i>
            </div>
            <div class="ms-3 d-inline-block w-75">
              <h6 class="mb-0 invoice-customer text-truncate">{{ $notif->title }}</h6>
              <span class="fs-3 invoice-id text-truncate d-block">{{ $notif->created_at->diffForHumans() }}</span>
            </div>
          </a>
        </li>
        @endforeach
      </ul>
    </div>
  
    <div class="col-md-8 chat-container">
      <div class="invoice-inner-part h-100">
        <div class="invoiceing-box">
          <div class="invoice-header d-flex align-items-center border-bottom p-3">
            <h4 class="mb-0 text-uppercase">Detail Notifikasi</h4>
          </div>
          <div class="p-3" id="notif-detail">
            <p class="text-muted">Klik salah satu notifikasi untuk melihat detailnya.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection

@push('scripts')
<script>
$(document).ready(function() {
  $('.invoice-user').on('click', function () {
    const notifId = $(this).data('id');

    $.get(`/notifications/${notifId}`, function (data) {
      $('#notif-detail').html(`
        <h5>${data.title}</h5>
        <p>${data.message}</p>
        <small class="text-muted">${new Date(data.created_at).toLocaleString()}</small>
      `);
    });
  });
});
</script>
@endpush

