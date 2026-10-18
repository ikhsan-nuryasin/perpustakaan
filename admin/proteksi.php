<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("location:../../login.php");
    exit();
}
include '../koneksi.php';
?>

