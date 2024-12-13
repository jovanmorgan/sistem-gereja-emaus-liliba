<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form edit
$id_jemaat = $_POST['id_jemaat']; // ID data yang akan diedit
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

// Lakukan validasi data
if (empty($id_jemaat) || empty($id_rayon) || empty($id_kk) || empty($nama) || empty($nik) || empty($jk) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($status_dalam_rumah) || empty($gol_darah) || empty($suku) || empty($status_marital) || empty($status_babtis) || empty($pendidikan_terakhir) || empty($pekerjaan) || empty($penghasilan) || empty($status_tempat_rumah) || empty($status_sidi) || empty($status_nikah) || empty($keper_setaan) || empty($jenis_bantuan_sosial) || empty($jenis_diakonia) || empty($keterangan)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data jemaat di dalam database
$query = "UPDATE jemaat 
          SET id_rayon = '$id_rayon', 
              id_kk = '$id_kk', 
              nama = '$nama', 
              nik = '$nik', 
              jk = '$jk', 
              tempat_lahir = '$tempat_lahir', 
              tanggal_lahir = '$tanggal_lahir', 
              status_dalam_rumah = '$status_dalam_rumah', 
              gol_darah = '$gol_darah', 
              suku = '$suku', 
              status_marital = '$status_marital', 
              status_babtis = '$status_babtis', 
              pendidikan_terakhir = '$pendidikan_terakhir', 
              pekerjaan = '$pekerjaan', 
              penghasilan = '$penghasilan', 
              status_tempat_rumah = '$status_tempat_rumah', 
              status_sidi = '$status_sidi', 
              status_nikah = '$status_nikah', 
              keper_setaan = '$keper_setaan', 
              jenis_bantuan_sosial = '$jenis_bantuan_sosial', 
              jenis_diakonia = '$jenis_diakonia', 
              keterangan = '$keterangan' 
          WHERE id_jemaat = '$id_jemaat'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
