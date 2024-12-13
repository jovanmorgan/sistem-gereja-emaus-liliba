<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form edit
$id_sidi = $_POST['id_sidi'];
$id_jemaat = $_POST['id_jemaat'];
$gereja = $_POST['gereja'];
$pelayanan = $_POST['pelayanan'];
$tanggal_sidi = $_POST['tanggal_sidi'];
$tempat = $_POST['tempat'];

// Lakukan validasi data
if (empty($id_sidi) || empty($id_jemaat) || empty($gereja) || empty($pelayanan) || empty($tanggal_sidi) || empty($tempat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data sidi berdasarkan id_sidi
$query = "UPDATE sidi 
          SET id_jemaat = '$id_jemaat',
              gereja = '$gereja',
              pelayanan = '$pelayanan',
              tanggal_sidi = '$tanggal_sidi',
              tempat = '$tempat' 
          WHERE id_sidi = '$id_sidi'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
