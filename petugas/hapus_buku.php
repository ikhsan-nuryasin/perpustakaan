<?php include 'proteksi.php'; ?>

<?php
$id = (int)$_GET['id'];

$stmt = mysqli_prepare($conn, "DELETE FROM buku WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
if(mysqli_stmt_execute($stmt)){
    $_SESSION['success_message'] = 'Buku berhasil dihapus!';
} else {
    $_SESSION['error_message'] = 'Error menghapus buku!';
}

header("location:buku.php");
exit();
?>
