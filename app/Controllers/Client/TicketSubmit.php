<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\AttachmentModel;
use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;

class TicketSubmit extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // Client tidak butuh ambil kategori/prioritas lagi di form
        return view('client/tickets/submit_form', [
            'title' => 'Kirim Laporan Kendala'
        ]);
    }

    public function store()
    {
        $ticketModel = new TicketModel();

        $rules = [
            'subject'     => 'required|min_length[5]|max_length[255]',
            'description' => 'required',
            'attachment'  => 'permit_empty|max_size[attachment,2048]|ext_in[attachment,jpg,jpeg,png,pdf]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $ticketData = [
            'subject'     => $this->request->getPost('subject'),
            'description' => $this->request->getPost('description'),
            'creator_id'  => session()->get('id'), 
            'status_id'   => 1,     // Status: New
            'category_id' => null,  // Menunggu Triage
            'priority_id' => null,  // Menunggu Triage
            'sla_id'      => null,  // Menunggu Triage
        ];

        $db = db_connect();
        $db->transStart();

        $ticketId = $ticketModel->insert($ticketData);

        $file = $this->request->getFile('attachment');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/tickets', $newName);

            (new AttachmentModel())->insert([
                'ticket_id' => $ticketId,
                'file_name' => $file->getClientName(),
                'file_path' => $newName
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->fail('Gagal menyimpan laporan ke database.');
        }

        return $this->respondCreated([
            'status'  => true,
            'message' => 'Laporan diterima. Mohon tunggu tim kami melakukan pengecekan (Triage).'
        ]);
    }
}