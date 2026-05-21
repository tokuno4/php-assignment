CREATE DATABASE IF NOT EXISTS homework4_mail
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE homework4_mail;

CREATE TABLE IF NOT EXISTS mail_list (
    No INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(120) NOT NULL UNIQUE
);

INSERT INTO mail_list (email) VALUES
('test01@example.com'),
('test02@example.com'),
('test03@example.com');
