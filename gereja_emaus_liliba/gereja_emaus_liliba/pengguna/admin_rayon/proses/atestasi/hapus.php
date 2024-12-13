<?php
include '../../../../keamanan/koneksi.php';

// Terima ID atestasi yang akan dihapus dari formulir HTML
$id_atestasi = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_atestasi)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data atestasi berdasarkan ID
$query_delete_atestasi = "DELETE FROM atestasi WHERE id_atestasi = '$id_atestasi'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_atestasi)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
