<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\CompanyModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $ticketModel = new TicketModel();
        $companyModel = new CompanyModel();

        $role = session()->get('role_name');
        $userId = session()->get('id');

        if ($role === 'develop') {
            // Stats untuk TIM DEVELOP (Dispatcher View)
            $stats = [
                'need_triage'   => $ticketModel->where('triaged_at', null)->where('closed_at', null)->countAllResults(),
                'in_progress'   => $ticketModel->where('status_id', 2)->countAllResults(), // In Progress
                'total_clients' => $companyModel->countAllResults(),
                'total_tickets' => $ticketModel->countAllResults(),
            ];
            $recent_tickets = $ticketModel->getTicketsWithDetails(7); // 7 terbaru
        } else {
            // Stats untuk CLIENT (Customer Portal View)
            $stats = [
                'my_open'      => $ticketModel->where('creator_id', $userId)->where('closed_at', null)->countAllResults(),
                'my_resolved'  => $ticketModel->where('creator_id', $userId)->where('closed_at !=', null)->countAllResults(),
                'total_tickets'=> $ticketModel->where('creator_id', $userId)->countAllResults(),
            ];
            $recent_tickets = $ticketModel->getTicketsByClient($userId, 7);
        }

        $data = [
            'title' => 'Executive Dashboard',
            'role'  => $role,
            'stats' => (object)$stats,
            'recent_tickets' => $recent_tickets,
        ];

        return view('dashboard/index', $data);
    }
}