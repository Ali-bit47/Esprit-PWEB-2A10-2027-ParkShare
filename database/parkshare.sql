CREATE DATABASE IF NOT EXISTS parkshare CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE parkshare;

CREATE TABLE IF NOT EXISTS users (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(50)  NOT NULL,
    prenom          VARCHAR(50)  NOT NULL,
    username        VARCHAR(50)  NOT NULL UNIQUE,
    email           VARCHAR(150) NOT NULL UNIQUE,
    telephone       VARCHAR(20)  NOT NULL,
    password        VARCHAR(255) NOT NULL,
    role            ENUM('client', 'proprietaire', 'technicien', 'admin') NOT NULL DEFAULT 'client',
    statut          ENUM('actif', 'bloque') NOT NULL DEFAULT 'actif',
    failed_attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    locked_until    DATETIME NULL,
    last_login      DATETIME NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_role (role),
    INDEX idx_statut (statut)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (nom, prenom, username, email, telephone, password, role, statut, created_at) VALUES
('ParkShare', 'Admin',     'admin',      'admin@parkshare.tn',      '71000000', '$2y$10$7YCMqPyVauOHcFgsTLUtnOLLsxrbSikY3tnO/IubJ0kA290mjkTdu', 'admin',        'actif', '2026-09-01 09:00:00'),
('Ben Salah', 'Karim',     'karim.tech', 'technicien@parkshare.tn', '22123456', '$2y$10$vkislP5Z406QVJpupvEckO3wleWE4gbECF4XgMiN1BYUljVkaxxkS', 'technicien',   'actif', '2026-09-15 10:30:00'),
('Trabelsi',  'Sarra',     'sarra_t',    'proprietaire@parkshare.tn','98765432','$2y$10$/4P2M9fYn1NSOS9Pw9OYxeArRnYHHbfI/gan65RXrDK3eMimrhbY2', 'proprietaire', 'actif', '2026-10-03 14:12:00'),
('Khelifi',   'Mehdi',     'mehdi.k',    'client@parkshare.tn',     '55443322', '$2y$10$Yy5VU3dxzLAER/8VmJwQ.eVhWh/t2dXw7M2OdTWZCBV86gH1rv.tu', 'client',       'actif', '2026-11-02 18:45:00'),
('Ayari',     'Nour',      'nour_a',     'nour.ayari@gmail.com',    '29876543', '$2y$10$Yy5VU3dxzLAER/8VmJwQ.eVhWh/t2dXw7M2OdTWZCBV86gH1rv.tu', 'client',       'actif', '2026-11-10 08:20:00'),
('Gharbi',    'Yassine',   'yassine.g',  'yassine.gharbi@yahoo.fr', '50112233', '$2y$10$Yy5VU3dxzLAER/8VmJwQ.eVhWh/t2dXw7M2OdTWZCBV86gH1rv.tu', 'client',       'bloque','2026-11-18 21:05:00'),
('Jlassi',    'Amine',     'amine.j',    'amine.jlassi@gmail.com',  '24567890', '$2y$10$/4P2M9fYn1NSOS9Pw9OYxeArRnYHHbfI/gan65RXrDK3eMimrhbY2', 'proprietaire', 'actif', '2026-11-20 11:00:00');
