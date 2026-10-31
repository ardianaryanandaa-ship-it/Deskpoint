<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriArtikelModel extends Model
{
    protected $table            = 'kategori_artikel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'ikon'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'dibuat_pada';
    protected $updatedField  = ''; // Kosongkan karena tidak ada kolom updated_at di SQL Anda
}