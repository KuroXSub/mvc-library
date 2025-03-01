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
		$orderBy = $_GET['orderBy'] ?? 'judul'; // Default sorting by 'judul'
		$orderDirection = $_GET['orderDirection'] ?? 'ASC'; // Default order direction

		$data['title'] = 'Data Buku';
		$data['buku'] = $this->model('BukuModel')->getAllBuku($orderBy, $orderDirection);
        #$data['jumlah_buku'] = $this->model('BukuModel')->getJumlahBuku();
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('buku/index', $data);
		$this->view('templates/footer');
	}

    public function cari()
    {
        // Validasi input pencarian
        $key = isset($_POST['key']) ? htmlspecialchars($_POST['key']) : '';
        
        $data['title'] = 'Data Buku';
        $data['buku'] = $this->model('BukuModel')->cariBuku($key);
        $data['key'] = $key;
        #$data['jumlah_buku'] = $this->model('BukuModel')->getJumlahBuku();
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
            $input = [
                'id' => intval($_POST['id'] ?? 0),
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'penulis' => htmlspecialchars($_POST['penulis'] ?? ''),
                'kategori_id' => intval($_POST['kategori_id'] ?? 0),
                'tahun_terbit' => intval($_POST['tahun_terbit'] ?? 0),
                'stok' => intval($_POST['stok'] ?? 0)
            ];

            if ($this->model('BukuModel')->updateDataBuku($input) > 0) {
                Flasher::setMessage('Berhasil', 'diupdate', 'success');
                header('location: ' . base_url . '/buku');
                exit;			
            } else {
                Flasher::setMessage('Gagal', 'diupdate', 'danger');
                header('location: ' . base_url . '/buku');
                exit;	
            }
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
}