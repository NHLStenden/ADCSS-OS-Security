CREATE DATABASE IF NOT EXISTS appdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       username VARCHAR(50) UNIQUE NOT NULL,
                       password_hash VARCHAR(255) NOT NULL,
                       google2fa_secret VARCHAR(64),
                       google2fa_enabled BOOLEAN DEFAULT 0
);

-- wachtwoord = secret
INSERT INTO users (username, password_hash, google2fa_enabled)
VALUES ('admin', '$2y$10$boZ1JZ4zSZR0Jw6CeV6PmuSgchdEGHD1kUL9Q5S6uTk4p2UVtuTui', 0);