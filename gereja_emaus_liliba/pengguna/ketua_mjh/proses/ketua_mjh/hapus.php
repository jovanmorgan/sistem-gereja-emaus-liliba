<?php
include '../../../../keamanan/koneksi.php';

// Terima ID ketua_mjh yang akan dihapus dari formulir HTML
$id_ketua_mjh = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_ketua_mjh)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data ketua_mjh berdasarkan ID
$query_delete_ketua_mjh = "DELETE FROM ketua_mjh WHERE id_ketua_mjh = '$id_ketua_mjh'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_ketua_mjh)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
