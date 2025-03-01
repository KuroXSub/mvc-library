<?php

class Logout extends Controller {
    public function index()
    {
        // Mulai session jika belum dimulai
        if (!session_id()) {
            session_start();
        }

        // Hapus semua data session
        session_unset();
        session_destroy();

        // Redirect ke halaman login
        header('location: ' . base_url . '/login');
        exit;
    }

    public function confirmLogout()
    {
        $data['title'] = 'Konfirmasi Logout';
        $this->view('templates/header', $data);
        $this->view('templates/modal_logout', $data); // Modal konfirmasi logout
        $this->view('templates/footer');
    }
}