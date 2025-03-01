<?php

class LoginModel {
    private $table = 'petugas';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function checkLogin($username, $password)
    {
        // Ambil data user berdasarkan username
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $user = $this->db->single();

        // Jika user ditemukan, verifikasi password
        if ($user) {
            $hashedPassword = hash('sha256', $password); // Hash password input dengan SHA-256
            if ($hashedPassword === $user['password']) {
                return $user; // Return data user jika password cocok
            }
        }

        return false; // Return false jika username atau password salah
    }
}