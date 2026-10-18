<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Perpustakaan Digital - <?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-book-open me-2"></i>📚 Perpustakaan Digital
            </a>
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['role'])): ?>
                <span class="badge bg-primary me-3 fs-6">
                        <i class="fas fa-user me-1"></i>
                        <?php echo htmlspecialchars(ucfirst($_SESSION['role'] ?? 'Guest')); ?>
                    </span>
                    <a href="../logout.php" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                <?php endif; ?>
                <button class="theme-toggle ms-3" onclick="toggleTheme()">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['role'])): ?>
    <!-- Sidebar for logged-in users -->
    <div class="sidebar" id="sidebar">
        <ul>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                <li><a href="users.php"><i class="fas fa-users me-2"></i>Kelola User</a></li>
                <li><a href="petugas.php"><i class="fas fa-user-tie me-2"></i>Petugas</a></li>
                <li><a href="buku.php"><i class="fas fa-book me-2"></i>Buku</a></li>
            <?php elseif ($_SESSION['role'] == 'petugas'): ?>
                <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                <li><a href="buku.php"><i class="fas fa-book me-2"></i>Kelola Buku</a></li>
                <li><a href="transaksi.php"><i class="fas fa-exchange-alt me-2"></i>Transaksi</a></li>
            <?php else: ?>
                <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                <li><a href="buku.php"><i class="fas fa-search-book me-2"></i>Cari Buku</a></li>
                <li><a href="koleksi.php"><i class="fas fa-heart me-2"></i>Koleksi</a></li>
                <li><a href="pinjam.php"><i class="fas fa-hand-holding-heart me-2"></i>Pinjam</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="main-content">
        <?php if (isset($content_title)): ?>
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0"><i class="fas fa-<?php echo $icon ?? 'circle'; ?> me-2 text-primary"></i><?php echo $content_title; ?></h2>
            </div>
        <?php endif; ?>
