<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; // Aktif karena ada kolom deleted_at di gambar

    // Field yang boleh diisi (Mass Assignment)
    protected $allowedFields    = [
        'username', 
        'email', 
        'password', 
        'role_id', 
        'company_id', 
        'phone', 
        'active'
    ];

    // Dates (Otomatis mengelola created_at & updated_at)
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Hash password otomatis sebelum disimpan
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) return $data;

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    public function getUserWithRole(int $id)
    {
        return $this->select('users.*, roles.name as role_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->where('users.id', $id)
                    ->first();
    }

    /**
     * Mengambil data user beserta nama role-nya
     */
    public function getUsersWithRole(array $filters = [])
{
    // Memilih kolom yang ingin ditampilkan
    $this->select('users.*, roles.name as role_name');
    
    // Melakukan JOIN dari users.role_id ke roles.id
    $this->join('roles', 'roles.id = users.role_id', 'left');

    // Fitur pencarian jika ada filter 'search' dari controller
    if (!empty($filters['search'])) {
        $search = $filters['search'];
        $this->groupStart()
             ->like('users.username', $search)
             ->orLike('users.email', $search)
             ->orLike('roles.name', $search)
             ->groupEnd();
    }

    // Fitur filter berdasarkan nama role jika ada
    if (!empty($filters['role'])) {
        $this->where('roles.name', $filters['role']);
    }

    // Urutkan berdasarkan yang terbaru
    $this->orderBy('users.created_at', 'DESC');

    return $this->findAll();
}
}