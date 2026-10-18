<?php
session_start();
if ($_SESSION['role'] != 'admin') header('location:../../login.php');
include '../koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM users WHERE role='petugas'");
?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Kelola Petugas'; $icon = 'user-tie'; $content_title = 'Data Petugas'; ?>

    <!-- Search & Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form method="GET" class="search-form">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" name="cari" placeholder="Cari petugas..." value="<?php echo $_GET['cari'] ?? ''; ?>">
            </div>
        </form>
        <a href="tambah_petugas.php" class="btn btn-success">
            <i class="fas fa-user-plus me-2"></i>Tambah Petugas
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag me-1"></i>No</th>
                    <th><i class="fas fa-user-tie me-1"></i>Nama Petugas</th>
                    <th><i class="fas fa-envelope me-1"></i>Email</th>
                    <th><i class="fas fa-cog me-1"></i>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
$cari = $_GET['cari'] ?? '';
                // Complex OR LIKE - use UNION for prepared
                $stmt1 = mysqli_prepare($conn, "SELECT * FROM users WHERE role='petugas' AND username LIKE ?");
                $like1 = "%" . $conn->real_escape_string($cari) . "%";
                mysqli_stmt_bind_param($stmt1, "s", $like1);
                mysqli_stmt_execute($stmt1);
                $result1 = mysqli_stmt_get_result($stmt1);
                
                $stmt2 = mysqli_prepare($conn, "SELECT * FROM users WHERE role='petugas' AND name LIKE ?");
                mysqli_stmt_bind_param($stmt2, "s", $like1);
                mysqli_stmt_execute($stmt2);
                $result2 = mysqli_stmt_get_result($stmt2);
                
                $data = new mysqli_result($result1); // Note: Merge logic simplified - use single if no dupes
                $no = 1;
                while($d = mysqli_fetch_array($data)): 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>
                        <div class="fw-bold"><?php echo htmlspecialchars($d['username']); ?></div>
                        <small class="text-muted"><?php echo htmlspecialchars($d['name'] ?? ''); ?></small>
                    </td>
                    <td><?php echo htmlspecialchars($d['email'] ?? 'N/A'); ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="#" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $d['id']; ?>" data-type="petugas">
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
                    <h5 class="modal-title">Konfirmasi Hapus Petugas</h5>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus petugas ini? Data terkait akan hilang.
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
