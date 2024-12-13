<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form edit
$id_kk = $_POST['id_kk'];
$id_rayon = $_POST['id_rayon'];
$no_kk = $_POST['no_kk'];
$nama_kepala_keluarga = $_POST['nama_kepala_keluarga'];

// Lakukan validasi data
if (empty($id_kk) || empty($id_rayon) || empty($no_kk) || empty($nama_kepala_keluarga)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data kk berdasarkan id_kk
$query = "UPDATE kk 
          SET id_kk = '$id_kk',
           no_kk = '$no_kk',
            nama_kepala_keluarga = '$nama_kepala_keluarga' WHERE id_kk = '$id_kk'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
