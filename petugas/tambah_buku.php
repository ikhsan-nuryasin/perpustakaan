<?php include 'proteksi.php'; ?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Tambah Buku Petugas'; $icon = 'plus-square'; $content_title = 'Tambah Buku Baru'; ?>

    <?php if(isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-triangle me-2"></i><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8">
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-heading me-2 text-primary"></i>Judul Buku
                    </label>
                    <input type="text" class="form-control" name="judul" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-user me-2 text-primary"></i>Penulis
                    </label>
                    <input type="text" class="form-control" name="penulis" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-layer-group me-2 text-primary"></i>Stok
                            </label>
                            <input type="number" class="form-control" name="stok" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-file-pdf me-2 text-danger"></i>File PDF
                            </label>
                            <input type="file" class="form-control" name="file" accept=".pdf" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-2"></i>Petunjuk
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>File PDF max 10MB</li>
                            <li><i class="fas fa-check text-success me-2"></i>Judul & penulis jelas</li>
                            <li><i class="fas fa-check text-success me-2"></i>Stok sesuai ketersediaan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex gap-3">
            <button type="submit" name="submit" class="btn btn-primary">
                <i class="fas fa-upload me-2"></i>Upload Buku
            </button>
            <a href="buku.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </form>

<?php include '../assets/layout_footer.php'; ?>

<?php
if(isset($_POST['submit'])){
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $stok = (int)$_POST['stok'];

    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if($file_ext == 'pdf' && $_FILES['file']['size'] < 10000000){ // 10MB
        $new_name = uniqid() . '.pdf';
        if(move_uploaded_file($file_tmp, "../assets/pdf/" . $new_name)){
            $stmt = mysqli_prepare($conn, "INSERT INTO buku (judul, penulis, stok, file) VALUES(?,?,?,?)");
            mysqli_stmt_bind_param($stmt, "ssis", $judul, $penulis, $stok, $new_name);
            if(mysqli_stmt_execute($stmt)){
                $_SESSION['success_message'] = 'Buku berhasil ditambahkan!';
            } else {
                $_SESSION['error_message'] = 'Error database!';
            }
        } else {
            $_SESSION['error_message'] = 'Error upload file!';
        }
    } else {
        $_SESSION['error_message'] = 'Hanya file PDF < 10MB!';
    }
    header("location: tambah_buku.php");
    exit();
}
?>
