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
  <br>
    <div class="menu-inner-shadow"></div>
  
    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item">
        <a href="/treasurer" class="menu-link">
          <iconify-icon icon="tabler:home" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>
        <!-- Forms & Tables -->
        <li class="menu-header small">
          <span class="menu-header-text" data-i18n="Kelola Data Retribusi">Kelola Data Retribusi</span>
        </li>
        <li class="menu-item">
          <a href="/treasurer/payment_category" class="menu-link">
            <iconify-icon icon="tabler:filter-2-dollar" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
            <div data-i18n="Kategori Retribusi">Kategori Retribusi</div>
          </a>
        </li>
        
        <li class="menu-item">
          <a href="/treasurer/finance" class="menu-link">
            <iconify-icon icon="tabler:file-dollar" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
            <div data-i18n="Pembayaran Retribusi">Pembayaran Retribusi</div>
          </a>
        </li>
      <li class="menu-item">
        <a href="/treasurer/confirm_submission" class="menu-link">
          <iconify-icon icon="tabler:moneybag-edit" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
          <div data-i18n="Konfirmasi Retribusi via Bank Sampah">Konfirmasi Retribusi via Bank Sampah</div>
        </a>
       
      </li>
       <!-- Forms & Tables -->
       <li class="menu-header small">
        <span class="menu-header-text" data-i18n="Laporan">Laporan</span>
      </li>
      <li class="menu-item">
        <a href="/treasurer/report/upload" class="menu-link">
          <iconify-icon icon="tabler:file-upload" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
          <div data-i18n="Upload Laporan">Upload Laporan</div>
        </a>
      </li>
      
    </ul>
  </aside>