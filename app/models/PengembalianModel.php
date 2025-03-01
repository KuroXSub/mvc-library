<?php

class PengembalianModel {
    private $table = 'pengembalian';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllPengembalian()
    {
        $this->db->query('SELECT pengembalian.*, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali, mahasiswa.nama AS nama_mahasiswa, buku.judul AS judul_buku 
                          FROM ' . $this->table . ' 
                          JOIN peminjaman ON peminjaman.id = pengembalian.peminjaman_id 
                          JOIN mahasiswa ON mahasiswa.id = peminjaman.mahasiswa_id 
                          JOIN buku ON buku.id = peminjaman.buku_id');
        return $this->db->resultSet();
    }

    public function getPengembalianById($id)
    {
        $query = "SELECT pengembalian.*, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali, 
                        mahasiswa.nama AS nama_mahasiswa, buku.judul AS judul_buku 
                FROM pengembalian 
                JOIN peminjaman ON peminjaman.id = pengembalian.peminjaman_id 
                JOIN mahasiswa ON mahasiswa.id = peminjaman.mahasiswa_id 
                JOIN buku ON buku.id = peminjaman.buku_id 
                WHERE pengembalian.id = :id";
        $this->db->query($query);
        $this->db->bind('id', intval($id));
        return $this->db->single();
    }

    public function tambahPengembalian($data)
    {
        $query = "INSERT INTO pengembalian (peminjaman_id, tanggal_kembali, denda) 
                  VALUES(:peminjaman_id, :tanggal_kembali, :denda)";
        $this->db->query($query);
        $this->db->bind('peminjaman_id', $data['peminjaman_id']);
        $this->db->bind('tanggal_kembali', $data['tanggal_kembali']);
        $this->db->bind('denda', $data['denda']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updatePengembalian($data)
    {
        $query = "UPDATE pengembalian SET denda=:denda WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', $data['id']);
        $this->db->bind('denda', $data['denda']);
        $this->db->execute();

        return $this->db->rowCount();
    }
}