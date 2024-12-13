<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form edit
$id_permintaan_update = $_POST['id_permintaan_update'];
$pesan = $_POST['pesan'];
$tanggal = $_POST['tanggal'];
$status = "Belum Diupdate";

// Lakukan validasi data
if (empty($id_permintaan_update) || empty($pesan) || empty($tanggal)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data pesan berdasarkan id_permintaan_update
$query = "UPDATE permintaan_update 
          SET pesan = '$pesan', tanggal = '$tanggal', status = '$status' 
          WHERE id_permintaan_update = '$id_permintaan_update'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
