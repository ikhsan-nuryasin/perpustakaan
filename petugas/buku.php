<?php include 'proteksi.php'; ?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Kelola Buku Petugas'; $icon = 'book'; $content_title = 'Data Buku'; ?>

    <div class="d-flex justify-content-end mb-4">
        <a href="tambah_buku.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Buku Baru
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag me-1"></i>#</th>
                    <th><i class="fas fa-book me-1"></i>Judul</th>
                    <th><i class="fas fa-user me-1"></i>Penulis</th>
                    <th><i class="fas fa-layer-group me-1"></i>Stok</th>
                    <th><i class="fas fa-cogs me-1"></i>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
$cari = $_GET['cari'] ?? '';
                $like_cari = "%" . $conn->real_escape_string($cari) . "%";
                $stmt = mysqli_prepare($conn, "SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? ORDER BY id DESC LIMIT 50");
                mysqli_stmt_bind_param($stmt, "ss", $like_cari, $like_cari);
                mysqli_stmt_execute($stmt);
                $data = mysqli_stmt_get_result($stmt);
                $no = 1;
                while($d = mysqli_fetch_array($data)): 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($d['judul']); ?></td>
                    <td><?php echo htmlspecialchars($d['penulis']); ?></td>
                    <td>
                        <span class="badge <?php echo $d['stok'] > 5 ? 'bg-success' : ($d['stok'] > 0 ? 'bg-warning' : 'bg-danger'); ?>">
                            <?php echo $d['stok']; ?>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary" onclick="printBook(<?php echo $d['id']; ?>)">
                                <i class="fas fa-print"></i>
                            </button>
                            <a href="../user/detail.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-outline-info" target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="hapus_buku.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $d['id']; ?>">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<?php include '../assets/layout_footer.php'; ?>

<script>
// Professional delete confirmation
const deleteBtns = document.querySelectorAll('.delete-btn');
deleteBtns.forEach(btn => {
    btn.addEventListener('click', e => {
        e.preventDefault();
        if(confirm('Yakin hapus buku ini?')) {
            window.location = btn.href;
        }
    });
});
</script>
