<?php
$host = "localhost";
$user = "root"; // default XAMPP
$pass = "";     // default XAMPP kosong
$db   = "perpustakaan";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
