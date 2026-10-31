<?php
namespace App\Models;
use CodeIgniter\Model;

class TriageSlaModel extends Model {
    protected $table = 'triage_slas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category_id', 'priority_id', 'response_time_limit', 'resolution_time_limit', 'description'];

    // Cari aturan SLA yang cocok saat tiket dibuat
    public function getMatchedSla($categoryId, $priorityId) {
        return $this->where('category_id', $categoryId)
                    ->where('priority_id', $priorityId)
                    ->first();
    }
}