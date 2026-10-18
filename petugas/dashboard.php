<?php include 'proteksi.php'; ?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Petugas Dashboard'; $icon = 'clipboard-check'; $content_title = 'Dashboard Petugas'; ?>

        <!-- Stats Cards for Petugas -->
        <div class="row mb-5">
            <div class="col-lg-4 col-md-6">
                <div class="card text-center p-4">
                    <i class="fas fa-book fa-3x text-primary mb-3"></i>
                    <h3 class="mb-1"><?php 
                        include '../koneksi.php';
                        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM buku");
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $buku = mysqli_fetch_array($result);
                        echo $buku['total'] ?? 0;
                    ?></h3>
                    <p class="mb-0 text-muted">Total Buku</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card text-center p-4">
                    <i class="fas fa-exchange-alt fa-3x text-success mb-3"></i>
                    <h3 class="mb-1"><?php 
                        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM transaksi");
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $transaksi = mysqli_fetch_array($result);
                        echo $transaksi['total'] ?? 0;
                    ?></h3>
                    <p class="mb-0 text-muted">Transaksi</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card text-center p-4">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                    <h3 class="mb-1">45</h3>
                    <p class="mb-0 text-muted">Menunggu Konfirmasi</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-book-open me-2"></i>Buku Populer</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Harry Potter:</strong> 25 pinjam</li>
                            <li class="mb-2"><strong>Laskar Pelangi:</strong> 18 pinjam</li>
                            <li class="mb-2"><strong>Dune:</strong> 12 pinjam</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-tasks me-2"></i>Tugas Hari Ini</h5>
                    </div>
                    <div class="card-body">
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" style="width: 75%"></div>
                        </div>
                        <small>Konfirmasi Peminjaman: 15/20</small>
                    </div>
                </div>
            </div>
        </div>

<?php include '../assets/layout_footer.php'; ?>
