<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != "petugas") {
    header("location:../login.php");
    exit();
}
include '../koneksi.php';
?>

