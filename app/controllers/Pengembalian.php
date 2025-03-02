<?php

class Pengembalian extends Controller {
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
        $data['title'] = 'Data Pengembalian';

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Cek apakah ada kata kunci pencarian di session
        $key = $_SESSION['search_key'] ?? '';

        if (!empty($key)) {
            // Ambil data pengembalian hasil pencarian dengan pagination
            $data['pengembalian'] = $this->model('PengembalianModel')->cariPengembalianPagination($key, $limit, $offset);

            // Hitung total data hasil pencarian untuk pagination
            $totalData = $this->model('PengembalianModel')->getJumlahCariPengembalian($key);
        } else {
            // Ambil semua data pengembalian dengan pagination
            $data['pengembalian'] = $this->model('PengembalianModel')->getPengembalianPagination($limit, $offset);

            // Hitung total data pengembalian untuk pagination
            $totalData = $this->model('PengembalianModel')->getJumlahPengembalian();
        }

        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('pengembalian/index', $data);
        $this->view('templates/footer');
    }

    public function cari()
    {
        $key = htmlspecialchars($_POST['key'] ?? '');
        $_SESSION['search_key'] = $key; // Simpan kata kunci pencarian di session

        $data['title'] = 'Data Pengembalian';

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Ambil data pengembalian hasil pencarian dengan pagination
        $data['pengembalian'] = $this->model('PengembalianModel')->cariPengembalianPagination($key, $limit, $offset);

        // Hitung total data hasil pencarian untuk pagination
        $totalData = $this->model('PengembalianModel')->getJumlahCariPengembalian($key);
        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('pengembalian/index', $data);
        $this->view('templates/footer');
    }

    public function reset()
    {
        // Hapus session pencarian
        unset($_SESSION['search_key']);

        // Redirect ke halaman pengembalian
        header('location: ' . base_url . '/pengembalian');
        exit;
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            Flasher::setMessage('Error', 'ID tidak valid.', 'danger');
            header('location: ' . base_url . '/pengembalian');
            exit;
        }

        $data['title'] = 'Edit Pengembalian';
        $data['pengembalian'] = $this->model('PengembalianModel')->getPengembalianById($id);

        if (!$data['pengembalian']) {
            Flasher::setMessage('Error', 'Data pengembalian tidak ditemukan.', 'danger');
            header('location: ' . base_url . '/pengembalian');
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('pengembalian/edit', $data);
        $this->view('templates/footer');
    }

    public function updatePengembalian()
    {	
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                Flasher::setMessage('Error', 'Token CSRF tidak valid.', 'danger');
                header('location: ' . base_url . '/pengembalian');
                exit;
            }

            $data = [
                'id' => intval($_POST['id']),
                'denda' => floatval($_POST['denda'])
            ];

            if ($this->model('PengembalianModel')->updatePengembalian($data) > 0) {
                Flasher::setMessage('Berhasil', 'diupdate', 'success');
                header('location: ' . base_url . '/pengembalian');
                exit;			
            } else {
                Flasher::setMessage('Gagal', 'diupdate', 'danger');
                header('location: ' . base_url . '/pengembalian');
                exit;	
            }
        }
    }
}