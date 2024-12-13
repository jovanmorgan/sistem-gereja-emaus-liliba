<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form tambah
$pesan = $_POST['pesan'];
$tanggal = $_POST['tanggal'];
$status = "Belum Diupdate";

// Lakukan validasi data
if (empty($pesan) || empty($tanggal)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data pesan ke dalam database
$query = "INSERT INTO permintaan_update (pesan, tanggal, status) 
          VALUES ('$pesan', '$tanggal', '$status')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
