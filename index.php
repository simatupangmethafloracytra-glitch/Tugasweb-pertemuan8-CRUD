<?php
require 'functions.php';
$db = Database::getConnection();

$cari = trim($_GET['cari'] ?? '');
$sql = 'SELECT p.id, p.nama, p.harga, p.stok, k.nama AS kategori, s.nama AS supplier
        FROM produk p
        JOIN kategori k ON p.kategori_id = k.id
        JOIN supplier s ON p.supplier_id = s.id';
$params = [];
if ($cari !== '') {
    $sql .= ' WHERE p.nama LIKE ?';
    $params[] = '%' . $cari . '%';
}
$sql .= ' ORDER BY p.id DESC';
$stmt = $db->prepare($sql);
$stmt->execute($params);
$produk = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inventaris</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main class="card lebar">
  <div class="kepala">
    <h1>Inventaris produk</h1>
    <a class="tombol" href="create.php">Tambah produk</a>
  </div>
  <?php tampilFlash(); ?>

  <form class="cari" method="get">
    <input type="search" name="cari" placeholder="Cari nama produk" value="<?= e($cari) ?>">
    <button type="submit">Cari</button>
  </form>

  <div class="tabel-wrap">
  <table>
    <thead><tr><th>No</th><th>Nama</th><th>Kategori</th><th>Supplier</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php if (!$produk): ?>
      <tr><td colspan="7" class="kosong">Belum ada produk<?= $cari !== '' ? ' yang cocok dengan pencarian' : '' ?>.</td></tr>
    <?php endif; ?>
    <?php foreach ($produk as $i => $p): ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= e($p['nama']) ?></td>
        <td><?= e($p['kategori']) ?></td>
        <td><?= e($p['supplier']) ?></td>
        <td><?= e(rupiah($p['harga'])) ?></td>
        <td><?= e($p['stok']) ?></td>
        <td class="aksi">
          <a href="edit.php?id=<?= e($p['id']) ?>">Edit</a>
          <a class="hapus" href="delete.php?id=<?= e($p['id']) ?>">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</main>
</body>
</html>
