<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; 

    // PERBAIKAN 1: Tambahkan semua kolom baru ke allowedFields
    protected $allowedFields    = [
        'subject', 
        'description', 
        'ticket_type',
        'category_id',
        'priority_id', 
        'sla_id',      
        'status_id', 
        'creator_id', 
        'assignee_id', 
        'due_date',     // Tambahkan ini
        'triaged_at',   // Tambahkan ini
        'triaged_by',   // Tambahkan ini
        'triage_notes', // Tambahkan ini
        'closed_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Dashboard Developer: Menampilkan SEMUA tiket + Info SLA & Triage
     */
    public function getTicketsWithDetails($limit = null)
    {
        $this->select('tickets.*, 
                             priorities.priority_name, 
                             statuses.status_name, 
                             categories.category_name,
                             triage_slas.resolution_time_limit as sla_limit_hours,
                             u_client.username as client_name, 
                             companies.company_name,
                             u_dev.username as developer_name');
        $this->join('priorities', 'priorities.id = tickets.priority_id', 'left');
        $this->join('statuses', 'statuses.id = tickets.status_id', 'left');
        $this->join('categories', 'categories.id = tickets.category_id', 'left'); 
        $this->join('triage_slas', 'triage_slas.id = tickets.sla_id', 'left');    
        $this->join('users u_client', 'u_client.id = tickets.creator_id', 'left');
        $this->join('companies', 'companies.id = u_client.company_id', 'left');
        $this->join('users u_dev', 'u_dev.id = tickets.assignee_id', 'left');
        
        if ($limit) {
            $this->limit($limit);
        }

        return $this->orderBy('tickets.created_at', 'DESC')->findAll();
    }

    /**
     * Detail Tiket: Menampilkan detail lengkap termasuk log Triage
     */
    public function getTicketDetail($id)
    {
        return $this->select('
                tickets.*, 
                priorities.priority_name, 
                statuses.status_name, 
                categories.category_name,
                triage_slas.resolution_time_limit as sla_limit_hours,
                triage_slas.description as sla_description,
                u_client.username as client_name, 
                companies.company_name,
                u_dev.username as developer_name,
                u_triage.username as triaged_by_name
            ')
            ->join('priorities', 'priorities.id = tickets.priority_id', 'left')
            ->join('statuses', 'statuses.id = tickets.status_id', 'left')
            ->join('categories', 'categories.id = tickets.category_id', 'left')
            ->join('triage_slas', 'triage_slas.id = tickets.sla_id', 'left')
            ->join('users u_client', 'u_client.id = tickets.creator_id', 'left')
            ->join('companies', 'companies.id = u_client.company_id', 'left')
            ->join('users u_dev', 'u_dev.id = tickets.assignee_id', 'left')
            ->join('users u_triage', 'u_triage.id = tickets.triaged_by', 'left') // Join untuk tahu siapa yang triage
            ->where('tickets.id', $id)
            ->first();
    }

    /**
     * Dashboard Client: Tiket milik sendiri
     */
    public function getTicketsByClient($clientId, $limit = null)
    {
        $this->select('tickets.*, 
                             priorities.priority_name, 
                             statuses.status_name,
                             categories.category_name');
        $this->join('priorities', 'priorities.id = tickets.priority_id', 'left');
        $this->join('statuses', 'statuses.id = tickets.status_id', 'left');
        $this->join('categories', 'categories.id = tickets.category_id', 'left');
        $this->where('tickets.creator_id', $clientId);
        
        if ($limit) {
            $this->limit($limit);
        }

        return $this->orderBy('tickets.created_at', 'DESC')->findAll();
    }
}