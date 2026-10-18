<?php include 'proteksi.php'; ?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Cari Buku'; $icon = 'search-book'; $content_title = 'Daftar Buku'; ?>

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="search-form">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control form-control-lg" name="cari" placeholder="Cari judul atau penulis buku..." value="<?php echo htmlspecialchars($_GET['cari'] ?? ''); ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <?php 
        $cari = $_GET['cari'] ?? '';
        $like_cari = "%" . $conn->real_escape_string($cari) . "%";
        $stmt = mysqli_prepare($conn, "SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? ORDER BY id DESC LIMIT 20");
        mysqli_stmt_bind_param($stmt, "ss", $like_cari, $like_cari);
        mysqli_stmt_execute($stmt);
        $data = mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($data) == 0): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Buku tidak ditemukan</h4>
                    <p class="text-muted">Coba cari dengan kata kunci lain atau kunjungi kategori buku.</p>
                    <a href="buku.php" class="btn btn-outline-primary">Lihat Semua Buku</a>
                </div>
            </div>
        <?php else: 
            while($d = mysqli_fetch_array($data)): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if($d['cover']): ?>
                    <img src="../assets/cover/<?php echo htmlspecialchars($d['cover']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($d['judul']); ?>" style="height: 250px; object-fit: cover;">
                    <?php else: ?>
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <i class="fas fa-book fa-3x text-muted"></i>
                    </div>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($d['judul']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($d['penulis']); ?></p>
                        <p class="card-text flex-grow-1">
                            <small><?php echo htmlspecialchars(substr($d['deskripsi'], 0, 100)); ?>...</small>
                        </p>
                        <div class="mt-auto">
                            <span class="badge bg-<?php echo $d['stok'] > 0 ? 'success' : 'danger'; ?>">
                                <?php echo $d['stok']; ?> tersedia
                            </span>
                            <div class="mt-2">
                                <a href="detail.php?id=<?php echo $d['id']; ?>" class="btn btn-primary btn-sm me-1">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <?php if($d['stok'] > 0): ?>
                                <a href="pinjam.php?id=<?php echo $d['id']; ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-hand-holding-heart"></i> Pinjam
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>

<?php include '../assets/layout_footer.php'; ?>
