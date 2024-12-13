<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form tambah
$id_jemaat = $_POST['id_jemaat'];
$tempat_nikah = $_POST['tempat_nikah'];
$pelayanan = $_POST['pelayanan'];
$tanggal_nikah = $_POST['tanggal_nikah'];
$saksi_nikah = $_POST['saksi_nikah'];

// Lakukan validasi data
if (empty($id_jemaat) || empty($tempat_nikah) || empty($pelayanan) || empty($tanggal_nikah) || empty($saksi_nikah)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data nikah ke dalam database
$query = "INSERT INTO nikah (id_jemaat, tempat_nikah, pelayanan, tanggal_nikah, saksi_nikah) 
          VALUES ('$id_jemaat', '$tempat_nikah', '$pelayanan', '$tanggal_nikah', '$saksi_nikah')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
