<?php
session_start();

// Periksa apakah pengguna sudah masuk atau belum
if (!isset($_SESSION['id_admin_rayon'])) {
    // Pengguna belum masuk, arahkan kembali ke halaman masuk.php
    header("Location: ../../berlangganan/login");
    exit; // Pastikan untuk menghentikan eksekusi skrip setelah 
}

$id_admin_rayon = $_SESSION['id_admin_rayon'];
