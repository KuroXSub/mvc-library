<?php

class Controller {
    public function view($view, $data = []) {
        // Validasi nama view untuk mencegah directory traversal
        $viewPath = '../app/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die('View tidak ditemukan: ' . $view);
        }
    }

    public function model($model) {
        // Validasi nama model untuk mencegah directory traversal
        $modelPath = '../app/models/' . $model . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $model;
        } else {
            die('Model tidak ditemukan: ' . $model);
        }
    }
}