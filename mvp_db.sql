-- Database: db_mvp_kandidat
CREATE DATABASE IF NOT EXISTS `db_mvp_kandidat`;
USE `db_mvp_kandidat`;

CREATE TABLE IF NOT EXISTS `kandidat` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `posisi` VARCHAR(100) NOT NULL,
  `domisili` VARCHAR(100) NOT NULL,
  `skor_tes` INT(11) NOT NULL DEFAULT 0,
  `pengalaman_tahun` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `jadwal_interview` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `kandidat_id` INT(11) NOT NULL,
  `waktu` DATETIME NULL,
  `tempat` ENUM('kantor', 'online') NULL,
  `status` ENUM('pending', 'dipertimbangkan', 'ditolak', 'diterima') NULL DEFAULT('pending'),
  PRIMARY KEY(`id`),
  FOREIGN KEY(`kandidat_id`) REFERENCES `kandidat`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `kandidat`(`id`, `nama`, `posisi`, `domisili`, `skor_tes`, `pengalaman_tahun`) VALUES
  (1, 'Raka Pratama', 'Backend Developer', 'Bandung', 92, 3),
  (2, 'Sinta Maharani', 'UI/UX Designer', 'Jakarta', 88, 2),
  (3, 'Dimas Nugroho', 'Data Analyst', 'Yogyakarta', 85, 1),
  (4, 'Nadia Kusuma', 'Frontend Developer', 'Surabaya', 90, 2),
  (5, 'Bagas Setiawan', 'QA Engineer', 'Bandung', 81, 1);

INSERT INTO `jadwal_interview`(`id`, `kandidat_id`, `waktu`, `tempat`, `status`) VALUES
  (1, 1, '2026-11-01 08:00:00', 'kantor', 'diterima'),
  (2, 2, '2026-11-08 13:00:00', 'kantor', 'ditolak'),
  (3, 3, '2026-11-09 10:00:00', 'online', 'diterima'),
  (4, 4, '2026-11-21 09:00:00', 'online', 'ditolak'),
  (5, 5, '2026-11-29 08:00:00', 'kantor', 'pending');