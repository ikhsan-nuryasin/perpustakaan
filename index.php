<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Perpustakaan Digital - Halaman Utama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container py-5">
        <div class="hero-section">
            <h1 class="display-3 fw-bold mb-4">
                <i class="fas fa-book-open-reader me-3"></i>
                Selamat Datang di Perpustakaan Digital
            </h1>
            <p class="lead mb-5">Temukan ribuan buku berkualitas dengan sistem manajemen modern. Pinjam, baca, dan kelola koleksi Anda dengan mudah.</p>
            <div class="action-buttons">
                <a href="login.php" class="action-btn me-3 mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
                <a href="login.php" class="action-btn">
                    <i class="fas fa-user-plus me-2"></i>Daftar (Admin)
                </a>
            </div>
        </div>

        <div class="row features-grid">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card h-100">
                    <i class="fas fa-search-book fa-3x text-primary mb-3"></i>
                    <h3>Cari Buku</h3>
                    <p>Temukan buku favorit Anda dengan fitur pencarian canggih berdasarkan judul, penulis, dan kategori.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card h-100">
                    <i class="fas fa-hand-holding-heart fa-3x text-success mb-3"></i>
                    <h3>Pinjam Mudah</h3>
                    <p>Proses peminjaman digital yang cepat dan aman. Pantau status pinjaman kapan saja dari dashboard.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card h-100">
                    <i class="fas fa-users fa-3x text-info mb-3"></i>
                    <h3>Kelola Akun</h3>
                    <p>Admin dan petugas dapat mengelola data user, buku, dan transaksi dengan interface yang intuitif.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card h-100">
                    <i class="fas fa-mobile-alt fa-3x text-warning mb-3"></i>
                    <h3>100% Responsif</h3>
                    <p>Akses dari smartphone, tablet, atau desktop. Desain modern yang optimal di semua perangkat.</p>
                </div>
            </div>
        </div>

        <footer class="text-center py-5 mt-5" style="background: var(--dark-color); color: white; border-radius: var(--border-radius) var(--border-radius) 0 0;">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-book me-2"></i>Perpustakaan Digital</h5>
                    <p>Sistem perpustakaan modern dengan teknologi terkini untuk pengalaman membaca terbaik.</p>
                </div>
                <div class="col-md-4">
                    <h5>Kontak</h5>
                    <p><i class="fas fa-phone me-2"></i>+62 123 456 789<br>
                    <i class="fas fa-envelope me-2"></i>info@perpustakaan.com</p>
                </div>
                <div class="col-md-4">
                    <h5>Jam Layanan</h5>
                    <p>Senin - Jumat: 08.00 - 17.00<br>Sabtu: 09.00 - 15.00<br>Minggu: Tutup</p>
                </div>
            </div>
            <hr class="my-4">
            <p>&copy; 2024 Perpustakaan Digital. Dibuat dengan <i class="fas fa-heart text-danger"></i> untuk pecinta buku.</p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
</html>
