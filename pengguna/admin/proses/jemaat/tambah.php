<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form tambah
$id_rayon = $_POST['id_rayon'];
$id_kk = $_POST['id_kk'];
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$jk = $_POST['jk'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$status_dalam_rumah = $_POST['status_dalam_rumah'];
$gol_darah = $_POST['gol_darah'];
$suku = $_POST['suku'];
$status_marital = $_POST['status_marital'];
$status_babtis = $_POST['status_babtis'];
$pendidikan_terakhir = $_POST['pendidikan_terakhir'];
$pekerjaan = $_POST['pekerjaan'];
$penghasilan = $_POST['penghasilan'];
$status_tempat_rumah = $_POST['status_tempat_rumah'];
$status_sidi = $_POST['status_sidi'];
$status_nikah = $_POST['status_nikah'];
$keper_setaan = $_POST['keper_setaan'];
$jenis_bantuan_sosial = $_POST['jenis_bantuan_sosial'];
$jenis_diakonia = $_POST['jenis_diakonia'];
$keterangan = $_POST['keterangan'];


// Buat query SQL untuk menambahkan data jemaat ke dalam database
$query = "INSERT INTO jemaat (id_rayon, id_kk, nama, nik, jk, tempat_lahir, tanggal_lahir, status_dalam_rumah, gol_darah, suku, status_marital, status_babtis, pendidikan_terakhir, pekerjaan, penghasilan, status_tempat_rumah, status_sidi, status_nikah, keper_setaan, jenis_bantuan_sosial, jenis_diakonia, keterangan) 
          VALUES ('$id_rayon', '$id_kk', '$nama', '$nik', '$jk', '$tempat_lahir', '$tanggal_lahir', '$status_dalam_rumah', '$gol_darah', '$suku', '$status_marital', '$status_babtis', '$pendidikan_terakhir', '$pekerjaan', '$penghasilan', '$status_tempat_rumah', '$status_sidi', '$status_nikah', '$keper_setaan', '$jenis_bantuan_sosial', '$jenis_diakonia', '$keterangan')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
