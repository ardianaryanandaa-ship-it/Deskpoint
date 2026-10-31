<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Menampilkan halaman profil user
     */
    public function profile()
    {
        // requireLogin() dihapus karena sudah ditangani oleh Filter 'auth' di Routes
        
        $userId = session()->get('id');

        // Mengambil data user lengkap dengan nama role-nya
        $userData = $this->userModel->getUserWithRole($userId);

        if (!$userData) {
            return redirect()->to('/dashboard')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Akun Saya | PT Humanika Mitra Solusi',
            'user'  => $userData,
        ];

        return view('user/profile', $data);
    }

    /**
     * Memperbarui data profil
     */
    public function update()
    {
        $userId = session()->get('id');

        // Validasi yang lebih bersih untuk CodeIgniter 4
        $rules = [
            'username' => "required|min_length[3]|is_unique[users.username,id,{$userId}]",
            'email'    => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'phone'    => 'permit_empty|min_length[10]|max_length[15]'
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Siapkan data untuk update
        $updateData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'phone'    => $this->request->getPost('phone'), // Tambahkan kolom phone
        ];

        // Jika password diisi, masukkan ke array (Model akan otomatis meng-hash-nya)
        if (!empty($password)) {
            $updateData['password'] = $password;
        }

        if ($this->userModel->update($userId, $updateData)) {
            // Update data session agar tampilan header (nama user) langsung berubah
            session()->set([
                'username' => $updateData['username'],
                'email'    => $updateData['email'],
            ]);

            return redirect()->to('/account')->with('success', 'Profil Anda berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui profil.');
    }
}