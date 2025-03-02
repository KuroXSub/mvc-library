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

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Cek apakah ada kata kunci pencarian di session
        $key = $_SESSION['search_key'] ?? '';

        if (!empty($key)) {
            // Ambil data mahasiswa hasil pencarian dengan pagination
            $data['mahasiswa'] = $this->model('MahasiswaModel')->cariMahasiswaPagination($key, $limit, $offset);

            // Hitung total data hasil pencarian untuk pagination
            $totalData = $this->model('MahasiswaModel')->getJumlahCariMahasiswa($key);
        } else {
            // Ambil semua data mahasiswa dengan pagination
            $data['mahasiswa'] = $this->model('MahasiswaModel')->getMahasiswaPagination($limit, $offset);

            // Hitung total data mahasiswa untuk pagination
            $totalData = $this->model('MahasiswaModel')->getJumlahMahasiswa();
        }

        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('mahasiswa/index', $data);
        $this->view('templates/footer');
    }

    public function cari()
    {
        $key = htmlspecialchars($_POST['key'] ?? '');
        $_SESSION['search_key'] = $key; // Simpan kata kunci pencarian di session

        $data['title'] = 'Data Mahasiswa';

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Ambil data mahasiswa hasil pencarian dengan pagination
        $data['mahasiswa'] = $this->model('MahasiswaModel')->cariMahasiswaPagination($key, $limit, $offset);

        // Hitung total data hasil pencarian untuk pagination
        $totalData = $this->model('MahasiswaModel')->getJumlahCariMahasiswa($key);
        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('mahasiswa/index', $data);
        $this->view('templates/footer');
    }

    public function reset()
    {
        // Hapus session pencarian
        unset($_SESSION['search_key']);

        // Redirect ke halaman mahasiswa
        header('location: ' . base_url . '/mahasiswa');
        exit;
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

            // Ambil data mahasiswa saat ini
            $mahasiswaSaatIni = $this->model('MahasiswaModel')->getMahasiswaById($data['id']);

            // Cek apakah ada perubahan data
            if (
                $mahasiswaSaatIni['nim'] === $data['nim'] &&
                $mahasiswaSaatIni['nama'] === $data['nama'] &&
                $mahasiswaSaatIni['jurusan'] === $data['jurusan'] &&
                $mahasiswaSaatIni['alamat'] === $data['alamat']
            ) {
                // Jika tidak ada perubahan, tampilkan pesan berhasil
                Flasher::setMessage('Berhasil', 'diupdate (tidak ada perubahan)', 'success');
            } else {
                // Jika ada perubahan, lakukan update
                if ($this->model('MahasiswaModel')->updateDataMahasiswa($data) > 0) {
                    Flasher::setMessage('Berhasil', 'diupdate', 'success');
                } else {
                    Flasher::setMessage('Gagal', 'diupdate', 'danger');
                }
            }

            header('location: ' . base_url . '/mahasiswa');
            exit;
        }
    }

    public function hapus($id)
    {
        if (!is_numeric($id)) {
            Flasher::setMessage('Error', 'ID tidak valid.', 'danger');
            header('location: ' . base_url . '/mahasiswa');
            exit;
        }

        if ($this->model('MahasiswaModel')->isMahasiswaTerpakai($id)) {
            Flasher::setMessage('Gagal', 'Mahasiswa tidak dapat dihapus karena terikat dengan data peminjaman.', 'danger');
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