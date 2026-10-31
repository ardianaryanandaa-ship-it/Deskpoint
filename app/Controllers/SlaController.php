<?php

namespace App\Controllers;

use App\Models\TriageSlaModel;
use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;

class SlaController extends BaseController
{
    use ResponseTrait;

    protected $slaModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->slaModel      = new TriageSlaModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        // Akses hanya untuk role develop / admin
        if (session()->get('role_name') !== 'develop') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $db = db_connect();
        $slas = $db->table('triage_slas')
            ->select('triage_slas.*, categories.category_name, priorities.priority_name')
            ->join('categories', 'categories.id = triage_slas.category_id', 'left')
            ->join('priorities', 'priorities.id = triage_slas.priority_id', 'left')
            ->get()->getResultArray();

        $priorities = $db->table('priorities')->get()->getResultArray();

        $data = [
            'title'      => 'Manajemen SLA (Service Level Agreement)',
            'slas'       => $slas,
            'categories' => $this->categoryModel->findAll(),
            'priorities' => $priorities,
        ];

        return view('sla/index', $data);
    }

    public function store()
    {
        $rules = [
            'category_id'           => 'required',
            'priority_id'           => 'required',
            'resolution_time_limit' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'category_id'           => $this->request->getPost('category_id'),
            'priority_id'           => $this->request->getPost('priority_id'),
            'response_time_limit'   => $this->request->getPost('response_time_limit') ?: null,
            'resolution_time_limit' => $this->request->getPost('resolution_time_limit'),
            'description'           => $this->request->getPost('description'),
        ];

        if ($this->slaModel->insert($data)) {
            return $this->respondCreated(['message' => 'Aturan SLA berhasil ditambahkan.']);
        }

        return $this->fail('Gagal menyimpan aturan SLA.');
    }

    public function edit($id)
    {
        $sla = $this->slaModel->find($id);
        if (!$sla) {
            return $this->failNotFound('Aturan SLA tidak ditemukan.');
        }
        return $this->respond($sla);
    }

    public function update($id)
    {
        $rules = [
            'category_id'           => 'required',
            'priority_id'           => 'required',
            'resolution_time_limit' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'category_id'           => $this->request->getPost('category_id'),
            'priority_id'           => $this->request->getPost('priority_id'),
            'response_time_limit'   => $this->request->getPost('response_time_limit') ?: null,
            'resolution_time_limit' => $this->request->getPost('resolution_time_limit'),
            'description'           => $this->request->getPost('description'),
        ];

        if ($this->slaModel->update($id, $data)) {
            return $this->respond(['message' => 'Aturan SLA berhasil diperbarui.']);
        }

        return $this->fail('Gagal memperbarui aturan SLA.');
    }

    public function delete($id)
    {
        if ($this->slaModel->delete($id)) {
            return $this->respondDeleted(['message' => 'Aturan SLA berhasil dihapus.']);
        }

        return $this->fail('Gagal menghapus aturan SLA.');
    }
}
