<?php

namespace App\Controllers;

use App\Models\UserModel;
// UserRoleModel dihapus karena kita sudah memindahkan role_id ke tabel users

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Jika sudah login, lempar ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        
        $data = [
            'title' => 'Login | PT Humanika Mitra Solusi'
        ];
        
        return view('auth/login', $data);
    }

    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // 1. Cari user berdasarkan email
        $user = $this->userModel->where('email', $email)->first();

        if ($user) {
            // 2. Cek status aktif
            if (!isset($user['active']) || !$user['active']) {
                return redirect()->back()->with('error', 'Akun Anda dinonaktifkan. Silakan hubungi administrator.');
            }

            // 3. Verifikasi password
            if (password_verify($password, $user['password'])) {
                
                // 4. Ambil data user lengkap dengan nama role-nya (JOIN)
                // Menggunakan fungsi yang sudah kita buat di UserModel
                $userFull = $this->userModel->getUserWithRole($user['id']);

                $sessionData = [
                    'id'         => $userFull['id'],
                    'username'   => $userFull['username'],
                    'email'      => $userFull['email'],
                    'role_name'  => $userFull['role_name'], // Isinya: 'develop' atau 'client'
                    'company_id' => $userFull['company_id'],
                    'company_id' => $this->request->getPost('company_id') ?: null, // <--- Nama Perusahaan juga disimpan agar gampang dipanggil
                    'logged_in'  => true,
                ];

                session()->set($sessionData);

                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', 'Password salah.');
            }
        } else {
            return redirect()->back()->with('error', 'Email tidak terdaftar.');
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // PERBAIKAN: Langsung masukkan role_id ke tabel users (Normalisasi)
        // Kita asumsikan ID 2 adalah 'client' sesuai gambar tabel role Anda
        $this->userModel->insert([
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => $this->request->getPost('password'), // Hash otomatis di Model
            'role_id'    => 2, // Default role sebagai client
            'active'     => 1  // Langsung aktifkan
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout()
    {
        // Hapus semua session
        session()->destroy();
        return redirect()->to('/login');
    }
}