<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use CodeIgniter\API\ResponseTrait;

class CompanyController extends BaseController
{
    use ResponseTrait;

    protected $companyModel;

    public function __construct()
    {
        $this->companyModel = new CompanyModel();
    }

    public function index()
    {
        // Keamanan: Hanya role 'develop' yang boleh masuk
        if (session()->get('role_name') !== 'develop') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title'     => 'Manajemen Perusahaan | PT Humanika',
            'companies' => $this->companyModel->findAll()
        ];

        return view('companies/index', $data);
    }

    public function store()
    {
        $data = [
            'company_name' => $this->request->getPost('company_name'),
            'industry'     => $this->request->getPost('industry'),
            'address'      => $this->request->getPost('address'),
        ];

        if ($this->companyModel->insert($data)) {
            return $this->respondCreated(['message' => 'Perusahaan berhasil didaftarkan']);
        }
        return $this->fail('Gagal menyimpan data.');
    }

    public function edit($id)
    {
        $data = $this->companyModel->find($id);
        return $this->respond($data);
    }

    public function update($id)
    {
        $data = [
            'company_name' => $this->request->getPost('company_name'),
            'industry'     => $this->request->getPost('industry'),
            'address'      => $this->request->getPost('address'),
        ];

        if ($this->companyModel->update($id, $data)) {
            return $this->respond(['message' => 'Data diperbarui']);
        }
        return $this->fail('Gagal update.');
    }

    public function delete($id)
    {
        if ($this->companyModel->delete($id)) {
            return $this->respondDeleted(['message' => 'Data dihapus']);
        }
        return $this->fail('Gagal menghapus.');
    }
}