<?php
session_start();
if ($_SESSION['role'] != 'admin') header('location:../../login.php');
include '../koneksi.php';

$success = '';
$error = '';

if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'petugas';

$stmt_check = mysqli_prepare($conn, "SELECT id FROM users WHERE username=? OR email=?");
        mysqli_stmt_bind_param($stmt_check, "ss", $username, $email);
        mysqli_stmt_execute($stmt_check);
        if(mysqli_stmt_num_rows(mysqli_stmt_get_result($stmt_check)) > 0){
            $error = 'Username atau email sudah terdaftar!';
        } else {
            $stmt_insert = mysqli_prepare($conn, "INSERT INTO users (username, email, password, role) VALUES(?,?,?,?)");
            mysqli_stmt_bind_param($stmt_insert, "ssss", $username, $email, $password, $role);
            if(mysqli_stmt_execute($stmt_insert)){
                $success = 'Petugas berhasil ditambahkan!';
                $_POST = []; // Reset form
            } else {
                $error = 'Error: ' . mysqli_error($conn);
            }
        }
}
?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Tambah Petugas'; $icon = 'user-tie'; $content_title = 'Tambah Petugas Baru'; ?>

    <?php if($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <form method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-user-tie me-2 text-success"></i>Username Petugas
                    </label>
                    <input type="text" class="form-control" name="username" value="<?php echo $_POST['username'] ?? ''; ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-envelope me-2 text-success"></i>Email
                    </label>
                    <input type="email" class="form-control" name="email" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label fw-bold">
                <i class="fas fa-lock me-2 text-success"></i>Password
            </label>
            <input type="password" class="form-control" name="password" placeholder="Minimal 6 karakter" required>
        </div>
        <div class="d-flex gap-3">
            <button type="submit" name="submit" class="btn btn-success">
                <i class="fas fa-save me-2"></i>Simpan Petugas
            </button>
            <a href="petugas.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </form>

<?php include '../assets/layout_footer.php'; ?>
