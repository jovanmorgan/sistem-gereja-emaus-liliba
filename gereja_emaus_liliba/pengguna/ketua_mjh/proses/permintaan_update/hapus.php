<?php
include '../../../../keamanan/koneksi.php';

// Terima ID permintaan_update yang akan dihapus dari formulir HTML
$id_permintaan_update = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_permintaan_update)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data permintaan_update berdasarkan ID
$query_delete_permintaan_update = "DELETE FROM permintaan_update WHERE id_permintaan_update = '$id_permintaan_update'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_permintaan_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
