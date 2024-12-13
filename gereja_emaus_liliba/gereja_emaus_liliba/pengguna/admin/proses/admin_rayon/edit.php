<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_admin_rayon = $_POST['id_admin_rayon'];
$id_rayon = $_POST['id_rayon'];
$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];

// Lakukan validasi data
if (empty($nama) || empty($username) || empty($password)) {
    echo "data_tidak_lengkap";
    exit();
}

// Cek apakah username sudah ada di database
$check_query = "SELECT * FROM admin WHERE username = '$username'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}
// Cek apakah username sudah ada di database
$check_query_ketua_mjh = "SELECT * FROM ketua_mjh WHERE username = '$username'";
$result_ketua_mjh = mysqli_query($koneksi, $check_query_ketua_mjh);
if (mysqli_num_rows($result_ketua_mjh) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}
// Cek apakah username sudah ada di database
$check_query_admin_rayon = "SELECT * FROM admin_rayon WHERE username = '$username' AND id_admin_rayon != '$id_admin_rayon'";
$result_admin_rayon = mysqli_query($koneksi, $check_query_admin_rayon);
if (mysqli_num_rows($result_admin_rayon) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}
// Cek apakah username sudah ada di database
$check_query_admin_rayon = "SELECT * FROM admin_rayon WHERE id_rayon = '$id_rayon' AND id_rayon != '$id_rayon'";
$result_admin_rayon = mysqli_query($koneksi, $check_query_admin_rayon);
if (mysqli_num_rows($result_admin_rayon) > 0) {
    echo "id_data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}

// Cek apakah username sudah ada di database
$check_query_pengelola = "SELECT * FROM pengelola WHERE username = '$username'";
$result_pengelola = mysqli_query($koneksi, $check_query_pengelola);
if (mysqli_num_rows($result_pengelola) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}


if (strlen($password) < 8) {
    echo "error_password_length"; // Kirim respon jika panjang password kurang dari 8 karakter
    exit();
}

// Tambahkan logika untuk memeriksa password
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $password)) {
    echo "error_password_strength"; // Kirim respon jika password tidak memenuhi syarat
    exit();
}

// Buat query SQL untuk mengedit data admin_rayon yang sudah ada berdasarkan id_admin_rayon
$query = "UPDATE admin_rayon 
            SET nama = '$nama', 
                username = '$username',
                password = '$password'
          WHERE id_admin_rayon = '$id_admin_rayon'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
