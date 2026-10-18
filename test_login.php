<?php
include 'koneksi.php';
$username = 'admin';
$password = 'admin123';

$stmt = mysqli_prepare($conn, "SELECT id, username, role, password FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

echo "User found: " . ($user ? 'YES' : 'NO') . "<br>";
if ($user) {
    echo "Role: " . $user['role'] . "<br>";
    echo "Password hash: " . substr($user['password'], 0, 20) . "...<br>";
    $bcrypt_ok = password_verify($password, $user['password']);
    $md5_ok = md5($password) === $user['password'];
    echo "bcrypt verify: " . ($bcrypt_ok ? 'YES' : 'NO') . "<br>";
    echo "md5 match: " . ($md5_ok ? 'YES' : 'NO') . "<br>";
    echo "Would login: " . (($bcrypt_ok || $md5_ok) ? 'YES' : 'NO') . "<br>";
} else {
    $users = mysqli_query($conn, "SELECT username, role FROM users");
    echo "<br>Available users:<br>";
    while ($u = mysqli_fetch_assoc($users)) {
        echo "- " . $u['username'] . " (" . $u['role'] . ")<br>";
    }
}
mysqli_close($conn);
?>

