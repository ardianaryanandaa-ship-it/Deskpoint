<?php
namespace App\Models;
use CodeIgniter\Model;

class SettingModel extends Model {
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['s_key', 's_value'];

    // Fungsi pembantu untuk mempermudah pemanggilan
    public function get_all_settings() {
        $data = $this->findAll();
        $settings = [];
        foreach ($data as $row) {
            $settings[$row['s_key']] = $row['s_value'];
        }
        return $settings;
    }
}