<?php

class Petugas extends Controller {
    public function __construct()
    {	
        if (!isset($_SESSION['session_login'])) {
            Flasher::setMessage('Login', 'Tidak ditemukan.', 'danger');
            header('location: ' . base_url . '/login');
            exit;
        }
    } 

    public function index()
    {
        $data['title'] = 'Data Petugas';

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Cek apakah ada kata kunci pencarian di session
        $key = $_SESSION['search_key'] ?? '';

        if (!empty($key)) {
            // Ambil data petugas hasil pencarian dengan pagination
            $data['petugas'] = $this->model('PetugasModel')->cariPetugasPagination($key, $limit, $offset);

            // Hitung total data hasil pencarian untuk pagination
            $totalData = $this->model('PetugasModel')->getJumlahCariPetugas($key);
        } else {
            // Ambil semua data petugas dengan pagination
            $data['petugas'] = $this->model('PetugasModel')->getPetugasPagination($limit, $offset);

            // Hitung total data petugas untuk pagination
            $totalData = $this->model('PetugasModel')->getJumlahPetugas();
        }

        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('petugas/index', $data);
        $this->view('templates/footer');
    }

    public function cari()
    {
        $key = htmlspecialchars($_POST['key'] ?? '');
        $_SESSION['search_key'] = $key; // Simpan kata kunci pencarian di session

        $data['title'] = 'Data Petugas';

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Ambil data petugas hasil pencarian dengan pagination
        $data['petugas'] = $this->model('PetugasModel')->cariPetugasPagination($key, $limit, $offset);

        // Hitung total data hasil pencarian untuk pagination
        $totalData = $this->model('PetugasModel')->getJumlahCariPetugas($key);
        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('petugas/index', $data);
        $this->view('templates/footer');
    }

    public function reset()
    {
        // Hapus session pencarian
        unset($_SESSION['search_key']);

        // Redirect ke halaman petugas
        header('location: ' . base_url . '/petugas');
        exit;
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            Flasher::setMessage('Error', 'ID tidak valid.', 'danger');
            header('location: ' . base_url . '/petugas');
            exit;
        }

        $data['title'] = 'Edit Petugas';
        $data['petugas'] = $this->model('PetugasModel')->getPetugasById($id);

        if (!$data['petugas']) {
            Flasher::setMessage('Error', 'Data petugas tidak ditemukan.', 'danger');
            header('location: ' . base_url . '/petugas');
            exit;
        }

        // Cek apakah petugas yang login adalah petugas dengan id terkecil atau petugas yang sedang mengedit data miliknya
        $loggedInPetugasId = $_SESSION['id_petugas'];
        $minIdPetugas = $this->model('PetugasModel')->getMinIdPetugas();

        if ($loggedInPetugasId != $minIdPetugas && $loggedInPetugasId != $id) {
            Flasher::setMessage('Error', 'Anda tidak memiliki izin untuk mengedit data ini.', 'danger');
            header('location: ' . base_url . '/petugas');
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('petugas/edit', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        // Cek apakah petugas yang login adalah petugas dengan id terkecil
        $loggedInPetugasId = $_SESSION['id_petugas'];
        $minIdPetugas = $this->model('PetugasModel')->getMinIdPetugas();

        if ($loggedInPetugasId != $minIdPetugas) {
            Flasher::setMessage('Error', 'Anda tidak memiliki izin untuk menambahkan data petugas.', 'danger');
            header('location: ' . base_url . '/petugas');
            exit;
        }

        $data['title'] = 'Tambah Petugas';		
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('petugas/create', $data);
        $this->view('templates/footer');
    }

    public function simpanPetugas()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Validasi token CSRF
			if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
				Flasher::setMessage('Error', 'Token CSRF tidak valid.', 'danger');
				header('location: ' . base_url . '/petugas/tambah');
				exit;
			}

			// Escape dan validasi input
			$data = [
				'nama' => htmlspecialchars($_POST['nama'] ?? '', ENT_QUOTES, 'UTF-8'),
				'username' => htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8'),
				'password' => $_POST['password'],
				'ulangi_password' => $_POST['ulangi_password']
			];

			if ($data['password'] !== $data['ulangi_password']) {
				Flasher::setMessage('Gagal', 'Password tidak sama.', 'danger');
				header('location: ' . base_url . '/petugas/tambah');
				exit;
			}

			// Cek apakah username sudah digunakan
			if ($this->model('PetugasModel')->cekUsername($data['username'])) {
				Flasher::setMessage('Gagal', 'Username sudah digunakan.', 'danger');
				header('location: ' . base_url . '/petugas/tambah');
				exit;
			}

			// Hash password
			$data['password'] = hash('sha256', $data['password']);

			// Simpan data petugas
			if ($this->model('PetugasModel')->tambahPetugas($data) > 0) {
				Flasher::setMessage('Berhasil', 'ditambahkan', 'success');
				header('location: ' . base_url . '/petugas');
				exit;
			} else {
				Flasher::setMessage('Gagal', 'ditambahkan', 'danger');
				header('location: ' . base_url . '/petugas');
				exit;
			}
		}
	}

    public function updatePetugas()
    {	
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                Flasher::setMessage('Error', 'Token CSRF tidak valid.', 'danger');
                header('location: ' . base_url . '/petugas');
                exit;
            }

            $data = [
                'id' => intval($_POST['id']),
                'nama' => htmlspecialchars($_POST['nama'] ?? ''),
                'password' => $_POST['password'],
                'ulangi_password' => $_POST['ulangi_password']
            ];

            if (!empty($data['password'])) {
                if ($data['password'] !== $data['ulangi_password']) {
                    Flasher::setMessage('Gagal', 'Password tidak sama.', 'danger');
                    header('location: ' . base_url . '/petugas/edit/' . $data['id']);
                    exit;
                }
                // Hash password menggunakan SHA-256
                $data['password'] = hash('sha256', $data['password']);
            }

            if ($this->model('PetugasModel')->updateDataPetugas($data) > 0) {
                Flasher::setMessage('Berhasil', 'diupdate', 'success');
                header('location: ' . base_url . '/petugas');
                exit;			
            } else {
                Flasher::setMessage('Gagal', 'diupdate', 'danger');
                header('location: ' . base_url . '/petugas');
                exit;	
            }
        }
    }

    public function hapus($id)
    {
        Flasher::setMessage('Error', 'Data petugas tidak dapat dihapus.', 'danger');
        header('location: ' . base_url . '/petugas');
        exit;
    }
}