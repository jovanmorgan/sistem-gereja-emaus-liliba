<?php
include '../../../../keamanan/koneksi.php';

// Terima ID admin_rayon yang akan dihapus dari formulir HTML
$id_admin_rayon = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_admin_rayon)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data admin_rayon berdasarkan ID
$query_delete_admin_rayon = "DELETE FROM admin_rayon WHERE id_admin_rayon = '$id_admin_rayon'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_admin_rayon)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
