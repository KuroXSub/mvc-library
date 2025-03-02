<?php

class Peminjaman extends Controller {
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
        $data['title'] = 'Data Peminjaman';

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Cek apakah ada kata kunci pencarian di session
        $key = $_SESSION['search_key'] ?? '';

        if (!empty($key)) {
            // Ambil data peminjaman hasil pencarian dengan pagination
            $data['peminjaman'] = $this->model('PeminjamanModel')->cariPeminjamanPagination($key, $limit, $offset);

            // Hitung total data hasil pencarian untuk pagination
            $totalData = $this->model('PeminjamanModel')->getJumlahCariPeminjaman($key);
        } else {
            // Ambil semua data peminjaman dengan pagination
            $data['peminjaman'] = $this->model('PeminjamanModel')->getPeminjamanPagination($limit, $offset);

            // Hitung total data peminjaman untuk pagination
            $totalData = $this->model('PeminjamanModel')->getJumlahPeminjaman();
        }

        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('peminjaman/index', $data);
        $this->view('templates/footer');
    }

    public function cari()
    {
        $key = htmlspecialchars($_POST['key'] ?? '');
        $_SESSION['search_key'] = $key; // Simpan kata kunci pencarian di session

        $data['title'] = 'Data Peminjaman';

        // Ambil nomor halaman dari URL, default ke 1 jika tidak ada
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset

        // Ambil data peminjaman hasil pencarian dengan pagination
        $data['peminjaman'] = $this->model('PeminjamanModel')->cariPeminjamanPagination($key, $limit, $offset);

        // Hitung total data hasil pencarian untuk pagination
        $totalData = $this->model('PeminjamanModel')->getJumlahCariPeminjaman($key);
        $data['totalPages'] = ceil($totalData / $limit); // Hitung total halaman
        $data['currentPage'] = $page; // Simpan halaman saat ini
        $data['key'] = $key; // Simpan kata kunci pencarian

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('peminjaman/index', $data);
        $this->view('templates/footer');
    }

    public function reset()
    {
        // Hapus session pencarian
        unset($_SESSION['search_key']);

        // Redirect ke halaman peminjaman
        header('location: ' . base_url . '/peminjaman');
        exit;
    }

    public function tambah() 
    {
        $data['title'] = 'Tambah Peminjaman';
        $data['mahasiswa'] = $this->model('MahasiswaModel')->getAllMahasiswa();
        $data['buku'] = $this->model('BukuModel')->getAllBuku();
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('peminjaman/create', $data);
        $this->view('templates/footer');
    }

    public function simpanPeminjaman()
    {		
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                Flasher::setMessage('Error', 'Token CSRF tidak valid.', 'danger');
                header('location: ' . base_url . '/peminjaman');
                exit;
            }

            // Ambil ID petugas dari session
            $petugas_id = $_SESSION['id_petugas'];

            $data = [
                'mahasiswa_id' => intval($_POST['mahasiswa_id']),
                'buku_id' => intval($_POST['buku_id']),
                'petugas_id' => $petugas_id,
                'tanggal_pinjam' => date('Y-m-d') // Tanggal pinjam diisi otomatis hari ini
            ];

            if ($this->model('PeminjamanModel')->tambahPeminjaman($data) > 0) {
                Flasher::setMessage('Berhasil', 'ditambahkan', 'success');
                header('location: ' . base_url . '/peminjaman');
                exit;			
            } else {
                Flasher::setMessage('Gagal', 'ditambahkan', 'danger');
                header('location: ' . base_url . '/peminjaman');
                exit;	
            }
        }
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            Flasher::setMessage('Error', 'ID tidak valid.', 'danger');
            header('location: ' . base_url . '/peminjaman');
            exit;
        }

        $data['title'] = 'Detail Peminjaman';
        $data['peminjaman'] = $this->model('PeminjamanModel')->getPeminjamanById($id);

        if (!$data['peminjaman']) {
            Flasher::setMessage('Error', 'Data peminjaman tidak ditemukan.', 'danger');
            header('location: ' . base_url . '/peminjaman');
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('peminjaman/edit', $data);
        $this->view('templates/footer');
    }

    public function updatePeminjaman()
    {	
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                Flasher::setMessage('Error', 'Token CSRF tidak valid.', 'danger');
                header('location: ' . base_url . '/peminjaman');
                exit;
            }

            $data = [
                'id' => intval($_POST['id']),
                'tanggal_kembali' => $_POST['tanggal_kembali'],
                'status' => 'dikembalikan'
            ];

            // Update status peminjaman menjadi "dikembalikan"
            if ($this->model('PeminjamanModel')->updatePeminjaman($data) > 0) {
                // Hitung denda
                $peminjaman = $this->model('PeminjamanModel')->getPeminjamanById($data['id']);
                $denda = $this->hitungDenda($peminjaman['tanggal_pinjam'], $data['tanggal_kembali']);

                // Simpan data pengembalian
                $dataPengembalian = [
                    'peminjaman_id' => $data['id'],
                    'tanggal_kembali' => $data['tanggal_kembali'],
                    'denda' => $denda
                ];

                if ($this->model('PengembalianModel')->tambahPengembalian($dataPengembalian) > 0) {
                    Flasher::setMessage('Berhasil', 'dikembalikan', 'success');
                    header('location: ' . base_url . '/peminjaman');
                    exit;			
                } else {
                    Flasher::setMessage('Gagal', 'menyimpan pengembalian', 'danger');
                    header('location: ' . base_url . '/peminjaman');
                    exit;	
                }
            } else {
                Flasher::setMessage('Gagal', 'mengupdate peminjaman', 'danger');
                header('location: ' . base_url . '/peminjaman');
                exit;	
            }
        }
    }

    private function hitungDenda($tanggal_pinjam, $tanggal_kembali)
    {
        $denda_per_hari = 5000; // Contoh: Denda Rp 5.000 per hari
        $tanggal_pinjam = new DateTime($tanggal_pinjam);
        $tanggal_kembali = new DateTime($tanggal_kembali);
        $interval = $tanggal_pinjam->diff($tanggal_kembali);
        $hari_terlambat = $interval->days - 14; // Batas waktu peminjaman 14 hari

        if ($hari_terlambat > 0) {
            return $hari_terlambat * $denda_per_hari;
        } else {
            return 0;
        }
    }
}