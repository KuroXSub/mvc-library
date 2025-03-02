<?php

class PeminjamanModel {
    private $table = 'peminjaman';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllPeminjaman()
    {
        $this->db->query('SELECT peminjaman.*, mahasiswa.nama AS nama_mahasiswa, buku.judul AS judul_buku, petugas.nama AS nama_petugas 
                          FROM ' . $this->table . ' 
                          JOIN mahasiswa ON mahasiswa.id = peminjaman.mahasiswa_id 
                          JOIN buku ON buku.id = peminjaman.buku_id 
                          JOIN petugas ON petugas.id = peminjaman.petugas_id');
        return $this->db->resultSet();
    }

    public function getPeminjamanById($id)
    {
        $query = "SELECT peminjaman.*, mahasiswa.nama AS nama_mahasiswa, buku.judul AS judul_buku 
                FROM peminjaman 
                JOIN mahasiswa ON mahasiswa.id = peminjaman.mahasiswa_id 
                JOIN buku ON buku.id = peminjaman.buku_id 
                WHERE peminjaman.id = :id";
        $this->db->query($query);
        $this->db->bind('id', intval($id));
        return $this->db->single();
    }

    public function tambahPeminjaman($data)
    {
        $query = "INSERT INTO peminjaman (mahasiswa_id, buku_id, petugas_id, tanggal_pinjam) 
                  VALUES(:mahasiswa_id, :buku_id, :petugas_id, :tanggal_pinjam)";
        $this->db->query($query);
        $this->db->bind('mahasiswa_id', $data['mahasiswa_id']);
        $this->db->bind('buku_id', $data['buku_id']);
        $this->db->bind('petugas_id', $data['petugas_id']);
        $this->db->bind('tanggal_pinjam', $data['tanggal_pinjam']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updatePeminjaman($data)
    {
        $query = "UPDATE peminjaman SET tanggal_kembali=:tanggal_kembali, status=:status WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', $data['id']);
        $this->db->bind('tanggal_kembali', $data['tanggal_kembali']);
        $this->db->bind('status', $data['status']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getJumlahPeminjaman()
    {
        $this->db->query('SELECT COUNT(*) as jumlah FROM ' . $this->table);
        return $this->db->single()['jumlah'];
    }

    public function getPeminjamanPagination($limit, $offset)
    {
        $query = "SELECT peminjaman.*, mahasiswa.nama AS nama_mahasiswa, buku.judul AS judul_buku, petugas.nama AS nama_petugas 
                FROM peminjaman 
                JOIN mahasiswa ON mahasiswa.id = peminjaman.mahasiswa_id 
                JOIN buku ON buku.id = peminjaman.buku_id 
                JOIN petugas ON petugas.id = peminjaman.petugas_id 
                LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $offset);
        return $this->db->resultSet();
    }

    public function cariPeminjamanPagination($key, $limit, $offset)
    {
        $query = "SELECT peminjaman.*, mahasiswa.nama AS nama_mahasiswa, buku.judul AS judul_buku, petugas.nama AS nama_petugas 
                FROM peminjaman 
                JOIN mahasiswa ON mahasiswa.id = peminjaman.mahasiswa_id 
                JOIN buku ON buku.id = peminjaman.buku_id 
                JOIN petugas ON petugas.id = peminjaman.petugas_id 
                WHERE mahasiswa.nama LIKE :key OR buku.judul LIKE :key OR petugas.nama LIKE :key 
                LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind('key', "%$key%");
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $offset);
        return $this->db->resultSet();
    }

    public function getJumlahCariPeminjaman($key)
    {
        $query = "SELECT COUNT(*) as jumlah 
                FROM peminjaman 
                JOIN mahasiswa ON mahasiswa.id = peminjaman.mahasiswa_id 
                JOIN buku ON buku.id = peminjaman.buku_id 
                JOIN petugas ON petugas.id = peminjaman.petugas_id 
                WHERE mahasiswa.nama LIKE :key OR buku.judul LIKE :key OR petugas.nama LIKE :key";
        $this->db->query($query);
        $this->db->bind('key', "%$key%");
        return $this->db->single()['jumlah'];
    }
}