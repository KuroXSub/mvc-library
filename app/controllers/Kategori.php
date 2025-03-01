<?php

class Kategori extends Controller {
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
        $data['title'] = 'Data Kategori';
        $data['kategori'] = $this->model('KategoriModel')->getAllKategori();
        #$data['jumlah_kategori'] = $this->model('KategoriModel')->getJumlahKategori(); // Ambil jumlah kategori
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('kategori/index', $data);
        $this->view('templates/footer');
    }

    public function cari()
    {
        $key = htmlspecialchars($_POST['key'] ?? '');
        $data['title'] = 'Data Kategori';
        $data['kategori'] = $this->model('KategoriModel')->cariKategori($key);
        $data['key'] = $key;
        #$data['jumlah_kategori'] = $this->model('KategoriModel')->getJumlahKategori(); // Ambil jumlah kategori
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('kategori/index', $data);
        $this->view('templates/footer');
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            Flasher::setMessage('Error', 'ID tidak valid.', 'danger');
            header('location: ' . base_url . '/kategori');
            exit;
        }

        $data['title'] = 'Detail Kategori';
        $data['kategori'] = $this->model('KategoriModel')->getKategoriById($id);

        if (!$data['kategori']) {
            Flasher::setMessage('Error', 'Data kategori tidak ditemukan.', 'danger');
            header('location: ' . base_url . '/kategori');
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('kategori/edit', $data);
        $this->view('templates/footer');
    }

    public function tambah() 
    {
        $data['title'] = 'Tambah Kategori';		
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('kategori/create', $data);
        $this->view('templates/footer');
    }

    public function simpanKategori()
    {		
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                Flasher::setMessage('Error', 'Token CSRF tidak valid.', 'danger');
                header('location: ' . base_url . '/kategori');
                exit;
            }

            $data = [
                'nama_kategori' => htmlspecialchars($_POST['nama_kategori'] ?? '')
            ];

            if ($this->model('KategoriModel')->tambahKategori($data) > 0) {
                Flasher::setMessage('Berhasil', 'ditambahkan', 'success');
                header('location: ' . base_url . '/kategori');
                exit;			
            } else {
                Flasher::setMessage('Gagal', 'ditambahkan', 'danger');
                header('location: ' . base_url . '/kategori');
                exit;	
            }
        }
    }

    public function updateKategori()
    {	
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                Flasher::setMessage('Error', 'Token CSRF tidak valid.', 'danger');
                header('location: ' . base_url . '/kategori');
                exit;
            }

            $data = [
                'id' => intval($_POST['id'] ?? 0),
                'nama_kategori' => htmlspecialchars($_POST['nama_kategori'] ?? '')
            ];

            if ($this->model('KategoriModel')->updateDataKategori($data) > 0) {
                Flasher::setMessage('Berhasil', 'diupdate', 'success');
                header('location: ' . base_url . '/kategori');
                exit;			
            } else {
                Flasher::setMessage('Gagal', 'diupdate', 'danger');
                header('location: ' . base_url . '/kategori');
                exit;	
            }
        }
    }

    public function hapus($id)
    {
        if (!is_numeric($id)) {
            Flasher::setMessage('Error', 'ID tidak valid.', 'danger');
            header('location: ' . base_url . '/kategori');
            exit;
        }

        if ($this->model('KategoriModel')->deleteKategori($id) > 0) {
            Flasher::setMessage('Berhasil', 'dihapus', 'success');
            header('location: ' . base_url . '/kategori');
            exit;			
        } else {
            Flasher::setMessage('Gagal', 'dihapus', 'danger');
            header('location: ' . base_url . '/kategori');
            exit;	
        }
    }
}