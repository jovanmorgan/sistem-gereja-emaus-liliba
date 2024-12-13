<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form edit
$id_nikah = $_POST['id_nikah'];
$id_jemaat = $_POST['id_jemaat'];
$tempat_nikah = $_POST['tempat_nikah'];
$pelayanan = $_POST['pelayanan'];
$tanggal_nikah = $_POST['tanggal_nikah'];
$saksi_nikah = $_POST['saksi_nikah'];

// Lakukan validasi data
if (empty($id_nikah) || empty($id_jemaat) || empty($tempat_nikah) || empty($pelayanan) || empty($tanggal_nikah) || empty($saksi_nikah)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data nikah berdasarkan id_nikah
$query = "UPDATE nikah 
          SET id_jemaat = '$id_jemaat',
              tempat_nikah = '$tempat_nikah',
              pelayanan = '$pelayanan',
              tanggal_nikah = '$tanggal_nikah',
              saksi_nikah = '$saksi_nikah'
          WHERE id_nikah = '$id_nikah'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
