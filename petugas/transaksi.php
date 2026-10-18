<?php include 'proteksi.php'; ?>

<?php include '../assets/layout.php'; ?>
<?php $page_title = 'Transaksi Peminjaman'; $icon = 'exchange-alt'; $content_title = 'Data Peminjaman'; ?>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag me-1"></i>No</th>
                    <th><i class="fas fa-user me-1"></i>User</th>
                    <th><i class="fas fa-book me-1"></i>Buku</th>
                    <th><i class="fas fa-calendar me-1"></i>Tanggal Pinjam</th>
                    <th><i class="fas fa-tag me-1"></i>Status</th>
                    <th><i class="fas fa-cog me-1"></i>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stmt = mysqli_prepare($conn, "
                    SELECT p.*, u.username, b.judul 
                    FROM peminjaman p
                    JOIN users u ON p.user_id = u.id
                    JOIN buku b ON p.buku_id = b.id
                    ORDER BY p.tanggal_pinjam DESC
                ");
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $no = 1;
                while($d = mysqli_fetch_array($result)): 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>
                        <div class="fw-bold"><?php echo htmlspecialchars($d['username']); ?></div>
                    </td>
                    <td><?php echo htmlspecialchars($d['judul']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($d['tanggal_pinjam'])); ?></td>
                    <td>
                        <span class="badge bg-<?php 
                            switch($d['status']){
                                case 'menunggu_konfirmasi': echo 'warning'; break;
                                case 'dipinjam': echo 'info'; break;
                                case 'dikembalikan': echo 'success'; break;
                                default: echo 'secondary';
                            }
                        ?>">
                            <?php echo ucwords($d['status']); ?>
                        </span>
                    </td>
                    <td>
                        <?php if($d['status'] == 'menunggu_konfirmasi'): ?>
                            <a href="konfirmasi.php?id=<?php echo $d['id']; ?>&buku=<?php echo $d['buku_id']; ?>" 
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-check"></i> Konfirmasi
                            </a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<?php include '../assets/layout_footer.php'; ?>
