<?php
require 'functions.php';
$db = Database::getConnection();
$id = (int)($_GET['id'] ?? 0);

$stmt = $db->prepare('SELECT * FROM produk WHERE id = ?');
$stmt->execute([$id]);
$p = $stmt->fetch();
if (!$p) {
    setFlash('error', 'Produk tidak ditemukan.');
    redirect('index.php');
}

$kategori = $db->query('SELECT id, nama FROM kategori ORDER BY nama')->fetchAll();
$supplier = $db->query('SELECT id, nama FROM supplier ORDER BY nama')->fetchAll();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$p, $errors] = validasiProduk($_POST);
    if (!$errors) {
        try {
            $stmt = $db->prepare('UPDATE produk SET nama = ?, kategori_id = ?, supplier_id = ?, harga = ?, stok = ? WHERE id = ?');
            $stmt->execute([$p['nama'], $p['kategori_id'], $p['supplier_id'], $p['harga'], $p['stok'], $id]);
            setFlash('sukses', 'Produk berhasil diperbarui.');
        } catch (PDOException $ex) {
            setFlash('error', 'Gagal memperbarui produk.');
        }
        redirect('index.php');
    }
}
$judul = 'Edit produk';
$tombol = 'Simpan perubahan';
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit produk</title><link rel="stylesheet" href="style.css"></head>
<body><?php include '_form.php'; ?></body></html>
