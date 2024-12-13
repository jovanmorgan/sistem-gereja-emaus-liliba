<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form edit
$id_rayon = $_POST['id_rayon'];
$nama_rayon = $_POST['nama_rayon'];

// Lakukan validasi data
if (empty($id_rayon) || empty($nama_rayon)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data rayon berdasarkan id_rayon
$query = "UPDATE rayon 
          SET nama_rayon = '$nama_rayon' WHERE id_rayon = '$id_rayon'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
