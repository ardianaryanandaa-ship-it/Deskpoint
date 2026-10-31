<?php

namespace App\Controllers;

use App\Models\TriageSlaModel;
use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;

class TriageSlaController extends BaseController
{
    use ResponseTrait;

    protected $slaModel;

    public function __construct()
    {
        $this->slaModel = new TriageSlaModel();
    }

    /**
     * Menampilkan Halaman Daftar Matriks SLA
     */
    public function index()
    {
        // Proteksi: Hanya role develop yang bisa akses menu Master
        if (session()->get('role_name') !== 'develop') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $categoryModel = new CategoryModel();
        $db = \Config\Database::connect();

        $data = [
            'title'      => 'Master Triage & SLA | PT Humanika',
            'sla_matrix' => $this->slaModel->getFullSlaMatrix(),
            'categories' => $categoryModel->findAll(),
            // Mengambil data prioritas langsung dari query builder
            'priorities' => $db->table('priorities')->get()->getResultArray(),
        ];

        return view('master/triage_sla', $data);
    }

    /**
     * Simpan Aturan SLA Baru (AJAX)
     */
    public function store()
    {
        $rules = [
            'category_id'           => 'required|integer',
            'priority_id'           => 'required|integer',
            'response_time_limit'   => 'required|integer',
            'resolution_time_limit' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'category_id'           => $this->request->getPost('category_id'),
            'priority_id'           => $this->request->getPost('priority_id'),
            'response_time_limit'   => $this->request->getPost('response_time_limit'),
            'resolution_time_limit' => $this->request->getPost('resolution_time_limit'),
            'description'           => $this->request->getPost('description'),
        ];

        // Cek apakah kombinasi Kategori & Prioritas sudah ada
        $exist = $this->slaModel->where([
            'category_id' => $data['category_id'],
            'priority_id' => $data['priority_id']
        ])->first();

        if ($exist) {
            return $this->fail('Aturan SLA untuk kombinasi ini sudah ada.');
        }

        if ($this->slaModel->insert($data)) {
            return $this->respondCreated(['message' => 'Aturan SLA berhasil ditambahkan']);
        }

        return $this->fail('Gagal menyimpan aturan.');
    }

    /**
     * Ambil data untuk Form Edit (AJAX)
     */
    public function edit($id)
    {
        $data = $this->slaModel->find($id);
        if (!$data) {
            return $this->failNotFound('Aturan tidak ditemukan');
        }
        return $this->respond($data);
    }

    /**
     * Update Aturan SLA (AJAX)
     */
    public function update($id)
    {
        $data = [
            'category_id'           => $this->request->getPost('category_id'),
            'priority_id'           => $this->request->getPost('priority_id'),
            'response_time_limit'   => $this->request->getPost('response_time_limit'),
            'resolution_time_limit' => $this->request->getPost('resolution_time_limit'),
            'description'           => $this->request->getPost('description'),
        ];

        if ($this->slaModel->update($id, $data)) {
            return $this->respond(['message' => 'Aturan SLA berhasil diperbarui']);
        }

        return $this->fail('Gagal memperbarui data.');
    }

    /**
     * Hapus Aturan SLA (AJAX)
     */
    public function delete($id)
    {
        if ($this->slaModel->delete($id)) {
            return $this->respondDeleted(['message' => 'Aturan SLA berhasil dihapus']);
        }
        return $this->fail('Gagal menghapus data.');
    }
}