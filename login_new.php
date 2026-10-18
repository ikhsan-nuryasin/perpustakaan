
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
        $user = mysqli_fetch_assoc($result);
        if ($user && md5($password) === $user['password']) {
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
            exit();
        }
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login - Perpustakaan (Fixed)</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-4">
<h2>Login</h2>
<?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
<form method="POST">
<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" value="admin" required>
</div>
<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" value="admin123" required>
</div>
<button type="submit" class="btn btn-primary w-100">Login</button>
</form>
<p class="mt-3">
<a href="test_login.php">Test DB</a> | 
<a href="login.php">Original</a> | 
<a href="login_fixed.php">Advanced Fixed</a>
</p>
</div>
</div>
</div>
</body>
</html>

