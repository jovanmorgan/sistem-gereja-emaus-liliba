<?php
session_start();

// Hapus sesi id_ketua_mjh jika ada
if (isset($_SESSION['id_ketua_mjh'])) {
    unset($_SESSION['id_ketua_mjh']);
}

// Redirect pengguna kembali ke halaman login
header("Location: ../../berlangganan/login");
exit;
