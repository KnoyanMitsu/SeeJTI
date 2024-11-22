<?php
session_start();
require_once 'config/koneksi.php';

class LoginController {
    private $db;
    private $koneksi;

    public function __construct() {
        $this->db = new Database();
        $this->koneksi = $this->db->getKoneksi();
    }

    public function prosesLogin($username, $password) {
        // Validasi input
        if (empty($username) || empty($password)) {
            return [
                'status' => false, 
                'message' => 'Username dan password tidak boleh kosong'
            ];
        }

        // Escape input untuk mencegah SQL Injection
        $username = $this->koneksi->real_escape_string($username);

        // Query untuk mencari user
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->koneksi->query($query);

        // Cek apakah user ditemukan
        if ($result->num_rows == 0) {
            return [
                'status' => false, 
                'message' => 'Username tidak ditemukan'
            ];
        }

        // Ambil data user
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            return [
                'status' => false, 
                'message' => 'Password salah'
            ];
        }

        // Proses login berhasil
        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['level'] = $user['level'];

        // Redirect berdasarkan level
        return [
            'status' => true,
            'redirect' => $this->tentukanHalaman($user['level'])
        ];
    }

    private function tentukanHalaman($level) {
        switch ($level) {
            case 'Admin':
                return 'admin/dashboard.php';
            case 'User':
                // Cek apakah user adalah ketua kelas
                $cekKetuaKelas = $this->cekKetuaKelas($_SESSION['id_user']);
                return $cekKetuaKelas ? 'ketua_kelas/dashboard.php' : 'user/dashboard.php';
            default:
                return 'login.php';
        }
    }

    private function cekKetuaKelas($id_user) {
        $query = "SELECT * FROM ketua_kelas WHERE id_user = '$id_user'";
        $result = $this->koneksi->query($query);
        return $result->num_rows > 0;
    }

    public function prosesLogout() {
        // Hapus semua session
        session_unset();
        session_destroy();

        // Redirect ke halaman login
        header('Location: login.php');
        exit();
    }
}

// Proses Login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loginController = new LoginController();
    $hasil = $loginController->prosesLogin($_POST['username'], $_POST['password']);

    if ($hasil['status']) {
        // Login berhasil, redirect ke halaman sesuai level
        header('Location: ' . $hasil['redirect']);
        exit();
    } else {
        // Login gagal, tampilkan pesan error
        $error = $hasil['message'];
    }
}
?>