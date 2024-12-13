<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Daftar halaman dengan nama dan ikon yang sesuai
$pages = [
    ['name' => 'Dashboard', 'url' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],  // Dashboard
    ['name' => 'Kepala Keluarga', 'url' => 'kk', 'icon' => 'fas fa-users'],  // Kepala Keluarga
    ['name' => 'Jemaat', 'url' => 'jemaat', 'icon' => 'fas fa-user-friends'],  // Jemaat
    ['name' => 'Babtis', 'url' => 'babtis', 'icon' => 'fas fa-water'],  // Babtis
    ['name' => 'Sidi', 'url' => 'sidi', 'icon' => 'fas fa-certificate'],  // Sidi
    ['name' => 'Pindah Agama', 'url' => 'pindah_agama', 'icon' => 'fas fa-exchange-alt'],  // Pindah Agama
    ['name' => 'Atestasi', 'url' => 'atestasi', 'icon' => 'fas fa-file-signature'],  // Atestasi
    ['name' => 'Nikah', 'url' => 'nikah', 'icon' => 'fas fa-ring'],  // Tambahan halaman Nikah
    ['name' => 'Permintaan Update', 'url' => 'permintaan_update', 'icon' => 'fas fa-sync'],
];

// Daftar halaman untuk "Account pages"
$account_pages = [
    ['name' => 'Profil', 'url' => 'profile', 'icon' => 'fas fa-user'],  // Profil
    ['name' => 'Log Out', 'url' => 'log_out', 'icon' => 'fas fa-sign-out-alt'],  // Log Out
];
?>


<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="dashboard" target="_blank">
            <img src="../../assets/img/gereja/logo.jpg" class="navbar-brand-img h-100" alt="main_logo" />
            <span class="ms-1 font-weight-bold">Gereja Emaus Liliba</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0" />
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: 400px;">
        <ul class="navbar-nav">
            <!-- Loop untuk halaman utama -->
            <?php foreach ($pages as $page): ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == $page['url']) ? 'active' : ''; ?>" href="<?= $page['url']; ?>">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <!-- Tambahkan kondisi untuk warna ikon -->
                            <i class="<?= $page['icon']; ?> "
                                style="color: <?= ($current_page == $page['url']) ? '#FFFFFF' : '#000000'; ?>;"></i>
                        </div>
                        <span class="nav-link-text ms-1"><?= $page['name']; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>

            <!-- Section Account Pages -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                    Account pages
                </h6>
            </li>

            <!-- Loop untuk halaman Account pages -->
            <?php foreach ($account_pages as $page): ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == $page['url']) ? 'active' : ''; ?>" href="<?= $page['url']; ?>">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <!-- Tambahkan kondisi untuk warna ikon -->
                            <i class="<?= $page['icon']; ?> "
                                style="color: <?= ($current_page == $page['url']) ? '#FFFFFF' : '#000000'; ?>;"></i>
                        </div>
                        <span class="nav-link-text ms-1"><?= $page['name']; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>