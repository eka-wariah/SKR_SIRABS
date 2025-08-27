<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">
          <span class="text-primary">
            <span class="app-brand-logo demo">
              <span class="app-brand-logo demo">
                <img src="{{ asset('vuexy/assets/img/illustrations/logo10.png') }}"
                     alt="Logo SIRABAS"
                     style="max-height: 50px; max-width: 50px; border-radius: 50%; object-fit: contain;">
              </span>
            </span>
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
  <br>
    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item">
        <a href="/citizen" class="menu-link">
          <i class="menu-icon icon-base ti tabler-home"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>
  
      <!-- Forms & Tables -->
      <li class="menu-header small">
        <span class="menu-header-text" data-i18n="Pembayaran">Pembayaran</span>
      </li>
      <li class="menu-item">
        <a href="/citizen/payment" class="menu-link">
          <iconify-icon icon="mdi:account-payment-outline" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
          <div data-i18n="Pembayaran">Pembayaran</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="/citizen/payment/history" class="menu-link">
          <iconify-icon icon="mdi:payment-clock" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
          <div data-i18n="Riwayat Pembayaran">Riwayat Pembayaran</div>
        </a>
      </li>


      <li class="menu-header small">
        <span class="menu-header-text" data-i18n="Kegiatan Bank Sampah">Kegiatan Bank Sampah</span>
      </li>
      <li class="menu-item">
        <a href="/citizen/waste_bank/" class="menu-link">
          <iconify-icon icon="tabler:pencil-dollar" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
          <div data-i18n="Penghasilan Bank Sampah">Penghasilan Bank Sampah</div>
        </a>
      </li>

    </ul>
  </aside>