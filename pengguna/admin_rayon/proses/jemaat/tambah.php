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

// Terima data babtis
$nama_saksi = $_POST['nama_saksi'];
$pelayanan_babtis = $_POST['pelayanan'];
$tanggal_babtis = $_POST['tanggal_babtis'];
$tempat_babtis = $_POST['tempat'];

// Terima data sidi
$gereja = $_POST['gereja'];
$pelayanan_sidi = $_POST['pelayanan'];
$tanggal_sidi = $_POST['tanggal_sidi'];
$tempat_sidi = $_POST['tempat'];

// Terima data nikah
$tempat_nikah = $_POST['tempat_nikah'];
$pelayanan_nikah = $_POST['pelayanan'];
$tanggal_nikah = $_POST['tanggal_nikah'];
$saksi_nikah = $_POST['saksi_nikah'];

// Buat query SQL untuk menambahkan data jemaat ke dalam database
$query = "INSERT INTO jemaat (id_rayon, id_kk, nama, nik, jk, tempat_lahir, tanggal_lahir, status_dalam_rumah, gol_darah, suku, status_marital, status_babtis, pendidikan_terakhir, pekerjaan, penghasilan, status_tempat_rumah, status_sidi, status_nikah, keper_setaan, jenis_bantuan_sosial, jenis_diakonia, keterangan) 
          VALUES ('$id_rayon', '$id_kk', '$nama', '$nik', '$jk', '$tempat_lahir', '$tanggal_lahir', '$status_dalam_rumah', '$gol_darah', '$suku', '$status_marital', '$status_babtis', '$pendidikan_terakhir', '$pekerjaan', '$penghasilan', '$status_tempat_rumah', '$status_sidi', '$status_nikah', '$keper_setaan', '$jenis_bantuan_sosial', '$jenis_diakonia', '$keterangan')";

// Jalankan query untuk jemaat
if (mysqli_query($koneksi, $query)) {
    // Ambil ID jemaat yang baru ditambahkan
    $id_jemaat = mysqli_insert_id($koneksi);

    // Proses data babtis hanya jika status_babtis adalah 'Sudah' dan data babtis tidak kosong
    if ($status_babtis == 'Sudah' && !empty($nama_saksi) && !empty($pelayanan_babtis) && !empty($tanggal_babtis) && !empty($tempat_babtis)) {
        $query_babtis = "INSERT INTO babtis (id_jemaat, nama_saksi, pelayanan, tanggal_babtis, tempat) 
                         VALUES ('$id_jemaat', '$nama_saksi', '$pelayanan_babtis', '$tanggal_babtis', '$tempat_babtis')";

        // Jalankan query untuk babtis
        if (!mysqli_query($koneksi, $query_babtis)) {
            echo "Error babtis: " . mysqli_error($koneksi);
            exit; // Hentikan eksekusi jika ada error pada babtis
        }
    }

    // Proses data sidi hanya jika status_sidi adalah 'Sudah' dan data sidi tidak kosong
    if ($status_sidi == 'Sudah' && !empty($gereja) && !empty($pelayanan_sidi) && !empty($tanggal_sidi) && !empty($tempat_sidi)) {
        $query_sidi = "INSERT INTO sidi (id_jemaat, gereja, pelayanan, tanggal_sidi, tempat) 
                       VALUES ('$id_jemaat', '$gereja', '$pelayanan_sidi', '$tanggal_sidi', '$tempat_sidi')";

        // Jalankan query untuk sidi
        if (!mysqli_query($koneksi, $query_sidi)) {
            echo "Error sidi: " . mysqli_error($koneksi);
            exit; // Hentikan eksekusi jika ada error pada sidi
        }
    }

    // Proses data nikah hanya jika status_nikah adalah 'Sudah' dan data nikah tidak kosong
    if ($status_nikah == 'Sudah' && !empty($tempat_nikah) && !empty($pelayanan_nikah) && !empty($tanggal_nikah) && !empty($saksi_nikah)) {
        $query_nikah = "INSERT INTO nikah (id_jemaat, tempat_nikah, pelayanan, tanggal_nikah, saksi_nikah) 
                        VALUES ('$id_jemaat', '$tempat_nikah', '$pelayanan_nikah', '$tanggal_nikah', '$saksi_nikah')";

        // Jalankan query untuk nikah
        if (!mysqli_query($koneksi, $query_nikah)) {
            echo "Error nikah: " . mysqli_error($koneksi);
            exit; // Hentikan eksekusi jika ada error pada nikah
        }
    }

    // Jika semua proses berhasil, kirim satu respon success
    echo "success";
} else {
    echo "Error: " . mysqli_error($koneksi);
    exit; // Hentikan eksekusi jika ada error pada jemaat
}

// Tutup koneksi ke database
mysqli_close($koneksi);
