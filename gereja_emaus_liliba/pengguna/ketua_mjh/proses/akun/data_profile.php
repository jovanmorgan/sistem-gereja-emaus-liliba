<?php
// Lakukan koneksi ke database
include '../../../../keamanan/koneksi.php';

// Cek apakah terdapat data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui form
    $id_ketua_mjh = $_POST['id_ketua_mjh'];
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    // Lakukan validasi data
    if (empty($nama) || empty($password)) {
        echo "data tidak lengkap";
        exit();
    }
    // Cek apakah username sudah ada di database
    $check_query = "SELECT * FROM ketua_mjh WHERE username = '$username' AND id_ketua_mjh != '$id_ketua_mjh'";
    $result = mysqli_query($koneksi, $check_query);
    if (mysqli_num_rows($result) > 0) {
        echo "error_username_exists"; // Kirim respon "error_username_exists" jika email sudah terdaftar
        exit();
    }

    // Cek apakah username sudah ada di database
    $check_query_admin = "SELECT * FROM admin WHERE username = '$username'";
    $result_admin = mysqli_query($koneksi, $check_query_admin);
    if (mysqli_num_rows($result_admin) > 0) {
        echo "error_username_exists"; // Kirim respon "error_username_exists" jika email sudah terdaftar
        exit();
    }
    // Cek apakah username sudah ada di database
    $check_query_admin_rayon = "SELECT * FROM admin_rayon WHERE username = '$username'";
    $result_admin_rayon = mysqli_query($koneksi, $check_query_admin_rayon);
    if (mysqli_num_rows($result_admin_rayon) > 0) {
        echo "error_username_exists"; // Kirim respon "error_username_exists" jika email sudah terdaftar
        exit();
    }
    // Cek apakah username sudah ada di database
    $check_query_pengelola = "SELECT * FROM pengelola WHERE username = '$username'";
    $result_pengelola = mysqli_query($koneksi, $check_query_pengelola);
    if (mysqli_num_rows($result_pengelola) > 0) {
        echo "error_username_exists"; // Kirim respon "error_username_exists" jika email sudah terdaftar
        exit();
    }
    // Query SQL untuk update data foto profile
    $query = "UPDATE ketua_mjh SET password='$password', nama='$nama', username='$username' WHERE id_ketua_mjh='$id_ketua_mjh'";

    // Lakukan proses update data foto profile di database
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        echo "success";
        exit();
    } else {
        // Jika terjadi kesalahan saat melakukan proses update, tampilkan pesan kesalahan
        echo "Gagal melakukan proses update data foto profile: " . mysqli_error($koneksi);
    }
} else {
    // Jika metode request bukan POST, berikan respons yang sesuai
    echo "Invalid request method";
    exit();
}

// Tutup koneksi ke database
mysqli_close($koneksi);
