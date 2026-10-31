<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table            = 'comments'; // Sesuaikan dengan nama tabel di DB Anda
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang boleh diisi (sesuai gambar Anda)
    protected $allowedFields    = ['ticket_id', 'user_id', 'message', 'created_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Kosongkan jika tidak ada kolom updated_at

    /**
     * Mengambil komentar berdasarkan ID Tiket
     * Sekaligus mengambil username penulis komentar (JOIN)
     */
    public function getCommentsByTicket($ticketId)
    {
        return $this->select('comments.*, users.username')
                    ->join('users', 'users.id = comments.user_id')
                    ->where('comments.ticket_id', $ticketId)
                    ->orderBy('comments.created_at', 'ASC')
                    ->findAll();
    }
}