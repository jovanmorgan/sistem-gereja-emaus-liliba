<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form edit
$id_atestasi = $_POST['id_atestasi'];
$id_jemaat = $_POST['id_jemaat'];
$gereja_asal = $_POST['gereja_asal'];
$gereja_tujuan = $_POST['gereja_tujuan'];
$status = $_POST['status'];

// Lakukan validasi data
if (empty($id_atestasi) || empty($id_jemaat) || empty($gereja_asal) || empty($gereja_tujuan) || empty($status)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data atestasi berdasarkan id_atestasi
$query = "UPDATE atestasi 
          SET id_jemaat = '$id_jemaat',
              gereja_asal = '$gereja_asal',
              gereja_tujuan = '$gereja_tujuan',
              status = '$status' 
          WHERE id_atestasi = '$id_atestasi'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
