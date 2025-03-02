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

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Cek apakah ada kata kunci pencarian di session
        $key = $_SESSION['search_key'] ?? '';

        if (!empty($key)) {
            // Ambil data kategori hasil pencarian dengan pagination
            $data['kategori'] = $this->model('KategoriModel')->cariKategoriPagination($key, $limit, $offset);

            // Hitung total data hasil pencarian untuk pagination
            $totalData = $this->model('KategoriModel')->getJumlahCariKategori($key);
        } else {
            // Ambil semua data kategori dengan pagination
            $data['kategori'] = $this->model('KategoriModel')->getKategoriPagination($limit, $offset);

            // Hitung total data kategori untuk pagination
            $totalData = $this->model('KategoriModel')->getJumlahKategori();
        }

        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('kategori/index', $data);
        $this->view('templates/footer');
    }

    public function cari()
    {
        $key = htmlspecialchars($_POST['key'] ?? '');
        $_SESSION['search_key'] = $key; // Simpan kata kunci pencarian di session

        $data['title'] = 'Data Kategori';

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Ambil data kategori hasil pencarian dengan pagination
        $data['kategori'] = $this->model('KategoriModel')->cariKategoriPagination($key, $limit, $offset);

        // Hitung total data hasil pencarian untuk pagination
        $totalData = $this->model('KategoriModel')->getJumlahCariKategori($key);
        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

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

            // Ambil data kategori saat ini
            $kategoriSaatIni = $this->model('KategoriModel')->getKategoriById($data['id']);

            // Cek apakah ada perubahan data
            if ($kategoriSaatIni['nama_kategori'] === $data['nama_kategori']) {
                // Jika tidak ada perubahan, tetap tampilkan pesan berhasil
                Flasher::setMessage('Berhasil', 'diupdate (tidak ada perubahan)', 'success');
            } else {
                // Jika ada perubahan, lakukan update
                if ($this->model('KategoriModel')->updateDataKategori($data) > 0) {
                    Flasher::setMessage('Berhasil', 'diupdate', 'success');
                } else {
                    Flasher::setMessage('Gagal', 'diupdate', 'danger');
                }
            }

            header('location: ' . base_url . '/kategori');
            exit;
        }
    }

    public function hapus($id)
    {
        if (!is_numeric($id)) {
            Flasher::setMessage('Error', 'ID tidak valid.', 'danger');
            header('location: ' . base_url . '/kategori');
            exit;
        }

        // Cek apakah kategori terikat dengan buku
        if ($this->model('KategoriModel')->isKategoriTerpakai($id)) {
            Flasher::setMessage('Gagal', 'Kategori tidak dapat dihapus karena terikat dengan data buku.', 'danger');
            header('location: ' . base_url . '/kategori');
            exit;
        }

        // Jika tidak terikat, lanjutkan proses hapus
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

    public function reset()
    {
        // Hapus session pencarian
        unset($_SESSION['search_key']);

        // Redirect ke halaman kategori
        header('location: ' . base_url . '/kategori');
        exit;
    }
}