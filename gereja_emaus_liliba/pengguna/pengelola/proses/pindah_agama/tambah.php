<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form tambah
$id_jemaat = $_POST['id_jemaat'];
$agama_asal = $_POST['agama_asal'];
$agama_saat_ini = $_POST['agama_saat_ini'];
$tanggal_pindah = $_POST['tanggal_pindah'];
$saksi = $_POST['saksi'];

// Lakukan validasi data
if (empty($id_jemaat) || empty($agama_asal) || empty($agama_saat_ini) || empty($tanggal_pindah) || empty($saksi)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data pindah_agama ke dalam database
$query = "INSERT INTO pindah_agama (id_jemaat, agama_asal, agama_saat_ini, tanggal_pindah, saksi) 
          VALUES ('$id_jemaat', '$agama_asal', '$agama_saat_ini', '$tanggal_pindah', '$saksi')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
