<?php

namespace App\Controllers;

use App\Models\SettingModel;

class SettingController extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    /**
     * Menampilkan Halaman Pengaturan SEO & Kontak
     */
    public function index()
    {
        // Pastikan hanya role develop yang bisa akses
        if (session()->get('role_name') !== 'develop') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title'    => 'Pengaturan Situs | PT Humanika',
            // Ambil semua data settings dan ubah jadi array key-value
            'settings' => $this->settingModel->get_all_settings() 
        ];

        return view('settings/index', $data);
    }

    /**
     * Memproses Update Data
     */
    public function update()
    {
        $settings = $this->request->getPost('settings');

        if ($settings) {
            foreach ($settings as $key => $value) {
                $this->settingModel->where('s_key', $key)
                                   ->set(['s_value' => $value])
                                   ->update();
            }
            return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui data.');
    }
}