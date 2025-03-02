<?php

class PetugasModel {
    private $table = 'petugas';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllPetugasExceptMinId()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id != (SELECT MIN(id) FROM ' . $this->table . ')');
        return $this->db->resultSet();
    }

    public function getPetugasById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', intval($id));
        return $this->db->single();
    }

    public function tambahPetugas($data)
    {
        $query = "INSERT INTO petugas (nama, username, password) VALUES (:nama, :username, :password)";
        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('password', $data['password']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function cekUsername($username)
    {
        $this->db->query("SELECT * FROM petugas WHERE username = :username");
        $this->db->bind('username', htmlspecialchars($username));
        return $this->db->single();
    }

    public function updateDataPetugas($data)
    {
        if (empty($data['password'])) {
            $query = "UPDATE petugas SET nama = :nama WHERE id = :id";
            $this->db->query($query);
            $this->db->bind('id', intval($data['id']));
            $this->db->bind('nama', $data['nama']);
        } else {
            $query = "UPDATE petugas SET nama = :nama, password = :password WHERE id = :id";
            $this->db->query($query);
            $this->db->bind('id', intval($data['id']));
            $this->db->bind('nama', $data['nama']);
            $this->db->bind('password', $data['password']);
        }

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function isPetugasTerpakai($id)
    {
        // Query untuk mengecek apakah petugas terikat dengan peminjaman
        $this->db->query('SELECT COUNT(*) as jumlah FROM peminjaman WHERE petugas_id = :id');
        $this->db->bind('id', intval($id));
        $result = $this->db->single();

        // Jika jumlah peminjaman yang menggunakan petugas ini lebih dari 0, kembalikan true
        return $result['jumlah'] > 0;
    }

    public function getMinIdPetugas()
    {
        $this->db->query('SELECT MIN(id) as min_id FROM ' . $this->table);
        return $this->db->single()['min_id'];
    }

    public function cariPetugas($key)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE nama LIKE :key AND id != (SELECT MIN(id) FROM " . $this->table . ")");
        $this->db->bind('key', "%$key%");
        return $this->db->resultSet();
    }

    public function getPetugasPagination($limit, $offset)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id != (SELECT MIN(id) FROM " . $this->table . ") LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $offset);
        return $this->db->resultSet();
    }

    public function cariPetugasPagination($key, $limit, $offset)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE nama LIKE :key AND id != (SELECT MIN(id) FROM " . $this->table . ") LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind('key', "%$key%");
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $offset);
        return $this->db->resultSet();
    }

    public function getJumlahPetugas()
    {
        $query = "SELECT COUNT(*) as jumlah FROM " . $this->table . " WHERE id != (SELECT MIN(id) FROM " . $this->table . ")";
        $this->db->query($query);
        return $this->db->single()['jumlah'];
    }

    public function getJumlahCariPetugas($key)
    {
        $query = "SELECT COUNT(*) as jumlah FROM " . $this->table . " WHERE nama LIKE :key AND id != (SELECT MIN(id) FROM " . $this->table . ")";
        $this->db->query($query);
        $this->db->bind('key', "%$key%");
        return $this->db->single()['jumlah'];
    }
}