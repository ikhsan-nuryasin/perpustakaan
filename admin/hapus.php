<?php
session_start();
if ($_SESSION['role'] != "admin") {
    header("location:../../login.php");
}
include '../../koneksi.php';

$id = (int)$_GET['id'];
$type = $_GET['type'] ?? '';

switch($type){
    case "user":
        $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id=? AND role=?");
        mysqli_stmt_bind_param($stmt, "is", $id, "user");
        break;
    case "petugas":
        $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id=? AND role=?");
        mysqli_stmt_bind_param($stmt, "is", $id, "petugas");
        break;
    case "buku":
        $stmt = mysqli_prepare($conn, "DELETE FROM buku WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        break;
    default:
        $_SESSION['error_message'] = 'Tipe data tidak valid!';
        header("location: dashboard.php");
        exit();
}

if(mysqli_stmt_execute($stmt)){
    $_SESSION['success_message'] = 'Data berhasil dihapus!';
} else {
    $_SESSION['error_message'] = 'Error menghapus data!';
}

$from = $_GET['from'] ?? 'dashboard.php';
header("location: " . $from);
exit();
?>

