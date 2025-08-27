<nav
class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
id="layout-navbar">
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
  <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
    <i class="icon-base ti tabler-menu-2 icon-md"></i>
  </a>
</div>

<div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
  <!-- Search -->
  <div class="navbar-nav align-items-center">
    <div class="nav-item navbar-search-wrapper px-md-0 px-2 mb-0">
      <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
        <span class="d-inline-block text-body-secondary fw-normal" id="autocomplete"></span>
      </a>
    </div>
  </div>

  <!-- /Search -->

  <ul class="navbar-nav flex-row align-items-center ms-md-auto">

    <!--/ Language -->

    <!-- Style Switcher -->
    <li class="nav-item dropdown">
      <a
        class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
        id="nav-theme"
        href="javascript:void(0);"
        data-bs-toggle="dropdown">
        <i class="icon-base ti tabler-sun icon-22px theme-icon-active text-heading"></i>
        <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
        <li>
          <button
            type="button"
            class="dropdown-item align-items-center active"
            data-bs-theme-value="light"
            aria-pressed="false">
            <span><i class="icon-base ti tabler-sun icon-22px me-3" data-icon="sun"></i>Light</span>
          </button>
        </li>
        <li>
          <button
            type="button"
            class="dropdown-item align-items-center"
            data-bs-theme-value="dark"
            aria-pressed="true">
            <span
              ><i class="icon-base ti tabler-moon-stars icon-22px me-3" data-icon="moon-stars"></i
              >Dark</span
            >
          </button>
        </li>
        <li>
          <button
            type="button"
            class="dropdown-item align-items-center"
            data-bs-theme-value="system"
            aria-pressed="false">
            <span
              ><i
                class="icon-base ti tabler-device-desktop-analytics icon-22px me-3"
                data-icon="device-desktop-analytics"></i
              >System</span
            >
          </button>
        </li>
      </ul>
    </li>
    <!-- / Style Switcher-->

    <!-- Quick links -->

    <!-- Notification -->
   <!-- Notification -->
<li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
  <a
    class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
    href="javascript:void(0);"
    data-bs-toggle="dropdown"
    data-bs-auto-close="outside"
    aria-expanded="false">
    <span class="position-relative">
      <i class="icon-base ti tabler-bell icon-22px text-heading"></i>
      @if(auth()->user()->unreadNotifications->count())
        <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
      @endif
    </span>
  </a>

  <ul class="dropdown-menu dropdown-menu-end p-0">
    <!-- Header -->
    <li class="dropdown-menu-header border-bottom">
      <div class="dropdown-header d-flex align-items-center py-3">
        <h6 class="mb-0 me-auto">Notifikasi</h6>
        <div class="d-flex align-items-center h6 mb-0">
          @if(auth()->user()->unreadNotifications->count())
            <span class="badge bg-label-primary me-2">
              {{ auth()->user()->unreadNotifications->count() }} Baru
            </span>
          @endif
        </div>
      </div>
    </li>

    <!-- List Notifikasi -->
    <li class="dropdown-notifications-list scrollable-container">
      <ul class="list-group list-group-flush">
        @forelse(auth()->user()->notifications as $notif)
          <li class="list-group-item list-group-item-action dropdown-notifications-item {{ $notif->read_at ? 'marked-as-read' : '' }}">
            <div class="d-flex">
              <div class="flex-shrink-0 me-3">
                <div class="avatar">
                  <span class="avatar-initial rounded-circle bg-label-secondary">
                    <i class="icon-base ti tabler-info-circle"></i>
                  </span>
                </div>
              </div>
              <div class="flex-grow-1">
                <h6 class="mb-1 small">{{ $notif->data['title'] ?? 'Notifikasi' }}</h6>
                <small class="mb-1 d-block text-body">
                  <a href="{{ $notif->data['url'] ?? '#' }}">
                    {{ $notif->data['message'] ?? 'Tidak ada pesan.' }}
                  </a>
                </small>
                <small class="text-body-secondary">
                  {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                </small>
              </div>
              <div class="flex-shrink-0 dropdown-notifications-actions">
                <a href="{{ route('notifications.delete', $notif->id) }}" class="dropdown-notifications-archive">
                  <span class="icon-base ti tabler-x"></span>
                </a>
              </div>
            </div>
          </li>
        @empty
          <li class="list-group-item text-center">Tidak ada notifikasi.</li>
        @endforelse
      </ul>
    </li>

    <!-- Footer -->
    <li class="border-top">
      <div class="d-grid p-3">
        <a class="btn btn-primary btn-sm d-flex justify-content-center" href="{{ route('notifications.index') }}">
          <small class="align-middle">Lihat Semua Notifikasi</small>
        </a>
      </div>
    </li>
  </ul>
</li>
<!--/ Notification -->

    <!--/ Notification -->

    <!-- User -->
    <li class="nav-item dropdown-user dropdown">
      <a class="nav-link dropdown-toggle hide-arrow p-0" href="#" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
          <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('vuexy/assets/img/avatars/16.jpg') }}" class="rounded-circle" />
        </div>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="{{ route('profile.edit') }}">
            <div class="d-flex">
              <div class="flex-shrink-0 me-2">
                <div class="avatar avatar-online">
                  <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('vuexy/assets/img/avatars/16.jpg') }}" class="rounded-circle" />
                </div>
              </div>
              <div class="flex-grow-1">
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                <small class="text-muted">{{ ucfirst(Auth::user()->getRoleNames()->first()) }}</small>
              </div>
            </div>
          </a>
        </li>
        <li><hr class="dropdown-divider my-1"></li>
        <li>
          <a class="dropdown-item" href="{{ route('profile.edit_photo') }}">
            <i class="icon-base ti tabler-user me-3"></i>
            <span class="align-middle">Profil Saya</span>
          </a>
        </li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">
              <i class="icon-base ti tabler-logout me-3"></i>Logout
            </button>
          </form>
        </li>
      </ul>
    </li>
    <!--/ User -->
  </ul>
</div>
</nav>