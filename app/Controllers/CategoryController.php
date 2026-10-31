<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;

class CategoryController extends BaseController
{
    use ResponseTrait;

    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        // Hanya Develop/Admin yang bisa mengelola kategori
        if (session()->get('role_name') !== 'develop') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title'      => 'Manajemen Kategori | PT Humanika',
            'categories' => $this->categoryModel->findAll()
        ];

        return view('categories/index', $data);
    }

    public function store()
    {
        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'description'   => $this->request->getPost('description'),
        ];

        if ($this->categoryModel->insert($data)) {
            return $this->respondCreated(['message' => 'Kategori berhasil ditambahkan']);
        }
        return $this->fail('Gagal menyimpan kategori.');
    }

    public function edit($id)
    {
        $data = $this->categoryModel->find($id);
        if (!$data) return $this->failNotFound('Kategori tidak ditemukan');
        return $this->respond($data);
    }

    public function update($id)
{
    // Ambil data dari form
    $category_name = $this->request->getPost('category_name');
    $description   = $this->request->getPost('description');

    // Validasi data sederhana
    if (empty($category_name)) {
        return $this->response->setJSON(['status' => false, 'message' => 'Nama kategori wajib diisi'])->setStatusCode(400);
    }

    try {
        // Eksekusi update
        $updated = $this->categoryModel->update($id, [
            'category_name' => $category_name,
            'description'   => $description
        ]);

        if ($updated) {
            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Kategori berhasil diperbarui'
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Tidak ada perubahan data'
            ]);
        }
    } catch (\Exception $e) {
        // Jika error, kirim pesan error database ke JavaScript
        return $this->response->setJSON([
            'status'  => false,
            'message' => $e->getMessage() // Ini akan memberitahu kolom mana yang salah
        ])->setStatusCode(500);
    }
}

    public function delete($id)
    {
        if ($this->categoryModel->delete($id)) {
            return $this->respondDeleted(['message' => 'Kategori berhasil dihapus']);
        }
        return $this->fail('Gagal menghapus kategori.');
    }
}