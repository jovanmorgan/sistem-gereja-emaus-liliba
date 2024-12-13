<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form tambah
$nama_rayon = $_POST['nama_rayon'];
// Lakukan validasi data
if (empty($nama_rayon)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data rayon ke dalam database
$query = "INSERT INTO rayon (nama_rayon) 
          VALUES ('$nama_rayon')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
