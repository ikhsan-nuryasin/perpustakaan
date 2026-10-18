<?php include 'proteksi.php'; ?>

<?php
$id = (int)$_GET['id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM buku WHERE id=? AND file IS NOT NULL AND file != ''");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$d = mysqli_fetch_assoc($result);

if(!$d){
    $_SESSION['error_message'] = 'Buku atau file PDF tidak ditemukan!';
    header("location:buku.php");
    exit();
}
?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Baca ' . htmlspecialchars($d['judul']); $icon = 'book-reader'; $content_title = 'Baca ' . htmlspecialchars($d['judul']); ?>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="detail.php?id=<?= $id ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
                    </a>
                </div>
                <div class="text-end">
                    <a href="../assets/pdf/<?= htmlspecialchars($d['file']) ?>" class="btn btn-success" download>
                        <i class="fas fa-download me-2"></i>Download PDF
                    </a>
                    <a href="../assets/pdf/<?= htmlspecialchars($d['file']) ?>" class="btn btn-primary" target="_blank">
                        <i class="fas fa-expand me-2"></i>Baca Fullscreen
                    </a>
                </div>
            </div>
            
            <div class="card shadow">
                <div class="card-body p-0">
                    <iframe src="../assets/pdf/<?= htmlspecialchars($d['file']) ?>" 
                            class="w-100" style="height: 80vh; border: none;" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

<?php include '../assets/layout_footer.php'; ?>
