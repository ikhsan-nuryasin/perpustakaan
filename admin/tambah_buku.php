<?php
session_start();
if ($_SESSION['role'] != 'admin') header('location:../../login.php');
include '../koneksi.php';

$success = '';
$error = '';

if(isset($_POST['submit'])){
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $stok = (int)$_POST['stok'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

$stmt_insert = mysqli_prepare($conn, "INSERT INTO buku (judul, penulis, penerbit, tahun, stok, deskripsi) VALUES(?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt_insert, "sssisi", $judul, $penulis, $penerbit, $tahun, $stok, $deskripsi);
        if(mysqli_stmt_execute($stmt_insert)){
            $success = 'Buku berhasil ditambahkan!';
            $_POST = []; // Reset form
        } else {
            $error = 'Error: ' . mysqli_error($conn);
        }
}
?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Tambah Buku'; $icon = 'book'; $content_title = 'Tambah Buku Baru'; ?>

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

    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8">
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-heading me-2 text-info"></i>Judul Buku
                    </label>
                    <input type="text" class="form-control" name="judul" value="<?php echo $_POST['judul'] ?? ''; ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-user me-2 text-info"></i>Penulis
                            </label>
                            <input type="text" class="form-control" name="penulis" value="<?php echo $_POST['penulis'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-building me-2 text-info"></i>Penerbit
                            </label>
                            <input type="text" class="form-control" name="penerbit" value="<?php echo $_POST['penerbit'] ?? ''; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar me-2 text-info"></i>Tahun Terbit
                            </label>
                            <input type="number" class="form-control" name="tahun" value="<?php echo $_POST['tahun'] ?? ''; ?>" min="1900" max="2025" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-layer-group me-2 text-info"></i>Stok
                            </label>
                            <input type="number" class="form-control" name="stok" value="<?php echo $_POST['stok'] ?? ''; ?>" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-align-left me-2 text-info"></i>Deskripsi
                    </label>
                    <textarea class="form-control" name="deskripsi" rows="4"><?php echo $_POST['deskripsi'] ?? ''; ?></textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-image fa-4x text-muted mb-3"></i>
                        <h6>Upload Cover Buku</h6>
                        <input type="file" class="form-control mt-2" name="cover" accept="image/*">
                        <small class="text-muted">Format JPG/PNG, max 2MB</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex gap-3 mt-4">
            <button type="submit" name="submit" class="btn btn-info">
                <i class="fas fa-save me-2"></i>Simpan Buku
            </button>
            <a href="buku.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </form>

<?php include '../assets/layout_footer.php'; ?>
