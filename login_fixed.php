<?php
session_start();
include 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Semua field wajib diisi!';
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, username, role, password FROM users WHERE username = ?");
        if (!$stmt) {
            $error = 'DB prepare error: ' . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            if (!mysqli_stmt_execute($stmt)) {
                $error = 'DB execute error: ' . mysqli_stmt_error($stmt);
            } else {
                $result = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_assoc($result);
                
                if ($user && (password_verify($password, $user['password']) || md5($password) === $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['name'] = $user['username'];
                    
                    // Debug sessions
                    error_log("LOGIN SUCCESS: " . $username . " role=" . $user['role']);
                    
                    if ($user['role'] == 'admin') header("Location: admin/dashboard.php");
                    elseif ($user['role'] == 'petugas') header("Location: petugas/dashboard.php");
                    else header("Location: user/dashboard.php");
                    exit();
                } else {
                    error_log("LOGIN FAIL: $username pass verify failed");
                    $error = 'Username atau password salah!';
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Fixed - Perpustakaan</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="bg-gradient min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-card p-4 p-md-5 shadow-lg">
                    <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control" name="username" value="admin" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control" name="password" value="admin123" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <hr class="my-4">
                    <div class="text-center">
                        <a href="login.php" class="btn btn-outline-secondary">Original Login</a>
                        <a href="test_login.php" class="btn btn-outline-info ms-2">Test DB</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
