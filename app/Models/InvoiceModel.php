<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table      = 'invoices';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'client_id', 'case_id', 'invoice_number',
        'amount', 'due_date', 'status', 'description'
    ];

    /**
     * Get all invoices with client details and case title
     */
    public function getInvoicesExtended()
    {
        return $this->select('invoices.*, clients.name as client_name, cases.case_title, cases.case_number')
                    ->join('clients', 'clients.id = invoices.client_id')
                    ->join('cases', 'cases.id = invoices.case_id', 'left')
                    ->orderBy('invoices.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get invoices for a specific client
     */
    public function getClientInvoices(int $clientId)
    {
        return $this->select('invoices.*, cases.case_title, cases.case_number')
                    ->join('cases', 'cases.id = invoices.case_id', 'left')
                    ->where('invoices.client_id', $clientId)
                    ->orderBy('invoices.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Find single invoice with full details (for printing/receipts)
     */
    public function getInvoiceDetail(int $id)
    {
        return $this->select('invoices.*, clients.name as client_name, clients.email as client_email, clients.phone as client_phone, cases.case_title, cases.case_number')
                    ->join('clients', 'clients.id = invoices.client_id')
                    ->join('cases', 'cases.id = invoices.case_id', 'left')
                    ->where('invoices.id', $id)
                    ->first();
    }
}
