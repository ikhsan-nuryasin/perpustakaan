<?php include 'proteksi.php'; ?>

<?php
$id = (int)$_GET['id'];

// Check ownership
$stmt = mysqli_prepare($conn, "SELECT * FROM peminjaman WHERE id=? AND user_id=? AND status='dipinjam'");
mysqli_stmt_bind_param($stmt, "ii", $id, $_SESSION['id']);
mysqli_stmt_execute($stmt);
if(mysqli_stmt_num_rows(mysqli_stmt_get_result($stmt)) == 0){
    $_SESSION['error_message'] = 'Peminjaman tidak ditemukan atau sudah dikembalikan!';
    header("location:koleksi.php");
    exit();
}

// Update to menunggu_konfirmasi
$stmt = mysqli_prepare($conn, "UPDATE peminjaman SET status='menunggu_konfirmasi' WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
if(mysqli_stmt_execute($stmt)){
    $_SESSION['success_message'] = 'Permintaan pengembalian dikirim! Menunggu konfirmasi petugas.';
} else {
    $_SESSION['error_message'] = 'Error mengirim permintaan!';
}

header("location:koleksi.php");
exit();
?>
