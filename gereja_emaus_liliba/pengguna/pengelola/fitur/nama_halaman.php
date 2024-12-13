<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Tentukan judul halaman berdasarkan nama file
switch ($current_page) {
    case 'dashboard':
        $page_title = 'Dashboard';
        break;
    case 'atestasi':
        $page_title = 'Atestasi';
        break;
    case 'babtis':
        $page_title = 'Babtis';
        break;
    case 'jemaat':
        $page_title = 'Jemaat';
        break;
    case 'ketua_mjh':
        $page_title = 'Ketua Mjh';
        break;
    case 'kk':
        $page_title = 'Kepala Keluarga';
        break;
    case 'pindah_agama':
        $page_title = 'Pindah Agama';
        break;
    case 'rayon':
        $page_title = 'Rayon';
        break;
    case 'sidi':
        $page_title = 'Sidi';
        break;
    case 'pengelola':
        $page_title = 'Pengelola';
        break;
    case 'nikah':
        $page_title = 'Nikah';
        break;
    case 'admin_rayon':
        $page_title = 'Admin Rayon';
        break;
    case 'profile':
        $page_title = 'Profile';
        break;
    case 'permintaan_update':
        $page_title = 'Permintaan Update';
        break;
    case 'log_out':
        $page_title = 'Log Out';
        break;
    default:
        $page_title = 'admin Fasya Bakery';
        break;
}
