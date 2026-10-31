<?php

namespace App\Models;

use CodeIgniter\Model;

class AttachmentModel extends Model
{
    protected $table            = 'attachments'; // Nama tabel di database Anda
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang boleh diisi (sesuai gambar Anda)
    protected $allowedFields    = ['ticket_id', 'file_name', 'file_path', 'uploaded_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'uploaded_at'; // Menggunakan kolom uploaded_at sebagai penanda waktu dibuat
    protected $updatedField  = '';            // Kosongkan karena tidak ada kolom updated_at di gambar
}