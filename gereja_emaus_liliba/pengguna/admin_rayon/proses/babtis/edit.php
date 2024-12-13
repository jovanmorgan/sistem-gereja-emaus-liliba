<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form edit
$id_babtis = $_POST['id_babtis'];
$id_jemaat = $_POST['id_jemaat'];
$nama_saksi = $_POST['nama_saksi'];
$pelayanan = $_POST['pelayanan'];
$tanggal_babtis = $_POST['tanggal_babtis'];
$tempat = $_POST['tempat'];

// Lakukan validasi data
if (empty($id_babtis) || empty($id_jemaat) || empty($nama_saksi) || empty($pelayanan) || empty($tanggal_babtis) || empty($tempat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data babtis berdasarkan id_babtis
$query = "UPDATE babtis 
          SET id_jemaat = '$id_jemaat',
              nama_saksi = '$nama_saksi',
              pelayanan = '$pelayanan',
              tanggal_babtis = '$tanggal_babtis',
              tempat = '$tempat' 
          WHERE id_babtis = '$id_babtis'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
