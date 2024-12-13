<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form edit
$id_pindah_agama = $_POST['id_pindah_agama'];
$id_jemaat = $_POST['id_jemaat'];
$agama_asal = $_POST['agama_asal'];
$agama_saat_ini = $_POST['agama_saat_ini'];
$tanggal_pindah = $_POST['tanggal_pindah'];
$saksi = $_POST['saksi'];

// Lakukan validasi data
if (empty($id_pindah_agama) || empty($id_jemaat) || empty($agama_asal) || empty($agama_saat_ini) || empty($tanggal_pindah) || empty($saksi)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data pindah_agama berdasarkan id_pindah_agama
$query = "UPDATE pindah_agama 
          SET id_jemaat = '$id_jemaat',
              agama_asal = '$agama_asal',
              agama_saat_ini = '$agama_saat_ini',
              tanggal_pindah = '$tanggal_pindah',
              saksi = '$saksi' 
          WHERE id_pindah_agama = '$id_pindah_agama'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
