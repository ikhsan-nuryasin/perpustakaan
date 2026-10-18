USE `perpustakaan_digital`;

-- Fix admin password to correct bcrypt for 'admin123'
UPDATE `users` SET `password` = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE `username` = 'admin';

-- Verify (should match)
SELECT `username`, `password`, LENGTH(`password`) as hash_length FROM `users` WHERE `username` = 'admin';

SELECT 'Hash fixed! Test login again.' as message;

