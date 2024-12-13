<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form tambah
$id_jemaat = $_POST['id_jemaat'];
$gereja = $_POST['gereja'];
$pelayanan = $_POST['pelayanan'];
$tanggal_sidi = $_POST['tanggal_sidi'];
$tempat = $_POST['tempat'];

// Lakukan validasi data
if (empty($id_jemaat) || empty($gereja) || empty($pelayanan) || empty($tanggal_sidi) || empty($tempat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data sidi ke dalam database
$query = "INSERT INTO sidi (id_jemaat, gereja, pelayanan, tanggal_sidi, tempat) 
          VALUES ('$id_jemaat', '$gereja', '$pelayanan', '$tanggal_sidi', '$tempat')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
