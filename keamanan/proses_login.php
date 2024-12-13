<?php
include 'koneksi.php';

function checkpenggunahType($username)
{
    global $koneksi;
    $query_admin = "SELECT * FROM admin WHERE username = '$username'";
    $query_admin_rayon = "SELECT * FROM admin_rayon WHERE username = '$username'";
    $query_pengelola = "SELECT * FROM pengelola WHERE username = '$username'";
    $query_ketua_mjh = "SELECT * FROM ketua_mjh WHERE username = '$username'";

    $result_admin = mysqli_query($koneksi, $query_admin);
    $result_admin_rayon = mysqli_query($koneksi, $query_admin_rayon);
    $result_pengelola = mysqli_query($koneksi, $query_pengelola);
    $result_ketua_mjh = mysqli_query($koneksi, $query_ketua_mjh);

    if (mysqli_num_rows($result_admin) > 0) {
        return "admin";
    } elseif (mysqli_num_rows($result_admin_rayon) > 0) {
        return "admin_rayon";
    } elseif (mysqli_num_rows($result_pengelola) > 0) {
        return "pengelola";
    } elseif (mysqli_num_rows($result_ketua_mjh) > 0) {
        return "ketua_mjh";
    } else {
        return "not_found";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan validasi data
    if (empty($username) && empty($password)) {
        echo "tidak_ada_data";
        exit();
    }
    if (empty($username)) {
        echo "username_tidak_ada";
        exit();
    }

    if (empty($password)) {
        echo "password_tidak_ada";
        exit();
    }


    $penggunahType = checkpenggunahType($username);
    if ($penggunahType !== "not_found") {
        $query_penggunah = "SELECT * FROM $penggunahType WHERE username = '$username'";
        $result_penggunah = mysqli_query($koneksi, $query_penggunah);

        if (mysqli_num_rows($result_penggunah) > 0) {
            $row = mysqli_fetch_assoc($result_penggunah);
            $hashed_password = $row['password'];

            if ($password === $hashed_password) {

                // Process login for other penggunah types
                session_start();
                $_SESSION['username'] = $username;

                switch ($penggunahType) {
                    case "admin":
                        $_SESSION['id_admin'] = $row['id_admin'];
                        break;
                    case "admin_rayon":
                        $_SESSION['id_admin_rayon'] = $row['id_admin_rayon'];
                        $id_admin_rayon = $row['id_admin_rayon'];
                        break;
                    case "pengelola":
                        $_SESSION['id_pengelola'] = $row['id_pengelola'];
                        break;
                    case "ketua_mjh":
                        $_SESSION['id_ketua_mjh'] = $row['id_ketua_mjh'];
                        break;
                    default:
                        break;
                }

                // Success response
                switch ($penggunahType) {
                    case "admin":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/admin/";
                        break;
                    case "admin_rayon":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/admin_rayon/";
                        break;
                    case "pengelola":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/pengelola/";
                        break;
                    case "ketua_mjh":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/ketua_mjh/";
                        break;
                    default:
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../berlangganan/login";
                        break;
                }
            } else {
                echo "error_password";
            }
        } else {
            echo "error_username";
        }
    } else {
        echo "error_username";
    }
}
