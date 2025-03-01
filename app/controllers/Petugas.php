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
        $data['petugas'] = $this->model('PetugasModel')->getAllPetugasExceptMinId();
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('petugas/index', $data);
        $this->view('templates/footer');
    }

    public function cari()
    {
        $key = htmlspecialchars($_POST['key'] ?? '');
        $data['title'] = 'Data Petugas';
        $data['petugas'] = $this->model('PetugasModel')->cariPetugas($key);
        $data['key'] = $key;
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('petugas/index', $data);
        $this->view('templates/footer');
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