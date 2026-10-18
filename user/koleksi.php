<?php include 'proteksi.php'; ?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Koleksi Saya'; $icon = 'heart'; $content_title = 'Peminjaman Aktif'; ?>

    <div class="row">
        <?php 
        $user_id = $_SESSION['id'];
        $stmt = mysqli_prepare($conn, "
            SELECT p.*, b.judul, b.cover, b.file 
            FROM peminjaman p
            JOIN buku b ON p.buku_id = b.id
            WHERE p.user_id=? 
            ORDER BY p.tanggal_pinjam DESC
        ");
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $data = mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($data) == 0): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-heart-broken fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada peminjaman</h4>
                    <p class="text-muted">Pinjam buku favorit Anda sekarang!</p>
                    <a href="buku.php" class="btn btn-primary">Cari Buku</a>
                </div>
            </div>
        <?php else: 
            while($d = mysqli_fetch_array($data)): ?>
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <?php if($d['cover']): ?>
                    <img src="../assets/cover/<?= htmlspecialchars($d['cover']) ?>" class="card-img-top" alt="<?= htmlspecialchars($d['judul']) ?>" style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($d['judul']) ?></h5>
                        <p class="card-text text-muted mb-2">
                            Status: <span class="badge bg-<?= 
                                $d['status'] == 'dipinjam' ? 'info' : 
                                ($d['status'] == 'menunggu_konfirmasi' ? 'warning' : 'success')
                            ?>"><?= ucwords($d['status']) ?></span>
                        </p>
                        <?php if($d['status'] == 'dipinjam'): ?>
                            <div class="mb-3">
                                <small class="text-muted">Pinjam: <?= date('d/m/Y', strtotime($d['tanggal_pinjam'])) ?></small>
                            </div>
                            <a href="kembalikan.php?id=<?= $d['id'] ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-undo"></i> Kembalikan
                            </a>
                        <?php elseif($d['status'] == 'menunggu_konfirmasi'): ?>
                            <span class="badge bg-warning">Menunggu konfirmasi petugas</span>
                        <?php elseif($d['status'] == 'dikembalikan' && $d['rating_status'] == 'belum'): ?>
                            <a href="rating.php?id=<?= $d['id'] ?>&buku=<?= $d['buku_id'] ?>" class="btn btn-outline-star btn-sm">
                                <i class="fas fa-star"></i> Beri Rating
                            </a>
                        <?php endif; ?>
                        
                        <?php if($d['file']): ?>
                            <a href="../assets/pdf/<?= htmlspecialchars($d['file']) ?>" class="btn btn-outline-secondary btn-sm mt-2" target="_blank">
                                <i class="fas fa-file-pdf"></i> Baca PDF
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>

<?php include '../assets/layout_footer.php'; ?>
