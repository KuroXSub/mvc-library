<?php

class Home extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['session_login']) || $_SESSION['session_login'] != 'sudah_login') {
            Flasher::setMessage('Login', 'Tidak ditemukan.', 'danger');
            header('location: ' . base_url . '/login');
            exit;
        }
    }

    public function index()
    {
        $data['title'] = 'Dashboard';

        // Ambil jumlah data dari model
        $data['jumlah_kategori'] = $this->model('KategoriModel')->getJumlahKategori();
        $data['jumlah_buku'] = $this->model('BukuModel')->getJumlahBuku();
        $data['jumlah_mahasiswa'] = $this->model('MahasiswaModel')->getJumlahMahasiswa();
        $data['jumlah_peminjaman'] = $this->model('PeminjamanModel')->getJumlahPeminjaman();

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}