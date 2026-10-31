<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriArtikelModel;
use CodeIgniter\API\ResponseTrait;

class KnowledgeController extends BaseController
{
    use ResponseTrait;

    protected $artikelModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->kategoriModel = new KategoriArtikelModel();
    }

    /**
     * Halaman Portal Utama - Terbuka untuk semua
     */
    public function index()
    {
        $keyword = $this->request->getGet('search');
        
        $data = [
            'title'    => 'Pusat Bantuan Helpdesk',
            'kategori' => $this->kategoriModel->findAll(),
            'terbaru'  => $this->artikelModel->getArtikelLengkap(null, 6, $keyword),
            'keyword'  => $keyword
        ];

        return view('knowledge/index', $data);
    }

    /**
     * Membaca Isi Artikel - Terbuka untuk semua
     */
    public function show($slug)
    {
        $artikel = $this->artikelModel->getBySlug($slug);
        if (!$artikel) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $this->artikelModel->incrementViews($artikel['id']);

        return view('knowledge/show', [
            'title'   => $artikel['judul'],
            'artikel' => $artikel
        ]);
    }

    /**
     * Tabel List Manajemen - Terbuka untuk semua
     */
    public function manage()
    {
        return view('knowledge/manage', [
            'title'   => 'Kelola Artikel',
            'artikel' => $this->artikelModel->getArtikelLengkap()
        ]);
    }

    /**
     * Form Buat & Edit - Terbuka untuk semua
     */
    public function form($id = null)
    {
        $data = [
            'title'    => $id ? 'Edit Artikel' : 'Tulis Artikel Baru',
            'kategori' => $this->kategoriModel->findAll(),
            'artikel'  => $id ? $this->artikelModel->find($id) : null
        ];

        return view('knowledge/form', $data);
    }

    /**
     * Proses Simpan / Update - Terbuka untuk semua
     */
    public function save()
    {
        $id = $this->request->getPost('id');
        $judul = $this->request->getPost('judul');

        $data = [
            'id_kategori' => $this->request->getPost('id_kategori'),
            'judul'       => $judul,
            'slug'        => url_title($judul, '-', true),
            'isi_artikel' => $this->request->getPost('isi_artikel'),
            'penulis_id'  => session()->get('id')
        ];

        if ($this->artikelModel->save(array_merge(['id' => $id], $data))) {
            return redirect()->to('knowledge/manage')->with('success', 'Berhasil disimpan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan.');
    }
    /**
 * Menampilkan daftar artikel berdasarkan kategori yang dipilih
 */
public function kategori($id_kategori)
{
    // 1. Ambil data kategori untuk judul halaman
    $kategori = $this->kategoriModel->find($id_kategori);
    
    if (!$kategori) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // 2. Ambil artikel yang sesuai dengan ID kategori tersebut
    // Kita gunakan model ArtikelModel yang sudah ada
    $artikel = $this->artikelModel->where('id_kategori', $id_kategori)
                                  ->orderBy('dibuat_pada', 'DESC')
                                  ->findAll();

    $data = [
        'title'    => 'Panduan: ' . $kategori['nama'],
        'nama_kat' => $kategori['nama'],
        'ikon_kat' => $kategori['ikon'],
        'artikel'  => $artikel
    ];

    return view('knowledge/list_per_kategori', $data);
}

    /**
     * Proses Hapus - Terbuka untuk semua
     */
    public function delete($id)
    {
        if ($this->artikelModel->delete($id)) {
            return $this->respondDeleted(['message' => 'Berhasil dihapus']);
        }
        return $this->fail('Gagal hapus');
    }
}