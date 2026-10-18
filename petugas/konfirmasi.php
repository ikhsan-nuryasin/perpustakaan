<?php include 'proteksi.php'; ?>

<?php
$id = (int)$_GET['id'];
$buku_id = (int)$_GET['buku'];

// Validate peminjaman exists and status
$stmt = mysqli_prepare($conn, "SELECT * FROM peminjaman WHERE id=? AND status='menunggu_konfirmasi'");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
if(mysqli_stmt_num_rows(mysqli_stmt_get_result($stmt)) == 0){
    $_SESSION['error_message'] = 'Peminjaman tidak valid atau sudah dikonfirmasi!';
    header("location:transaksi.php");
    exit();
}

// Update status to dikembalikan
$stmt = mysqli_prepare($conn, "UPDATE peminjaman SET status='dikembalikan', tanggal_kembali_real=NOW() WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

// Return stock +1
$stmt = mysqli_prepare($conn, "UPDATE buku SET stok = stok + 1 WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $buku_id);
mysqli_stmt_execute($stmt);

$_SESSION['success_message'] = 'Peminjaman berhasil dikonfirmasi dan stok dikembalikan!';
header("location:transaksi.php");
exit();
?>
