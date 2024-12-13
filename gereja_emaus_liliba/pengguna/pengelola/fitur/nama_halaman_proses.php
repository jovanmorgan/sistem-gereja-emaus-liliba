<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page_proses = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Tentukan judul halaman berdasarkan nama file
switch ($current_page_proses) {
    case 'dashboard':
        $page_title_proses = 'dashboard';
        break;
    case 'atestasi':
        $page_title_proses = 'atestasi';
        break;
    case 'babtis':
        $page_title_proses = 'babtis';
        break;
    case 'jemaat':
        $page_title_proses = 'jemaat';
        break;
    case 'ketua_mjh':
        $page_title_proses = 'ketua_mjh';
        break;
    case 'kk':
        $page_title_proses = 'kk';
        break;
    case 'pindah_agama':
        $page_title_proses = 'pindah_agama';
        break;
    case 'rayon':
        $page_title_proses = 'rayon';
        break;
    case 'admin_rayon':
        $page_title_proses = 'admin_rayon';
        break;
    case 'nikah':
        $page_title_proses = 'nikah';
        break;
    case 'sidi':
        $page_title_proses = 'sidi';
        break;
    case 'permintaan_update':
        $page_title_proses = 'permintaan_update';
        break;
    case 'pengelola':
        $page_title_proses = 'pengelola';
        break;
    case 'log_out':
        $page_title_proses = 'Log Out';
        break;
    default:
        $page_title_proses = 'admin Fasya Bakery';
        break;
}
