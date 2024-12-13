<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form tambah
$id_rayon = $_POST['id_rayon'];
$no_kk = $_POST['no_kk'];
$nama_kepala_keluarga = $_POST['nama_kepala_keluarga'];
// Lakukan validasi data
if (empty($id_rayon) || empty($no_kk) || empty($nama_kepala_keluarga)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data kk ke dalam database
$query = "INSERT INTO kk (id_rayon, no_kk, nama_kepala_keluarga) 
          VALUES ('$id_rayon', '$no_kk', '$nama_kepala_keluarga')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
