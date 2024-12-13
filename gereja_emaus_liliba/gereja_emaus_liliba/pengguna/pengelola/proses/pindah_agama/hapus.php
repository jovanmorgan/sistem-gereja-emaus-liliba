<?php
include '../../../../keamanan/koneksi.php';

// Terima ID pindah_agama yang akan dihapus dari formulir HTML
$id_pindah_agama = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_pindah_agama)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data pindah_agama berdasarkan ID
$query_delete_pindah_agama = "DELETE FROM pindah_agama WHERE id_pindah_agama = '$id_pindah_agama'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_pindah_agama)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);