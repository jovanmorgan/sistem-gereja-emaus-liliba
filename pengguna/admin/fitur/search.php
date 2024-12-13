<?php
// Daftar halaman yang tersedia
$pages = [
    '../dashboard' => 'Dashboard dasbord admin',
    '../rayon' => 'Rayon',
    '../atestasi' => 'Atestasi',
    '../babtis' => 'Babtis',
    '../jemaat' => 'Jemaat',
    '../ketua_mjh' => 'Ketua Mjh',
    '../kk' => 'Kepala Keluarga kk kepala keluarga',
    '../pengelola' => 'Pengelola',
    '../pindah_agama' => 'Pindah Agama',
    '../profile' => 'Profile akun',
    '../permintaan_update' => 'Permintaan Update',
    '../sidi' => 'Sidi',
    '../log_out' => 'Log Out'
];

// Dapatkan query pencarian dari input
$query = isset($_POST['query']) ? strtolower(trim($_POST['query'])) : '';

// Variabel untuk menyimpan halaman yang cocok
$matched_page = null;

if ($query) {
    // Cari halaman yang tepat atau mendekati
    foreach ($pages as $page => $title) {
        if (strpos(strtolower($title), $query) !== false) {
            $matched_page = $page;
            break;
        }
    }

    // Redirect ke halaman yang cocok, atau ke halaman 404 jika tidak ada yang cocok
    if ($matched_page) {
        header("Location: $matched_page");
    } else {
        header("Location: ../404");
    }
    exit;
}
