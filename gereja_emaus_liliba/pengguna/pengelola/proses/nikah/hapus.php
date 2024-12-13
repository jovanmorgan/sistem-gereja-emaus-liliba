<?php
include '../../../../keamanan/koneksi.php';

// Terima ID nikah yang akan dihapus dari formulir HTML
$id_nikah = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_nikah)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data nikah berdasarkan ID
$query_delete_nikah = "DELETE FROM nikah WHERE id_nikah = '$id_nikah'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_nikah)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
