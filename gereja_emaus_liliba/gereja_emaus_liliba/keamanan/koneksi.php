<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "gel";

$koneksi = mysqli_connect($host, $user, $pass, database: $db);

if (!$koneksi) {
	die("Koneksi Gagal:" . mysqli_connect_error());
}
