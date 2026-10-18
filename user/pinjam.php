<?php
session_start();
include("../config/db.php");

$user_id = $_SESSION['id'];
$book_id = $_GET['id'];

$query = "INSERT INTO peminjaman (user_id, book_id, tanggal_pinjam, status) 
          VALUES ('$user_id', '$book_id', CURDATE(), 'dipinjam')";
mysqli_query($conn, $query);

mysqli_query($conn, "UPDATE books SET stok = stok - 1 WHERE id='$book_id'");

echo "Buku berhasil dipinjam. <a href='dashboard.php'>Kembali</a>";
?>
