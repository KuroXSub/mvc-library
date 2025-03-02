<?php

class KategoriModel {
    private $table = 'kategori';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllKategori()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getKategoriById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', intval($id));
        return $this->db->single();
    }

    public function tambahKategori($data)
    {
        $query = "INSERT INTO kategori (nama_kategori) VALUES(:nama_kategori)";
        $this->db->query($query);
        $this->db->bind('nama_kategori', htmlspecialchars($data['nama_kategori']));
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateDataKategori($data)
    {
        $query = "UPDATE kategori SET nama_kategori=:nama_kategori WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', intval($data['id']));
        $this->db->bind('nama_kategori', htmlspecialchars($data['nama_kategori']));
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function isKategoriTerpakai($id)
    {
        // Query untuk mengecek apakah kategori terikat dengan buku
        $this->db->query('SELECT COUNT(*) as jumlah FROM buku WHERE kategori_id = :id');
        $this->db->bind('id', intval($id));
        $result = $this->db->single();

        // Jika jumlah buku yang menggunakan kategori ini lebih dari 0, kembalikan true
        return $result['jumlah'] > 0;
    }

    public function deleteKategori($id)
    {
        // Hapus kategori hanya jika tidak terikat dengan buku
        if (!$this->isKategoriTerpakai($id)) {
            $this->db->query('DELETE FROM ' . $this->table . ' WHERE id=:id');
            $this->db->bind('id', intval($id));
            $this->db->execute();

            return $this->db->rowCount();
        }

        return 0; // Kembalikan 0 jika kategori terikat dengan buku
    }

    public function cariKategori($key)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE nama_kategori LIKE :key");
        $this->db->bind('key', "%$key%");
        return $this->db->resultSet();
    }

    public function getKategoriPagination($limit, $offset)
    {
        $query = "SELECT * FROM " . $this->table . " LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $offset);
        return $this->db->resultSet();
    }

    public function getJumlahKategori()
    {
        $this->db->query('SELECT COUNT(*) as jumlah FROM ' . $this->table);
        return $this->db->single()['jumlah'];
    }

    public function cariKategoriPagination($key, $limit, $offset)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE nama_kategori LIKE :key LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind('key', "%$key%");
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $offset);
        return $this->db->resultSet();
    }

    public function getJumlahCariKategori($key)
    {
        $query = "SELECT COUNT(*) as jumlah FROM " . $this->table . " WHERE nama_kategori LIKE :key";
        $this->db->query($query);
        $this->db->bind('key', "%$key%");
        return $this->db->single()['jumlah'];
    }
}