-- Import file ini lewat phpMyAdmin (tab Import) atau jalankan di tab SQL
CREATE DATABASE IF NOT EXISTS inventaris_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE inventaris_db;

DROP TABLE IF EXISTS produk;
DROP TABLE IF EXISTS kategori;
DROP TABLE IF EXISTS supplier;

CREATE TABLE kategori (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE supplier (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  kontak VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE produk (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(150) NOT NULL,
  kategori_id INT NOT NULL,
  supplier_id INT NOT NULL,
  harga DECIMAL(12,2) NOT NULL DEFAULT 0,
  stok INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_produk_kategori FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_produk_supplier FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO kategori (nama) VALUES
 ('Elektronik'), ('Alat Tulis'), ('Perabot'), ('Makanan Ringan'), ('Kebersihan');

INSERT INTO supplier (nama, kontak) VALUES
 ('PT Sinar Jaya', '061-4455001'),
 ('CV Maju Bersama', '061-4455002'),
 ('UD Sumber Rezeki', '0812-3456-7001'),
 ('PT Nusantara Supplies', '0812-3456-7002'),
 ('CV Karya Mandiri', '0812-3456-7003');

INSERT INTO produk (nama, kategori_id, supplier_id, harga, stok) VALUES
 ('Mouse Wireless', 1, 1, 85000, 40),
 ('Keyboard Mekanik', 1, 4, 350000, 15),
 ('Pulpen Gel (box)', 2, 2, 24000, 120),
 ('Buku Tulis A5', 2, 2, 7500, 300),
 ('Kursi Kantor', 3, 5, 450000, 8),
 ('Meja Lipat', 3, 5, 275000, 12),
 ('Keripik Singkong', 4, 3, 12000, 80),
 ('Cairan Pembersih Lantai', 5, 3, 18000, 55);
