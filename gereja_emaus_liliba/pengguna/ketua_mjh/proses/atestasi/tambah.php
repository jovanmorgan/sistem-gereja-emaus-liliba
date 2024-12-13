<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form tambah
$id_jemaat = $_POST['id_jemaat'];
$gereja_asal = $_POST['gereja_asal'];
$gereja_tujuan = $_POST['gereja_tujuan'];
$status = $_POST['status'];

// Lakukan validasi data
if (empty($id_jemaat) || empty($gereja_asal) || empty($gereja_tujuan) || empty($status)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data atestasi ke dalam database
$query = "INSERT INTO atestasi (id_jemaat, gereja_asal, gereja_tujuan, status) 
          VALUES ('$id_jemaat', '$gereja_asal', '$gereja_tujuan', '$status')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
