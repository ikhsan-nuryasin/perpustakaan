USE `perpustakaan_digital`;

-- Create admin with MD5 hash for 'admin123' = '0192023a7bbd73250516f069df18b500'
DELETE FROM `users` WHERE `username` = 'admin';
INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES 
('admin', 'admin@perpustakaan.local', '0192023a7bbd73250516f069df18b500', 'admin');

SELECT 'MD5 admin created! Login: admin/admin123 (test_login.php should show YES)' as message;

