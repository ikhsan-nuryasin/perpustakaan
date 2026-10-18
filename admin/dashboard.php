<?php
session_start();
if ($_SESSION['role'] != "admin") {
    header("location:../login.php");
}
include '../koneksi.php';
?>
<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Admin Dashboard'; $icon = 'tachometer-alt'; $content_title = 'Dashboard Admin'; ?>

        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="card text-center p-4">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3 class="mb-1"><?php 
                        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM users");
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $users = mysqli_fetch_array($result);
                        echo $users['total'] ?? 0;
                    ?></h3>
                    <p class="mb-0 text-muted">Total User</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center p-4">
                    <i class="fas fa-user-tie fa-3x text-success mb-3"></i>
                    <h3 class="mb-1"><?php 
                        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM users WHERE role=?");
                        mysqli_stmt_bind_param($stmt, "s", "petugas");
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $petugas = mysqli_fetch_array($result);
                        echo $petugas['total'] ?? 0;
                    ?></h3>
                    <p class="mb-0 text-muted">Petugas</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center p-4">
                    <i class="fas fa-book fa-3x text-info mb-3"></i>
                    <h3 class="mb-1"><?php 
                        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM buku");
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $buku = mysqli_fetch_array($result);
                        echo $buku['total'] ?? 0;
                    ?></h3>
                    <p class="mb-0 text-muted">Total Buku</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center p-4">
                    <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>
                    <h3 class="mb-1">12</h3>
                    <p class="mb-0 text-muted">Peminjaman Hari Ini</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-clipboard-list me-2"></i>Aktivitas Terbaru</div>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between">
                                <span>User baru terdaftar</span>
                                <small class="text-muted">2 menit lalu</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between">
                                <span>Buku ditambahkan</span>
                                <small class="text-muted">1 jam lalu</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-pie me-2"></i>Statistik Bulanan</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="lead">📈 Lihat laporan lengkap</p>
                        <a href="#" class="btn btn-outline-primary">Laporan PDF</a>
                    </div>
                </div>
            </div>
        </div>

<?php include '../assets/layout_footer.php'; // Note: Will create this later for closing ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
