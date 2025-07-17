<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">
          <span class="app-brand-logo demo">
            <img src="{{ asset('vuexy/assets/img/illustrations/logo10.png') }}"
                 alt="Logo SIRABAS"
                 style="max-height: 50px; max-width: 50px; border-radius: 50%; object-fit: contain;">
          </span>
        </span>
        <span class="app-brand-text demo menu-text fw-bold ms-3">SIRABAS</span>
      </a>
  
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
        <i class="icon-base ti tabler-x d-block d-xl-none"></i>
      </a>
    </div>
  
    <div class="menu-inner-shadow"></div>
  
    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item">
        <a href="app-email.html" class="menu-link">
          <i class="menu-icon icon-base ti tabler-home"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>
  
      <!-- Apps & Pages --> 
      <li class="menu-header small">
        <span class="menu-header-text" data-i18n="Bendahara">Bendahara</span>
      </li>
      <li class="menu-item">
        <a
          href="/rt_leader/treasurer" class="menu-link">
          <i class="menu-icon icon-base ti tabler-map"></i>
          <div data-i18n="Data Bendahara">Data Bendahara</div>
        </a>
      </li>

      <li class="menu-header small">
        <span class="menu-header-text" data-i18n="Warga yang Registrasi">Warga yang Registrasi</span>
      </li>
      <li class="menu-item">
        <a
          href="/rt_leader/citizen" class="menu-link">
          <i class="menu-icon icon-base ti tabler-map"></i>
          <div data-i18n="Data Warga">Data Warga</div>
        </a>
      </li>

      <!-- Forms & Tables -->
      <li class="menu-header small">
        <span class="menu-header-text" data-i18n="Pengajuan Registrasi Air">Pengajuan Registrasi Air</span>
      </li>
      <li class="menu-item">
        <a
          href="/rt_leader/registration_water"class="menu-link">
          <i class="menu-icon icon-base ti tabler-file-description"></i>
          <div data-i18n="Data Pengajuan">Data Pengajuan</div>
        </a>
      </li>

          <!-- Forms & Tables -->
          <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Laporan">Laporan</span>
          </li>
          <li class="menu-item">
            <a
              href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/"
              target="_blank"
              class="menu-link">
              <i class="menu-icon icon-base ti tabler-file-description"></i>
              <div data-i18n="Laporan Retribusi">Laporan Retribusi</div>
            </a>
          </li>
    </ul>
  </aside>