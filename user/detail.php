<?php include 'proteksi.php'; ?>

<?php
$id = (int)$_GET['id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM buku WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$d = mysqli_fetch_assoc($result);

if(!$d){
    $_SESSION['error_message'] = 'Buku tidak ditemukan!';
    header("location:buku.php");
    exit();
}
?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = htmlspecialchars($d['judul']); $icon = 'book-open'; $content_title = htmlspecialchars($d['judul']); ?>

    <div class="row">
        <div class="col-md-4">
            <?php if($d['cover']): ?>
                <img src="../assets/cover/<?= htmlspecialchars($d['cover']) ?>" class="img-fluid rounded shadow" alt="<?= htmlspecialchars($d['judul']) ?>">
            <?php else: ?>
                <div class="bg-light d-flex align-items-center justify-content-center rounded shadow" style="height: 300px;">
                    <i class="fas fa-book fa-4x text-muted"></i>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title fw-bold"><?= htmlspecialchars($d['judul']) ?></h1>
                    <p class="fs-5 text-primary fw-semibold"><?= htmlspecialchars($d['penulis']) ?></p>
                    <p class="mb-1"><i class="fas fa-building me-2"></i><?= htmlspecialchars($d['penerbit'] ?? 'Tidak tercantum') ?></p>
                    <p class="mb-1"><i class="fas fa-calendar me-2"></i><?= htmlspecialchars($d['tahun'] ?? 'Tidak tercantum') ?></p>
                    <div class="mb-3">
                        <span class="badge bg-<?= $d['stok'] > 0 ? 'success' : 'danger' ?> fs-6 px-3 py-2">
                            <?= $d['stok'] ?> <?= $d['stok'] > 1 ? 'eksemplar' : 'eksemplar' ?> tersedia
                        </span>
                    </div>
                    <div class="mb-4">
                        <h6>Deskripsi:</h6>
                        <p class="text-justify"><?= nl2br(htmlspecialchars($d['deskripsi'] ?? 'Tidak ada deskripsi.')) ?></p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <?php if($d['file']): ?>
                            <a href="../assets/pdf/<?= htmlspecialchars($d['file']) ?>" class="btn btn-success" target="_blank">
                                <i class="fas fa-file-pdf me-2"></i>Baca PDF
                            </a>
                        <?php endif; ?>
                        <?php if($d['stok'] > 0): ?>
                            <a href="pinjam.php?id=<?= $d['id'] ?>" class="btn btn-primary">
                                <i class="fas fa-hand-holding-heart me-2"></i>Pinjam Buku
                            </a>
                        <?php else: ?>
                            <button class="btn btn-outline-secondary" disabled>
                                <i class="fas fa-ban me-2"></i>Stok Habis
                            </button>
                        <?php endif; ?>
                        <a href="buku.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include '../assets/layout_footer.php'; ?>
