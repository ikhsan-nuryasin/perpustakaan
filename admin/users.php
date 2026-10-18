<?php
session_start();
if ($_SESSION['role'] != 'admin') header('location:../../login.php');
include '../koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM users WHERE role='user'");
?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Kelola User'; $icon = 'users'; $content_title = 'Data User'; ?>

    <!-- Search & Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form method="GET" class="search-form">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" name="cari" placeholder="Cari username..." value="<?php echo $_GET['cari'] ?? ''; ?>">
            </div>
        </form>
        <a href="tambah_user.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah User
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag me-1"></i>No</th>
                    <th><i class="fas fa-user me-1"></i>Username</th>
                    <th><i class="fas fa-envelope me-1"></i>Email</th>
                    <th><i class="fas fa-cog me-1"></i>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
$cari = $_GET['cari'] ?? '';
                $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE role=? AND username LIKE ?");
                $like_cari = "%" . $conn->real_escape_string($cari) . "%";
                mysqli_stmt_bind_param($stmt, "ss", "user", $like_cari);
                mysqli_stmt_execute($stmt);
                $data = mysqli_stmt_get_result($stmt);
                $no = 1;
                while($d = mysqli_fetch_array($data)): 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>
                        <div class="fw-bold"><?php echo htmlspecialchars($d['username']); ?></div>
                        <small class="text-muted"><?php echo htmlspecialchars($d['role']); ?></small>
                    </td>
                    <td><?php echo htmlspecialchars($d['email'] ?? 'N/A'); ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="edit_user.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $d['id']; ?>" data-type="user">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
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
