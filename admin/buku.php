<?php
session_start();
if ($_SESSION['role'] != 'admin') header('location:../../login.php');
include '../koneksi.php';

$cari = $_GET['cari'] ?? '';
$like_cari = "%" . $conn->real_escape_string($cari) . "%";
$stmt = mysqli_prepare($conn, "SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ?");
mysqli_stmt_bind_param($stmt, "ss", $like_cari, $like_cari);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Kelola Buku'; $icon = 'book'; $content_title = 'Data Buku'; ?>

    <!-- Search & Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form method="GET" class="search-form">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" name="cari" placeholder="Cari judul/penulis..." value="<?php echo $cari; ?>">
            </div>
        </form>
        <a href="tambah_buku.php" class="btn btn-info">
            <i class="fas fa-plus me-2"></i>Tambah Buku
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag me-1"></i>No</th>
                    <th><i class="fas fa-book-open me-1"></i>Judul</th>
                    <th><i class="fas fa-user me-1"></i>Penulis</th>
                    <th><i class="fas fa-layer-group me-1"></i>Stok</th>
                    <th><i class="fas fa-cog me-1"></i>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($d = mysqli_fetch_array($data)): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>
                        <strong><?php echo htmlspecialchars($d['judul']); ?></strong>
                        <?php if($d['cover']): ?>
                        <br><small class="text-muted">Cover tersedia</small>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($d['penulis']); ?></td>
                    <td>
                        <span class="badge <?php echo $d['stok'] > 0 ? 'bg-success' : 'bg-danger'; ?>">
                            <?php echo $d['stok']; ?> tersedia
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="edit_buku.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $d['id']; ?>" data-type="buku">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Delete Modal (same as users) -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <h5 class="modal-title">Konfirmasi Hapus Buku</h5>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus buku ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="confirmDelete" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

<?php include '../assets/layout_footer.php'; ?>

<script>
// Same delete modal logic as users.php
document.addEventListener('DOMContentLoaded', function() {
    const deleteBtns = document.querySelectorAll('.delete-btn');
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const confirmBtn = document.getElementById('confirmDelete');

    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            const type = this.dataset.type;
            confirmBtn.href = `hapus.php?id=${id}&type=${type}`;
            modal.show();
        });
    });
});
</script>
