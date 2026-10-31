<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table            = 'artikel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_kategori', 
        'judul', 
        'slug', 
        'isi_artikel', 
        'total_dilihat', 
        'penulis_id'
    ];

    // Dates (Otomatis mengisi dibuat_pada dan diperbarui_pada)
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'dibuat_pada';
    protected $updatedField  = 'diperbarui_pada';

    /**
     * Mengambil artikel dengan join ke kategori
     */
    public function getArtikelLengkap($id = null)
    {
        $builder = $this->select('artikel.*, kategori_artikel.nama as nama_kategori, kategori_artikel.ikon as ikon_kategori, users.username as nama_penulis')
            ->join('kategori_artikel', 'kategori_artikel.id = artikel.id_kategori', 'left')
            ->join('users', 'users.id = artikel.penulis_id', 'left');

        if ($id === null) {
            return $builder->orderBy('artikel.dibuat_pada', 'DESC')->findAll();
        }

        return $builder->where('artikel.id', $id)->first();
    }

    /**
     * Mengambil artikel berdasarkan slug (untuk SEO friendly URL)
     */
    public function getBySlug($slug)
    {
        return $this->select('artikel.*, kategori_artikel.nama as nama_kategori')
            ->join('kategori_artikel', 'kategori_artikel.id = artikel.id_kategori', 'left')
            ->where('artikel.slug', $slug)
            ->first();
    }

    /**
     * Menambah jumlah view setiap kali artikel dibaca
     */
    public function incrementViews($id)
    {
        return $this->where('id', $id)->set('total_dilihat', 'total_dilihat + 1', FALSE)->update();
    }
}