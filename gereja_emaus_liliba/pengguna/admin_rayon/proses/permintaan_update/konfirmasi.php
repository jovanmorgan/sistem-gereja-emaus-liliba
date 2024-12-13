<?php
include '../../../../keamanan/koneksi.php';

// Terima ID permintaan_update yang akan dihapus dari formulir HTML
$id_permintaan_update = $_POST['id'];
$status = "Sudah Diupdate";

// Lakukan validasi data
if (empty($id_permintaan_update)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data pesan berdasarkan id_permintaan_update
$query = "UPDATE permintaan_update 
          SET status = '$status' 
          WHERE id_permintaan_update = '$id_permintaan_update'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
