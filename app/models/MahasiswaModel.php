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

    public function deleteMahasiswa($id)
    {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', intval($id));
        $this->db->execute();

        return $this->db->rowCount();
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
}