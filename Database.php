<?php
// Koneksi PDO dengan Singleton pattern:
// hanya ada SATU objek koneksi untuk seluruh aplikasi.
class Database
{
    private static ?PDO $instance = null;

    private const HOST = 'localhost';
    private const NAME = 'inventaris_db';
    private const USER = 'root';
    private const PASS = '';

    // Constructor & clone private agar tidak bisa dibuat langsung dari luar
    private function __construct() {}
    private function __clone() {}

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::NAME . ';charset=utf8mb4';
            try {
                self::$instance = new PDO($dsn, self::USER, self::PASS, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                die('Koneksi database gagal. Pastikan MySQL menyala dan database.sql sudah diimport.');
            }
        }
        return self::$instance;
    }
}
