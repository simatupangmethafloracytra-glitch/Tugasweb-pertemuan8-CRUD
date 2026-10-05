<?php
session_start();
require_once __DIR__ . '/Database.php';

// Escape output (requirement 8)
function e($teks): string {
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

function rupiah($angka): string {
    return 'Rp ' . number_format((float)$angka, 0, ',', '.');
}

// Flash message: disimpan di session, tampil sekali setelah redirect
function setFlash(string $tipe, string $isi): void {
    $_SESSION['flash'] = ['tipe' => $tipe, 'isi' => $isi];
}
function tampilFlash(): void {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        echo '<div class="flash ' . e($f['tipe']) . '">' . e($f['isi']) . '</div>';
        unset($_SESSION['flash']);
    }
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

// Validasi data form produk. Return [data_bersih, daftar_error]
function validasiProduk(array $in): array {
    $db = Database::getConnection();
    $d = [
        'nama'        => trim($in['nama'] ?? ''),
        'kategori_id' => (int)($in['kategori_id'] ?? 0),
        'supplier_id' => (int)($in['supplier_id'] ?? 0),
        'harga'       => $in['harga'] ?? '',
        'stok'        => $in['stok'] ?? '',
    ];
    $err = [];
    if ($d['nama'] === '' || mb_strlen($d['nama']) > 150) $err[] = 'Nama produk wajib diisi (maks. 150 karakter).';

    $s = $db->prepare('SELECT COUNT(*) FROM kategori WHERE id = ?');
    $s->execute([$d['kategori_id']]);
    if (!$s->fetchColumn()) $err[] = 'Pilih kategori yang valid.';

    $s = $db->prepare('SELECT COUNT(*) FROM supplier WHERE id = ?');
    $s->execute([$d['supplier_id']]);
    if (!$s->fetchColumn()) $err[] = 'Pilih supplier yang valid.';

    if (!is_numeric($d['harga']) || $d['harga'] < 0) $err[] = 'Harga harus angka 0 atau lebih.';
    if (filter_var($d['stok'], FILTER_VALIDATE_INT) === false || $d['stok'] < 0) $err[] = 'Stok harus bilangan bulat 0 atau lebih.';
    return [$d, $err];
}
