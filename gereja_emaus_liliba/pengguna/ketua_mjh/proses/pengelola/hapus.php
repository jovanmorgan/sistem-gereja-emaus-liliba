<?php
include '../../../../keamanan/koneksi.php';

// Terima ID pengelola yang akan dihapus dari formulir HTML
$id_pengelola = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_pengelola)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data pengelola berdasarkan ID
$query_delete_pengelola = "DELETE FROM pengelola WHERE id_pengelola = '$id_pengelola'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_pengelola)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
