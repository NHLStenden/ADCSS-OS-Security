CREATE DATABASE IF NOT EXISTS appdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

use appdb;
CREATE USER 'appuser'@'localhost' IDENTIFIED BY 'secret';

GRANT ALL PRIVILEGES ON appdb.* TO 'appuser'@'localhost';

FLUSH PRIVILEGES;

CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       username VARCHAR(50) UNIQUE NOT NULL,
                       password_hash VARCHAR(255) NOT NULL,
                       google2fa_secret VARCHAR(64),
                       google2fa_enabled BOOLEAN DEFAULT 0
);

-- wachtwoord = secret
INSERT INTO users (username, password_hash, google2fa_enabled)
VALUES ('admin', '$2y$12$wY.bKKve7bYoEGMc.q9TpOPEoryNF3yffQGmo5geUjrTqjfrUSVfm', 0);

