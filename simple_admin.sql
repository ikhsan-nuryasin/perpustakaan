USE perpustakaan_digital;

DELETE FROM users WHERE username = 'admin';

INSERT INTO users (username, email, password, role) VALUES ('admin', 'admin@perpustakaan.local', MD5('admin123'), 'admin');

SELECT 'Simple MD5 admin created! Username: admin, Password: admin123' as message;
