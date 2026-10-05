<?php
require 'functions.php';
$db = Database::getConnection();
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

$stmt = $db->prepare('SELECT nama FROM produk WHERE id = ?');
$stmt->execute([$id]);
$p = $stmt->fetch();
if (!$p) {
    setFlash('error', 'Produk tidak ditemukan.');
    redirect('index.php');
}

// Hapus hanya lewat POST setelah user menekan tombol konfirmasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->prepare('DELETE FROM produk WHERE id = ?')->execute([$id]);
        setFlash('sukses', 'Produk "' . $p['nama'] . '" berhasil dihapus.');
    } catch (PDOException $ex) {
        setFlash('error', 'Gagal menghapus produk.');
    }
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Hapus produk</title><link rel="stylesheet" href="style.css"></head>
<body>
<main class="card">
  <h1>Hapus produk?</h1>
  <p>Produk <strong><?= e($p['nama']) ?></strong> akan dihapus permanen.</p>
  <form method="post">
    <input type="hidden" name="id" value="<?= e($id) ?>">
    <button type="submit" class="bahaya">Ya, hapus</button>
    <a class="batal" href="index.php">Batal</a>
  </form>
</main>
</body></html>
