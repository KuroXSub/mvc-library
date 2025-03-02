<?php

class BukuModel {
    private $table = 'buku';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllBuku($orderBy = 'judul', $orderDirection = 'ASC')
    {
        $query = "SELECT buku.*, kategori.nama_kategori FROM buku 
                JOIN kategori ON kategori.id = buku.kategori_id 
                ORDER BY $orderBy $orderDirection";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getBukuById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahBuku($data)
    {
        $query = "INSERT INTO buku (judul, penulis, kategori_id, tahun_terbit, stok) VALUES(:judul, :penulis, :kategori_id, :tahun_terbit, :stok)";
        $this->db->query($query);
        $this->db->bind('judul', htmlspecialchars($data['judul']));
        $this->db->bind('penulis', htmlspecialchars($data['penulis']));
        $this->db->bind('kategori_id', intval($data['kategori_id']));
        $this->db->bind('tahun_terbit', intval($data['tahun_terbit']));
        $this->db->bind('stok', intval($data['stok']));
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateDataBuku($data)
    {
        $query = "UPDATE buku SET judul=:judul, penulis=:penulis, kategori_id=:kategori_id, tahun_terbit=:tahun_terbit, stok=:stok WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', intval($data['id']));
        $this->db->bind('judul', htmlspecialchars($data['judul']));
        $this->db->bind('penulis', htmlspecialchars($data['penulis']));
        $this->db->bind('kategori_id', intval($data['kategori_id']));
        $this->db->bind('tahun_terbit', intval($data['tahun_terbit']));
        $this->db->bind('stok', intval($data['stok']));
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function isBukuTerpakai($id)
    {
        $this->db->query('SELECT COUNT(*) as jumlah FROM peminjaman WHERE buku_id = :id');
        $this->db->bind('id', intval($id));
        $result = $this->db->single();

        return $result['jumlah'] > 0;
    }

    public function deleteBuku($id)
    {
        if (!$this->isBukuTerpakai($id)) {
            $this->db->query('DELETE FROM ' . $this->table . ' WHERE id=:id');
            $this->db->bind('id', intval($id));
            $this->db->execute();

            return $this->db->rowCount();
        }

        return 0;
    }

    public function cariBuku()
    {
        $key = htmlspecialchars($_POST['key']);
        $this->db->query("SELECT buku.*, kategori.nama_kategori FROM " . $this->table . " JOIN kategori ON buku.kategori_id = kategori.id WHERE buku.judul LIKE :key");
        $this->db->bind('key', "%$key%");
        return $this->db->resultSet();
    }

    public function getJumlahBuku()
    {
        $this->db->query('SELECT COUNT(*) as jumlah FROM ' . $this->table);
        return $this->db->single()['jumlah'];
    }

    public function getBukuPagination($limit, $offset)
    {
        $query = "SELECT buku.*, kategori.nama_kategori FROM buku 
                JOIN kategori ON kategori.id = buku.kategori_id 
                LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $offset);
        return $this->db->resultSet();
    }

    public function cariBukuPagination($key, $limit, $offset)
    {
        $query = "SELECT buku.*, kategori.nama_kategori FROM buku 
                JOIN kategori ON buku.kategori_id = kategori.id 
                WHERE buku.judul LIKE :key 
                LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind('key', "%$key%");
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $offset);
        return $this->db->resultSet();
    }

    public function getJumlahCariBuku($key)
    {
        $query = "SELECT COUNT(*) as jumlah FROM buku 
                WHERE judul LIKE :key";
        $this->db->query($query);
        $this->db->bind('key', "%$key%");
        return $this->db->single()['jumlah'];
    }
}