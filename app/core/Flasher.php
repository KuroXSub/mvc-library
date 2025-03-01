<?php

class Flasher {
    public static function setMessage($pesan, $aksi, $tipe) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['flash'] = [
            'pesan' => htmlspecialchars($pesan),
            'aksi' => htmlspecialchars($aksi),
            'tipe' => htmlspecialchars($tipe)
        ];
    }

    public static function flash() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['flash'])) {
            echo '<div class="alert alert-' . htmlspecialchars($_SESSION['flash']['tipe']) . ' alert-dismissible fade show">
                    ' . htmlspecialchars($_SESSION['flash']['pesan']) . ' ' . htmlspecialchars($_SESSION['flash']['aksi']) . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            unset($_SESSION['flash']);
        }
    }
}