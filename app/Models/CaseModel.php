<?php

namespace App\Models;

use CodeIgniter\Model;

class CaseModel extends Model
{
    protected $table            = 'cases';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['client_id', 'lawyer_id', 'case_title', 'case_number', 'description', 'status', 'hearing_date', 'practice_area'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Helper to get cases with client and lawyer details
    public function getCasesWithClients($lawyerId = null)
    {
        $query = $this->select('cases.*, clients.name as client_name, clients.email as client_email, team_members.name as lawyer_name')
                      ->join('clients', 'clients.id = cases.client_id')
                      ->join('team_members', 'team_members.id = cases.lawyer_id', 'left');
        
        if ($lawyerId !== null) {
            $query = $query->where('cases.lawyer_id', $lawyerId);
        }

        return $query->orderBy('cases.created_at', 'DESC')
                     ->findAll();
    }

    // Helper to get specific case with client and lawyer details
    public function getCaseWithClient($id)
    {
        return $this->select('cases.*, clients.name as client_name, clients.email as client_email, clients.phone as client_phone, team_members.name as lawyer_name')
                    ->join('clients', 'clients.id = cases.client_id')
                    ->join('team_members', 'team_members.id = cases.lawyer_id', 'left')
                    ->where('cases.id', $id)
                    ->first();
    }
}
