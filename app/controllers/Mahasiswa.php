<?php

class Mahasiswa extends Controller {
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
        $data['title'] = 'Data Mahasiswa';
        $data['mahasiswa'] = $this->model('MahasiswaModel')->getAllMahasiswa();
        #$data['jumlah_mahasiswa'] = $this->model('MahasiswaModel')->getJumlahMahasiswa();
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('mahasiswa/index', $data);
        $this->view('templates/footer');
    }

    public function cari()
    {
        $key = htmlspecialchars($_POST['key'] ?? '');
        $data['title'] = 'Data Mahasiswa';
        $data['mahasiswa'] = $this->model('MahasiswaModel')->cariMahasiswa($key);
        $data['key'] = $key;
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('mahasiswa/index', $data);
        $this->view('templates/footer');
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            Flasher::setMessage('Error', 'ID tidak valid.', 'danger');
            header('location: ' . base_url . '/mahasiswa');
            exit;
        }

        $data['title'] = 'Detail Mahasiswa';
        $data['mahasiswa'] = $this->model('MahasiswaModel')->getMahasiswaById($id);

        if (!$data['mahasiswa']) {
            Flasher::setMessage('Error', 'Data mahasiswa tidak ditemukan.', 'danger');
            header('location: ' . base_url . '/mahasiswa');
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('mahasiswa/edit', $data);
        $this->view('templates/footer');
    }

    public function tambah() 
    {
        $data['title'] = 'Tambah Mahasiswa';		
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('mahasiswa/create', $data);
        $this->view('templates/footer');
    }

    public function simpanMahasiswa()
    {		
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                Flasher::setMessage('Error', 'Token CSRF tidak valid.', 'danger');
                header('location: ' . base_url . '/mahasiswa');
                exit;
            }

            $data = [
                'nim' => htmlspecialchars($_POST['nim'] ?? ''),
                'nama' => htmlspecialchars($_POST['nama'] ?? ''),
                'jurusan' => htmlspecialchars($_POST['jurusan'] ?? ''),
                'alamat' => htmlspecialchars($_POST['alamat'] ?? '')
            ];

            if ($this->model('MahasiswaModel')->tambahMahasiswa($data) > 0) {
                Flasher::setMessage('Berhasil', 'ditambahkan', 'success');
                header('location: ' . base_url . '/mahasiswa');
                exit;			
            } else {
                Flasher::setMessage('Gagal', 'ditambahkan', 'danger');
                header('location: ' . base_url . '/mahasiswa');
                exit;	
            }
        }
    }

    public function updateMahasiswa()
    {	
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                Flasher::setMessage('Error', 'Token CSRF tidak valid.', 'danger');
                header('location: ' . base_url . '/mahasiswa');
                exit;
            }

            $data = [
                'id' => intval($_POST['id'] ?? 0),
                'nim' => htmlspecialchars($_POST['nim'] ?? ''),
                'nama' => htmlspecialchars($_POST['nama'] ?? ''),
                'jurusan' => htmlspecialchars($_POST['jurusan'] ?? ''),
                'alamat' => htmlspecialchars($_POST['alamat'] ?? '')
            ];

            if ($this->model('MahasiswaModel')->updateDataMahasiswa($data) > 0) {
                Flasher::setMessage('Berhasil', 'diupdate', 'success');
                header('location: ' . base_url . '/mahasiswa');
                exit;			
            } else {
                Flasher::setMessage('Gagal', 'diupdate', 'danger');
                header('location: ' . base_url . '/mahasiswa');
                exit;	
            }
        }
    }

    public function hapus($id)
    {
        if (!is_numeric($id)) {
            Flasher::setMessage('Error', 'ID tidak valid.', 'danger');
            header('location: ' . base_url . '/mahasiswa');
            exit;
        }

        if ($this->model('MahasiswaModel')->deleteMahasiswa($id) > 0) {
            Flasher::setMessage('Berhasil', 'dihapus', 'success');
            header('location: ' . base_url . '/mahasiswa');
            exit;			
        } else {
            Flasher::setMessage('Gagal', 'dihapus', 'danger');
            header('location: ' . base_url . '/mahasiswa');
            exit;	
        }
    }
}