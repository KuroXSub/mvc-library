<?php

class Login extends Controller {
    public function index()
    {
        $data['title'] = 'Halaman Login';
        $this->view('login/login', $data);
    }

    public function prosesLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi CSRF token
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                Flasher::setMessage('Error', 'Token CSRF tidak valid.', 'danger');
                header('location: ' . base_url . '/login');
                exit;
            }

            // Validasi input
            $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');

            if (empty($username) || empty($password)) {
                Flasher::setMessage('Error', 'Username dan password harus diisi.', 'danger');
                header('location: ' . base_url . '/login');
                exit;
            }

            // Cek login
            $row = $this->model('LoginModel')->checkLogin($username, $password);

            if ($row) {
                // Set session
                $_SESSION['username'] = $row['username'];
                $_SESSION['nama'] = $row['nama'];
                $_SESSION['session_login'] = 'sudah_login';
                $_SESSION['id_petugas'] = $row['id']; // Simpan ID petugas jika diperlukan

                // Redirect ke halaman home
                header('location: ' . base_url . '/home');
                exit;
            } else {
                Flasher::setMessage('Error', 'Username atau password salah.', 'danger');
                header('location: ' . base_url . '/login');
                exit;
            }
        } else {
            Flasher::setMessage('Error', 'Metode request tidak valid.', 'danger');
            header('location: ' . base_url . '/login');
            exit;
        }
    }
}