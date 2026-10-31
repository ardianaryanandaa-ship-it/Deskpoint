<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');

        // Ambil data settings dari DB
        // 1. Ambil data dari model
        $settingModel = new \App\Models\SettingModel();
        $siteSettings = $settingModel->get_all_settings();

        // 2. Berikan nilai default jika database masih kosong agar tidak error
        $default = [
            'site_name'        => 'DeskPoint',
            'meta_description' => 'Sistem Helpdesk Terintegrasi',
            'meta_keywords'    => 'helpdesk, itil, Lancar',
            'meta_author'      => 'PT Lancar Jaya',
            'contact_email'    => 'admin@humanika.com',
            'contact_phone'    => '021-000000',
            'contact_address'  => 'Jakarta, Indonesia'
        ];

        // Gabungkan data DB dengan default (Data DB akan menimpa default jika ada)
        $finalSettings = array_merge($default, $siteSettings);

        // 3. KUNCI PERBAIKAN: Suntikkan variabel ke Renderer secara global
        // Ini membuat variabel $app tersedia di SEMUA view
        \Config\Services::renderer()->setVar('app', (object) $finalSettings);
    }


    protected function requireLogin()
    {
        if (!session()->get('logged_in') || !$this->isCurrentSessionActive()) {
            session()->setFlashdata('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->to('/login');
        }

        return null;
    }

    protected function requireAdmin()
    {
        if ($response = $this->requireLogin()) {
            return $response;
        }

        if (session()->get('role_name') !== 'admin') {
            return service('response')
                ->setStatusCode(403)
                ->setBody(view('errors/html/error_403', ['message' => 'Akses terbatas hanya untuk admin.']));
        }

        return null;
    }

        protected function isCurrentSessionActive(): bool
    {
        // Cukup cek apakah data 'logged_in' ada di session dan bernilai true
        if (session()->has('logged_in') && session()->get('logged_in') === true) {
            return true;
        }

        return false;
    }
}
