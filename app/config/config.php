<?php

// Base URL aplikasi
define('base_url', 'http://localhost/library/public');

// Konfigurasi database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'library');

// Mulai session jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}