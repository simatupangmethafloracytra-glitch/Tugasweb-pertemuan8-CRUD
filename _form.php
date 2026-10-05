<?php
// Form bersama untuk create & edit. Variabel dari halaman pemanggil:
// $p (data produk), $kategori, $supplier, $errors, $judul, $tombol
?>
<main class="card">
  <h1><?= e($judul) ?></h1>
  <?php foreach ($errors as $er): ?><div class="flash error"><?= e($er) ?></div><?php endforeach; ?>
  <form method="post">
    <label for="nama">Nama produk</label>
    <input type="text" id="nama" name="nama" value="<?= e($p['nama']) ?>" required>

    <label for="kategori_id">Kategori</label>
    <select id="kategori_id" name="kategori_id" required>
      <option value="">-- Pilih kategori --</option>
      <?php foreach ($kategori as $k): ?>
        <option value="<?= e($k['id']) ?>" <?= (int)$p['kategori_id'] === (int)$k['id'] ? 'selected' : '' ?>><?= e($k['nama']) ?></option>
      <?php endforeach; ?>
    </select>

    <label for="supplier_id">Supplier</label>
    <select id="supplier_id" name="supplier_id" required>
      <option value="">-- Pilih supplier --</option>
      <?php foreach ($supplier as $s): ?>
        <option value="<?= e($s['id']) ?>" <?= (int)$p['supplier_id'] === (int)$s['id'] ? 'selected' : '' ?>><?= e($s['nama']) ?></option>
      <?php endforeach; ?>
    </select>

    <div class="baris">
      <div><label for="harga">Harga (Rp)</label>
        <input type="number" id="harga" name="harga" min="0" step="any" value="<?= e($p['harga']) ?>" required></div>
      <div><label for="stok">Stok</label>
        <input type="number" id="stok" name="stok" min="0" step="1" value="<?= e($p['stok']) ?>" required></div>
    </div>

    <button type="submit"><?= e($tombol) ?></button>
    <a class="batal" href="index.php">Batal</a>
  </form>
</main>
