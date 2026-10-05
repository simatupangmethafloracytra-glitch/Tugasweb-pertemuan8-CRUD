<?php
require 'functions.php';
$db = Database::getConnection();
$kategori = $db->query('SELECT id, nama FROM kategori ORDER BY nama')->fetchAll();
$supplier = $db->query('SELECT id, nama FROM supplier ORDER BY nama')->fetchAll();

$p = ['nama' => '', 'kategori_id' => 0, 'supplier_id' => 0, 'harga' => '', 'stok' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$p, $errors] = validasiProduk($_POST);
    if (!$errors) {
        try {
            $stmt = $db->prepare('INSERT INTO produk (nama, kategori_id, supplier_id, harga, stok) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$p['nama'], $p['kategori_id'], $p['supplier_id'], $p['harga'], $p['stok']]);
            setFlash('sukses', 'Produk berhasil ditambahkan.');
        } catch (PDOException $ex) {
            setFlash('error', 'Gagal menambahkan produk.');
        }
        redirect('index.php');   // redirect pattern
    }
}
$judul = 'Tambah produk';
$tombol = 'Simpan';
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tambah produk</title><link rel="stylesheet" href="style.css"></head>
<body><?php include '_form.php'; ?></body></html>
