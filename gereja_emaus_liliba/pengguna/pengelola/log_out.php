<?php
session_start();

// Hapus sesi id_pengelola jika ada
if (isset($_SESSION['id_pengelola'])) {
    unset($_SESSION['id_pengelola']);
}

// Redirect pengguna kembali ke halaman login
header("Location: ../../berlangganan/login");
exit;
