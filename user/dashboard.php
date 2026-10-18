<?php
session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: ../login.php");
}
include("../config/db.php");

$result = mysqli_query($conn, "SELECT * FROM books");
?>

<h2>Katalog Buku</h2>
<table border="1">
<tr><th>Judul</th><th>Penulis</th><th>Tahun</th><th>Stok</th><th>Aksi</th></tr>
<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
  <td><?= $row['judul'] ?></td>
  <td><?= $row['penulis'] ?></td>
  <td><?= $row['tahun'] ?></td>
  <td><?= $row['stok'] ?></td>
  <td><a href="pinjam.php?id=<?= $row['id'] ?>">Pinjam</a></td>
</tr>
<?php } ?>
</table>
