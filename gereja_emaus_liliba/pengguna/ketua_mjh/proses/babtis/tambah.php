<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form tambah
$id_jemaat = $_POST['id_jemaat'];
$nama_saksi = $_POST['nama_saksi'];
$pelayanan = $_POST['pelayanan'];
$tanggal_babtis = $_POST['tanggal_babtis'];
$tempat = $_POST['tempat'];

// Lakukan validasi data
if (empty($id_jemaat) || empty($nama_saksi) || empty($pelayanan) || empty($tanggal_babtis) || empty($tempat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data babtis ke dalam database
$query = "INSERT INTO babtis (id_jemaat, nama_saksi, pelayanan, tanggal_babtis, tempat) 
          VALUES ('$id_jemaat', '$nama_saksi', '$pelayanan', '$tanggal_babtis', '$tempat')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
