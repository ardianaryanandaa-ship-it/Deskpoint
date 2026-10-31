<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table            = 'companies'; // Nama tabel di database Anda
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; // Karena di tabel Anda tidak ada deleted_at

    // Kolom yang boleh diisi (sesuaikan dengan gambar database Anda)
    protected $allowedFields    = [
        'company_name', 
        'industry', 
        'address'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Kosongkan jika tidak ada kolom updated_at di tabel companies
}