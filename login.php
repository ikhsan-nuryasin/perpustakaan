<?php
session_start();
include 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = 'Semua field wajib diisi!';
    } else {

        $stmt = mysqli_prepare($conn, "SELECT id, username, role, password FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {

            $db_pass = $user['password'];
            $valid = false;

            // 🔥 HANDLE SEMUA FORMAT PASSWORD
            if ($db_pass === $password) {
                $valid = true; // plain
            } elseif ($db_pass === md5($password)) {
                $valid = true; // md5
            } elseif (password_verify($password, $db_pass)) {
                $valid = true; // bcrypt
            }

            if ($valid) {

                session_regenerate_id(true);

                $_SESSION['id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['username'];

                if ($user['role'] == 'admin') {
                    header("Location: admin/dashboard.php");
                } elseif ($user['role'] == 'petugas') {
                    header("Location: petugas/dashboard.php");
                } else {
                    header("Location: user/dashboard.php");
                }
                exit;
            }
        }

        $error = "Username atau password salah!";
    }
}
?>