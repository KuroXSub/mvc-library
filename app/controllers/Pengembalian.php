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
        $data['pengembalian'] = $this->model('PengembalianModel')->getAllPengembalian();
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('pengembalian/index', $data);
        $this->view('templates/footer');
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