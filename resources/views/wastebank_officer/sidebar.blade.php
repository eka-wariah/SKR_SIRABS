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
  
    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item">
        <a href="#" class="menu-link">
          <i class="menu-icon icon-base ti tabler-home"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>
        <!-- Forms & Tables -->
       <li class="menu-header small">
        <span class="menu-header-text" data-i18n="Data Bank Sampah">Data Bank Sampah</span>
      </li>
      <li class="menu-item">
        <a href="/wastebank_officer/trash_category" class="menu-link">
          <iconify-icon icon="tabler:trash" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
          <div data-i18n="Kategori Sampah">Kategori Sampah</div>
        </a>
      </li>

      <li class="menu-item">
        <a href="/wastebank_officer/waste_bank" class="menu-link">
          <iconify-icon icon="tabler:clipboard-data" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
          <div data-i18n="Data penyetoran">Data penyetoran</div>
        </a>
      </li>

      <li class="menu-header small">
        <span class="menu-header-text" data-i18n="Pemasukan dan Penarikan">Pemasukan dan Penarikan</span>
      </li>
      <li class="menu-item">
        <a href="/wastebank_officer/cashflow" class="menu-link">
          <iconify-icon icon="tabler:file-dollar" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
          <div data-i18n="Pemasukan dan Pengeluaran">Pemasukan dan Pengeluaran </div>
        </a>
      </li>
      <li class="menu-item">
        <a href="/wastebank_officer/withdraw" class="menu-link">
          <iconify-icon icon="tabler:file-dollar" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
          <div data-i18n="Penarikan Saldo">Penarikan Saldo </div>
        </a>
      </li>
    
      <!-- Forms & Tables -->
      <li class="menu-header small">
        <span class="menu-header-text" data-i18n="Penyerahan dana retribusi">Penyerahan dana retribusi</span>
      </li>
      <li class="menu-item">
        <a href="/wastebank_officer/submission" class="menu-link">
          <iconify-icon icon="tabler:file-dollar" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
          <div data-i18n="Data retribusi">Data retribusi </div>
        </a>
      </li>
      
         {{-- <!-- Forms & Tables -->
         <li class="menu-header small">
          <span class="menu-header-text" data-i18n="Laporan">Laporan</span>
        </li>
        <li class="menu-item">
          <a href="/citizen/waste_bank/" class="menu-link">
            <iconify-icon icon="tabler:pencil-dollar" class="menu-icon" style="font-size: 1.5rem;"></iconify-icon>
            <div data-i18n="Laporan Bank Sampah">Laporan Bank Sampah</div>
          </a>
        </li> --}}

    </ul>
  </aside>