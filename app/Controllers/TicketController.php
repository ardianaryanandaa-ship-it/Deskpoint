<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\CommentModel;
use App\Models\AttachmentModel;
use App\Models\CategoryModel;
use App\Models\TriageSlaModel;
use CodeIgniter\API\ResponseTrait;

class TicketController extends BaseController
{
    use ResponseTrait;

    protected $ticketModel;
    protected $session;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->session = session();
    }

    /**
     * Dashboard List Tiket
     */
    public function index()
    {
        // PERBAIKAN 1: Konsisten menggunakan 'role_name' sesuai Auth Controller
        $role   = $this->session->get('role_name'); 
        $userId = $this->session->get('id');
        
        $categoryModel = new \App\Models\CategoryModel();
        $categories = $categoryModel->findAll(); // Hasil disimpan di variabel $categorie

        // Menggunakan "develop" sesuai gambar database Anda
        if ($role === 'develop') {
            $tickets = $this->ticketModel->getTicketsWithDetails();
        } else {
            $tickets = $this->ticketModel->getTicketsByClient($userId);
        }

        $data = [
            'title'   => 'Helpdesk | Daftar Tiket',
            'tickets' => $tickets,
            'role'    => $role,
            'categories' => $categories
        ];

        return view('tickets/index', $data);
    }

    /**
     * Halaman Detail Tiket
     */
    public function show($id)
{
    $ticket = $this->ticketModel->getTicketDetail($id);

    if (!$ticket) {
        return redirect()->to('/tickets')->with('error', 'Tiket tidak ditemukan.');
    }

    // Security Check: Client hanya bisa melihat tiket miliknya sendiri
    if ($this->session->get('role_name') === 'client' && $ticket['creator_id'] != $this->session->get('id')) {
        return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
    }

    // --- PERBAIKAN: Tambahkan pengambilan data untuk Modal Triage ---
    
    // 1. Ambil semua kategori untuk dropdown di modal triage
    $categoryModel = new \App\Models\CategoryModel();
    $categories = $categoryModel->findAll();

    // 2. Ambil daftar user dengan role 'develop' untuk penugasan (Assignee)
    // Sesuai database Anda, role 'develop' memiliki ID 1
    $userModel = new \App\Models\UserModel();
    $developers = $userModel->where('role_id', 1)->findAll();

    $commentModel = new CommentModel();
    $attachmentModel = new AttachmentModel();

    $data = [
        'title'       => 'Detail Tiket #' . $id,
        'ticket'      => $ticket,
        'comments'    => $commentModel->getCommentsByTicket($id),
        'attachments' => $attachmentModel->where('ticket_id', $id)->findAll(),
        'statuses'    => db_connect()->table('statuses')->get()->getResultArray(),
        
        // Kirim variabel tambahan ke View
        'categories'  => $categories, 
        'developers'  => $developers 
    ];

    return view('tickets/show', $data);
}

    /**
     * Proses Simpan Tiket Baru (AJAX)
     */
    public function store()
    {
        $rules = [
            'subject'     => 'required|min_length[5]|max_length[255]',
            'description' => 'required',
            'priority_id' => 'required',
            'attachment'  => 'max_size[attachment,2048]|ext_in[attachment,jpg,jpeg,png,pdf,docx,zip]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $ticketData = [
            'subject'     => $this->request->getPost('subject'),
            'description' => $this->request->getPost('description'),
            'priority_id' => $this->request->getPost('priority_id'),
            'creator_id'  => $this->session->get('id'), 
            'status_id'   => 1,
        ];

        $db = db_connect();
        $db->transStart();

        $ticketId = $this->ticketModel->insert($ticketData);

        $file = $this->request->getFile('attachment');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/tickets', $newName);

            $attachmentModel = new AttachmentModel();
            $attachmentModel->insert([
                'ticket_id' => $ticketId,
                'file_name' => $file->getClientName(),
                'file_path' => $newName
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->fail('Gagal menyimpan tiket ke database.');
        }

        return $this->respondCreated([
            'status'   => true,
            'message'  => 'Tiket berhasil dibuat!',
            'redirect' => site_url('tickets')
        ]);
    }

        public function edit($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            return $this->failNotFound('Tiket tidak ditemukan');
        }

        // REVISI: Jika closed_at sudah terisi, blokir akses edit
        if ($ticket['closed_at'] !== null) {
            return $this->fail('Tiket ini sudah ditutup dan tidak dapat diubah lagi.');
        }

        return $this->respond($ticket);
    }

        public function update($id)
    {
        $ticket = $this->ticketModel->find($id);
        if ($ticket['closed_at'] !== null) {
            return $this->fail('Gagal: Tiket sudah ditutup.');
        }

        $rules = [
            'subject'     => 'required|min_length[5]|max_length[255]',
            'description' => 'required',
            'priority_id' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'subject'     => $this->request->getPost('subject'),
            'description' => $this->request->getPost('description'),
            'priority_id' => $this->request->getPost('priority_id'),
        ];

        if ($this->ticketModel->update($id, $data)) {
            return $this->respond(['message' => 'Tiket berhasil diperbarui']);
        }

        return $this->fail('Gagal memperbarui tiket');
    }

    /**
     * Proses Soft Delete
     */
    public function delete($id)
    {
        // Opsional: Tiket yang sudah ditutup biasanya tidak boleh dihapus demi arsip
        $ticket = $this->ticketModel->find($id);
        if ($ticket['closed_at'] !== null) {
            return $this->fail('Tiket yang sudah ditutup tidak boleh dihapus untuk keperluan audit.');
        }

        if ($this->ticketModel->delete($id)) {
            return $this->respondDeleted(['message' => 'Tiket berhasil dihapus']);
        }

        return $this->fail('Gagal menghapus tiket');
    }

    /**
     * Update Status (Oleh Develop) - AJAX
     */
    public function updateStatus($id)
    {
        if ($this->session->get('role_name') !== 'develop') {
            return $this->failForbidden('Hanya develop yang boleh mengubah status.');
        }

        $statusId = $this->request->getPost('status_id');
        
        $updateData = [
            'status_id'   => $statusId,
            'assignee_id' => $this->session->get('id')
        ];

        if (in_array($statusId, [4, 5])) { 
            $updateData['closed_at'] = date('Y-m-d H:i:s');
        }

        if ($this->ticketModel->update($id, $updateData)) {
            return $this->respond(['message' => 'Status berhasil diperbarui']);
        }

        return $this->fail('Gagal memperbarui status.');
    }

    /**
     * Menambah Komentar (AJAX)
     */
    public function addComment($ticketId)
    {
        $message = $this->request->getPost('message');

        // PERBAIKAN 3: Jika AJAX, kirim error dalam bentuk JSON (fail), bukan redirect
        if (empty($message)) {
            return $this->fail('Pesan tidak boleh kosong.');
        }

        $commentModel = new CommentModel();
        // PERBAIKAN 4: Definisikan variabel $inserted
        $inserted = $commentModel->insert([
            'ticket_id' => $ticketId,
            'user_id'   => $this->session->get('id'),
            'message'   => $message
        ]);

        if ($inserted) {
            return $this->respond([
                'status'   => true,
                'username' => $this->session->get('username'),
                'message'  => $message,
                'time'     => date('H:i')
            ]);
        }

        return $this->fail('Gagal mengirim balasan.');
    }

    public function triage($id)
    {
        if (session()->get('role_name') !== 'develop') {
            return $this->failForbidden('Hanya tim developer yang dapat melakukan triage.');
        }

        $rules = [
            'category_id' => 'required',
            'priority_id' => 'required',
            'assignee_id' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $catId       = $this->request->getPost('category_id');
        $prioId      = $this->request->getPost('priority_id');
        $assigneeId  = $this->request->getPost('assignee_id');
        $ticketType  = $this->request->getPost('ticket_type') ?: 'incident';
        $triageNotes = trim($this->request->getPost('triage_notes') ?? '');

        // 1. Cari aturan SLA berdasarkan Kategori & Prioritas
        $slaModel = new \App\Models\TriageSlaModel();
        $slaRule  = $slaModel->where(['category_id' => $catId, 'priority_id' => $prioId])->first();

        // 2. Data update tiket
        $updateData = [
            'category_id' => $catId,
            'priority_id' => $prioId,
            'ticket_type' => $ticketType,
            'sla_id'      => $slaRule ? $slaRule['id'] : null,
            'assignee_id' => $assigneeId,
            'status_id'   => 2, // Status: In Progress
        ];

        if ($this->ticketModel->update($id, $updateData)) {
            // 3. Catat aktivitas Triage ke dalam Komentar Tiket sebagai rekam jejak profesional
            $userModel    = new \App\Models\UserModel();
            $assignee     = $userModel->find($assigneeId);
            $assigneeName = $assignee ? $assignee['username'] : 'Developer';

            $logMessage = "📋 [TRIAGE SELESAI]\n"
                . "• Status: In Progress\n"
                . "• Teknisi Penanggung Jawab: " . $assigneeName . "\n";
            if ($slaRule && !empty($slaRule['resolution_time_limit'])) {
                $logMessage .= "• SLA Resolusi: " . $slaRule['resolution_time_limit'] . " Jam\n";
            }
            if (!empty($triageNotes)) {
                $logMessage .= "• Catatan Internal: " . $triageNotes;
            }

            $commentModel = new CommentModel();
            $commentModel->insert([
                'ticket_id' => $id,
                'user_id'   => session()->get('id'),
                'message'   => $logMessage,
            ]);

            return $this->respond([
                'status'  => true,
                'message' => 'Triage Berhasil! Tiket resmi dialokasikan dan berstatus In Progress.'
            ]);
        }

        return $this->fail('Gagal memproses Triage tiket.');
    }
}