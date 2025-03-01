  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url; ?>/home" class="brand-link">
      <span class="brand-text font-weight-bold text-xl">Libra</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="" class="d-block"><?= htmlspecialchars($_SESSION['nama'] ?? 'Guest', ENT_QUOTES, 'UTF-8'); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Dashboard -->
          <li class="nav-item">
            <a href="<?= base_url; ?>/home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <!-- Data Section -->
          <li class="nav-header">Data</li>
          <li class="nav-item">
            <a href="<?= base_url; ?>/kategori" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>Kategori</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url; ?>/buku" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>Buku</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url; ?>/mahasiswa" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Mahasiswa</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url; ?>/petugas" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>Petugas</p>
            </a>
          </li>

          <!-- Action Section -->
          <li class="nav-header">Action</li>
          <li class="nav-item">
            <a href="<?= base_url; ?>/peminjaman" class="nav-link">
              <i class="nav-icon fas fa-hand-holding"></i>
              <p>Peminjaman</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url; ?>/pengembalian" class="nav-link">
              <i class="nav-icon fas fa-undo"></i>
              <p>Pengembalian</p>
            </a>
          </li>

          <!-- Extra Section -->
          <li class="nav-header">Extra</li>
          <li class="nav-item">
            <a href="<?= base_url; ?>/about" class="nav-link">
              <i class="nav-icon fas fa-info-circle"></i>
              <p>About Me</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>