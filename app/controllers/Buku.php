<?php

class Buku extends Controller {
    public function __construct()
    {	
        // Pastikan session sudah dimulai
        if (!isset($_SESSION)) {
            session_start();
        }

        // Cek apakah pengguna sudah login
        if (!isset($_SESSION['session_login']) || $_SESSION['session_login'] != 'sudah_login') {
            Flasher::setMessage('Login', 'Tidak ditemukan.', 'danger');
            header('location: ' . base_url . '/login');
            exit;
        }
    } 

    public function index()
    {
        $data['title'] = 'Data Buku';

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Cek apakah ada kata kunci pencarian di session
        $key = $_SESSION['search_key'] ?? '';

        if (!empty($key)) {
            // Ambil data buku hasil pencarian dengan pagination
            $data['buku'] = $this->model('BukuModel')->cariBukuPagination($key, $limit, $offset);

            // Hitung total data hasil pencarian untuk pagination
            $totalData = $this->model('BukuModel')->getJumlahCariBuku($key);
        } else {
            // Ambil semua data buku dengan pagination
            $data['buku'] = $this->model('BukuModel')->getBukuPagination($limit, $offset);

            // Hitung total data buku untuk pagination
            $totalData = $this->model('BukuModel')->getJumlahBuku();
        }

        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('buku/index', $data);
        $this->view('templates/footer');
    }

    public function cari()
    {
        $key = htmlspecialchars($_POST['key'] ?? '');
        $_SESSION['search_key'] = $key; // Simpan kata kunci pencarian di session

        $data['title'] = 'Data Buku';

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Ambil data buku hasil pencarian dengan pagination
        $data['buku'] = $this->model('BukuModel')->cariBukuPagination($key, $limit, $offset);

        // Hitung total data hasil pencarian untuk pagination
        $totalData = $this->model('BukuModel')->getJumlahCariBuku($key);
        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('buku/index', $data);
        $this->view('templates/footer');
    }

    public function edit($id)
    {
        // Validasi ID
        if (!is_numeric($id)) {
            Flasher::setMessage('Error', 'ID tidak valid.', 'danger');
            header('location: ' . base_url . '/buku');
            exit;
        }

        $data['title'] = 'Detail Buku';
        $data['kategori'] = $this->model('KategoriModel')->getAllKategori();
        $data['buku'] = $this->model('BukuModel')->getBukuById($id);

        // Cek apakah data buku ditemukan
        if (!$data['buku']) {
            Flasher::setMessage('Error', 'Data buku tidak ditemukan.', 'danger');
            header('location: ' . base_url . '/buku');
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('buku/edit', $data);
        $this->view('templates/footer');
    }

    public function tambah() 
    {
        $data['title'] = 'Tambah Buku';
        $data['kategori'] = $this->model('KategoriModel')->getAllKategori();		
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('buku/create', $data);
        $this->view('templates/footer');
    }

    public function simpanBuku()
    {		
        // Validasi input
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = [
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'penulis' => htmlspecialchars($_POST['penulis'] ?? ''),
                'kategori_id' => intval($_POST['kategori_id'] ?? 0),
                'tahun_terbit' => intval($_POST['tahun_terbit'] ?? 0),
                'stok' => intval($_POST['stok'] ?? 0)
            ];

            if ($this->model('BukuModel')->tambahBuku($input) > 0) {
                Flasher::setMessage('Berhasil', 'ditambahkan', 'success');
                header('location: ' . base_url . '/buku');
                exit;			
            } else {
                Flasher::setMessage('Gagal', 'ditambahkan', 'danger');
                header('location: ' . base_url . '/buku');
                exit;	
            }
        } else {
            Flasher::setMessage('Error', 'Metode request tidak valid.', 'danger');
            header('location: ' . base_url . '/buku');
            exit;
        }
    }

    public function updateBuku()
    {
        // Validasi input
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['csrf_token'])) {
                Flasher::setMessage('Error', 'Token CSRF tidak ditemukan.', 'danger');
                header('location: ' . base_url . '/buku');
                exit;
            }

            if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                Flasher::setMessage('Error', 'Token CSRF tidak valid.', 'danger');
                header('location: ' . base_url . '/buku');
                exit;
            }

            $input = [
                'id' => intval($_POST['id'] ?? 0),
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'penulis' => htmlspecialchars($_POST['penulis'] ?? ''),
                'kategori_id' => intval($_POST['kategori_id'] ?? 0),
                'tahun_terbit' => intval($_POST['tahun_terbit'] ?? 0),
                'stok' => intval($_POST['stok'] ?? 0)
            ];

            // Ambil data buku saat ini
            $bukuSaatIni = $this->model('BukuModel')->getBukuById($input['id']);

            // Cek apakah ada perubahan data
            if (
                $bukuSaatIni['judul'] === $input['judul'] &&
                $bukuSaatIni['penulis'] === $input['penulis'] &&
                $bukuSaatIni['kategori_id'] === $input['kategori_id'] &&
                $bukuSaatIni['tahun_terbit'] === $input['tahun_terbit'] &&
                $bukuSaatIni['stok'] === $input['stok']
            ) {
                // Jika tidak ada perubahan, tampilkan pesan berhasil
                Flasher::setMessage('Berhasil', 'diupdate (tidak ada perubahan)', 'success');
            } else {
                // Jika ada perubahan, lakukan update
                if ($this->model('BukuModel')->updateDataBuku($input) > 0) {
                    Flasher::setMessage('Berhasil', 'diupdate', 'success');
                } else {
                    Flasher::setMessage('Gagal', 'diupdate', 'danger');
                }
            }

            header('location: ' . base_url . '/buku');
            exit;
        } else {
            Flasher::setMessage('Error', 'Metode request tidak valid.', 'danger');
            header('location: ' . base_url . '/buku');
            exit;
        }
    }

    public function hapus($id)
    {
        // Validasi ID
        if (!is_numeric($id)) {
            Flasher::setMessage('Error', 'ID tidak valid.', 'danger');
            header('location: ' . base_url . '/buku');
            exit;
        }

        // Cek apakah Buku terikat dengan peminjaman
        if ($this->model('BukuModel')->isBukuTerpakai($id)) {
            Flasher::setMessage('Gagal', 'Buku tidak dapat dihapus karena terikat dengan data peminjaman.', 'danger');
            header('location: ' . base_url . '/buku');
            exit;
        }

        if ($this->model('BukuModel')->deleteBuku($id) > 0) {
            Flasher::setMessage('Berhasil', 'dihapus', 'success');
            header('location: ' . base_url . '/buku');
            exit;			
        } else {
            Flasher::setMessage('Gagal', 'dihapus', 'danger');
            header('location: ' . base_url . '/buku');
            exit;	
        }
    }

    public function reset()
    {
        // Hapus session pencarian
        unset($_SESSION['search_key']);

        // Redirect ke halaman buku
        header('location: ' . base_url . '/buku');
        exit;
    }
}