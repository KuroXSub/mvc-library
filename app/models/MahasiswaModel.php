<?php

class MahasiswaModel {
    private $table = 'mahasiswa';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllMahasiswa()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getMahasiswaById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', intval($id));
        return $this->db->single();
    }

    public function tambahMahasiswa($data)
    {
        $query = "INSERT INTO mahasiswa (nim, nama, jurusan, alamat) VALUES(:nim, :nama, :jurusan, :alamat)";
        $this->db->query($query);
        $this->db->bind('nim', htmlspecialchars($data['nim']));
        $this->db->bind('nama', htmlspecialchars($data['nama']));
        $this->db->bind('jurusan', htmlspecialchars($data['jurusan']));
        $this->db->bind('alamat', htmlspecialchars($data['alamat']));
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateDataMahasiswa($data)
    {
        $query = "UPDATE mahasiswa SET nim=:nim, nama=:nama, jurusan=:jurusan, alamat=:alamat WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', intval($data['id']));
        $this->db->bind('nim', htmlspecialchars($data['nim']));
        $this->db->bind('nama', htmlspecialchars($data['nama']));
        $this->db->bind('jurusan', htmlspecialchars($data['jurusan']));
        $this->db->bind('alamat', htmlspecialchars($data['alamat']));
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function isMahasiswaTerpakai($id)
    {
        // Query untuk mengecek apakah kategori terikat dengan buku
        $this->db->query('SELECT COUNT(*) as jumlah FROM peminjaman WHERE mahasiswa_id = :id');
        $this->db->bind('id', intval($id));
        $result = $this->db->single();

        // Jika jumlah buku yang menggunakan kategori ini lebih dari 0, kembalikan true
        return $result['jumlah'] > 0;
    }

    public function deleteMahasiswa($id)
    {
        if (!$this->isMahasiswaTerpakai($id)) {
            $this->db->query('DELETE FROM ' . $this->table . ' WHERE id=:id');
            $this->db->bind('id', intval($id));
            $this->db->execute();

            return $this->db->rowCount();
        }

        return 0;
    }

    public function cariMahasiswa($key)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE nama LIKE :key OR nim LIKE :key");
        $this->db->bind('key', "%$key%");
        return $this->db->resultSet();
    }

    public function getJumlahMahasiswa()
    {
        $this->db->query('SELECT COUNT(*) as jumlah FROM ' . $this->table);
        return $this->db->single()['jumlah'];
    }

    public function getMahasiswaPagination($limit, $offset)
    {
        $query = "SELECT * FROM " . $this->table . " LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $offset);
        return $this->db->resultSet();
    }

    public function cariMahasiswaPagination($key, $limit, $offset)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE nama LIKE :key OR nim LIKE :key LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind('key', "%$key%");
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $offset);
        return $this->db->resultSet();
    }

    public function getJumlahCariMahasiswa($key)
    {
        $query = "SELECT COUNT(*) as jumlah FROM " . $this->table . " WHERE nama LIKE :key OR nim LIKE :key";
        $this->db->query($query);
        $this->db->bind('key', "%$key%");
        return $this->db->single()['jumlah'];
    }
}