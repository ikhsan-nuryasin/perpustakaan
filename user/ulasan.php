<?php
session_start();
include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id'];
    $book_id = $_POST['book_id'];
    $rating  = $_POST['rating'];
    $komentar= $_POST['komentar'];

    $query = "INSERT INTO ulasan (user_id, book_id, rating, komentar) 
              VALUES ('$user_id', '$book_id', '$rating', '$komentar')";
    mysqli_query($conn, $query);

    echo "Ulasan berhasil ditambahkan!";
}
?>

<form method="POST">
  Book ID: <input type="text" name="book_id" required><br>
  Rating (1-5): <input type="number" name="rating" min="1" max="5" required><br>
  Komentar: <textarea name="komentar"></textarea><br>
  <button type="submit">Kirim Ulasan</button>
</form>
