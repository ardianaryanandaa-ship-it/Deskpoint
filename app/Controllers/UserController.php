<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\CompanyModel; // Menambahkan ini untuk data Perusahaan

class UserController extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $companyModel;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->roleModel    = new RoleModel();
        $this->companyModel = new CompanyModel(); // Inisialisasi CompanyModel
    }

    public function index()
    {
        // requireLogin() dihapus karena sudah dihandle oleh AuthFilter di Routes
        
        $filters = [
            'search' => $this->request->getGet('search'),
            'role'   => $this->request->getGet('role'),
        ];

        $data = [
            'title'   => 'Daftar Pengguna | PT Humanika Mitra Solusi',
            'users'   => $this->userModel->getUsersWithRole($filters),
            'filters' => $filters,
            'roles'   => $this->roleModel->orderBy('name', 'ASC')->findAll(),
        ];

        return view('users/index', $data);
    }

    public function create()
    {
        $data = [
            'title'     => 'Tambah Pengguna Baru | PT Humanika Mitra Solusi',
            'roles'     => $this->roleModel->orderBy('name', 'ASC')->findAll(),
            'companies' => $this->companyModel->findAll(), // Mengambil data perusahaan untuk dropdown
        ];

        return view('users/create', $data);
    }

    public function store()
    {
        // 1. Validasi Input sesuai kolom di database Anda
        $rules = [
            'username'         => 'required|min_length[3]|is_unique[users.username]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'matches[password]',
            'role_id'          => 'required|integer',
            'company_id'       => 'permit_empty|integer',
            'phone'            => 'permit_empty|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Siapkan data untuk tabel 'users'
        // role_id kini langsung masuk ke tabel users
        $data = [
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => $this->request->getPost('password'), // Di-hash otomatis di UserModel
            'role_id'    => $this->request->getPost('role_id'),
            'company_id' => $this->request->getPost('company_id') ?: null,
            'phone'      => $this->request->getPost('phone'),
            'active'     => $this->request->getPost('active') ? 1 : 0,
        ];

        // 3. Simpan hanya ke satu tabel (users)
        if ($this->userModel->insert($data)) {
            return redirect()->to('users')->with('success', 'User baru berhasil dibuat.');
        }

        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
    }

    // Ambil data user untuk Edit (AJAX)
    public function edit($id)
    {
        $user = $this->userModel->getUserWithRole($id);
        if (!$user) return $this->failNotFound('User tidak ditemukan');
        return $this->response->setJSON($user);
    }

    // Proses Update User
    public function update($id)
    {
        $rules = [
            'username' => "required|min_length[3]|is_unique[users.username,id,$id]",
            'email'    => "required|valid_email|is_unique[users.email,id,$id]",
            'role_id'  => "required|integer",
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'role_id'    => $this->request->getPost('role_id'),
            'company_id' => $this->request->getPost('company_id') ?: null,
            'active'     => $this->request->getPost('active') ? 1 : 0,
        ];

        // Jika password diisi, update password
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        $this->userModel->update($id, $data);
        return $this->response->setJSON(['message' => 'Berhasil']);
    }

    // Proses Delete User
    public function delete($id)
    {
        if ($this->userModel->delete($id)) {
            return $this->response->setJSON(['message' => 'Berhasil']);
        }
        return $this->fail('Gagal menghapus user');
    }

    public function forceLogout($id)
    {
        // Jika Anda menggunakan database session, kita bisa menghapus datanya di tabel ci_sessions
        $db = \Config\Database::connect();
        $db->table('ci_sessions')->where('data LIKE', '%"id";s:'.strlen($id).':"'.$id.'"%')->delete();

        return redirect()->to('/admin/users')->with('success', 'Sesi aktif pengguna telah dihentikan.');
    }
}