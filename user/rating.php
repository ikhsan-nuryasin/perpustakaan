<?php include 'proteksi.php'; ?>

<?php
$id = (int)$_GET['id'];
$buku_id = (int)$_GET['buku'];
$user_id = $_SESSION['id'];

// Verify ownership and status
$stmt = mysqli_prepare($conn, "SELECT * FROM peminjaman WHERE id=? AND user_id=? AND status='dikembalikan' AND rating_status='belum'");
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
mysqli_stmt_execute($stmt);
if(mysqli_stmt_num_rows(mysqli_stmt_get_result($stmt)) == 0){
    $_SESSION['error_message'] = 'Tidak dapat memberi rating atau sudah dirating!';
    header("location:koleksi.php");
    exit();
}

if(isset($_POST['submit'])){
    $rating = (int)$_POST['rating'];
    $komentar = trim($_POST['komentar']);
    
    if($rating < 1 || $rating > 5){
        $error = 'Rating harus 1-5 bintang!';
    } elseif(strlen($komentar) > 500){
        $error = 'Komentar terlalu panjang!';
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO rating (user_id, buku_id, rating, komentar, tanggal) VALUES(?,?,?,?,NOW())");
        mysqli_stmt_bind_param($stmt, "iisi", $user_id, $buku_id, $rating, $komentar);
        if(mysqli_stmt_execute($stmt)){
            // Update peminjaman status
            $stmt = mysqli_prepare($conn, "UPDATE peminjaman SET rating_status='sudah' WHERE id=?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            
            $_SESSION['success_message'] = 'Rating berhasil dikirim! Terima kasih.';
            header("location:koleksi.php");
            exit();
        } else {
            $error = 'Error menyimpan rating!';
        }
    }
}
?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Beri Rating'; $icon = 'star'; $content_title = 'Nilai Buku'; ?>

    <?php if(isset($error)): ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-star me-2 text-warning"></i>Berikan Rating Anda</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Rating Bintang</label>
                            <select class="form-select" name="rating" required>
                                <option value="">Pilih rating</option>
                                <option value="5">⭐⭐⭐⭐⭐ (5/5) Sangat Bagus</option>
                                <option value="4">⭐⭐⭐⭐ (4/5) Bagus</option>
                                <option value="3">⭐⭐⭐ (3/5) Lumayan</option>
                                <option value="2">⭐⭐ (2/5) Kurang</option>
                                <option value="1">⭐ (1/5) Buruk</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Komentar (Opsional)</label>
                            <textarea class="form-control" name="komentar" rows="5" maxlength="500" placeholder="Bagikan pendapat Anda tentang buku ini..."></textarea>
                            <div class="form-text">Maksimal 500 karakter</div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" name="submit" class="btn btn-warning">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Rating
                            </button>
                            <a href="koleksi.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include '../assets/layout_footer.php'; ?>
