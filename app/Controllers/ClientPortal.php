<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\CaseModel;
use App\Models\DocumentModel;
use App\Models\MessageModel;
use App\Models\InvoiceModel;

class ClientPortal extends BaseController
{
    public function index()
    {
        if (session()->get('isClientLoggedIn')) {
            return redirect()->to('/client/dashboard');
        }
        return view('client/login');
    }

    /**
     * Authenticate the client login request.
     */
    public function loginAuth()
    {
        $session = session();
        $model = new ClientModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // 1. Validation Rules
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/client')->with('msg', 'Please provide a valid email and password.');
        }

        // 2. Fetch Client Data
        $data = $model->where('email', $email)->first();

        // 3. Verify Password & Setup Session
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'client_id'        => $data['id'],
                    'client_name'      => $data['name'],
                    'client_email'     => $data['email'],
                    'isClientLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/client/dashboard');
            } else {
                $session->setFlashdata('msg', 'Incorrect password. Please try again.');
                return redirect()->to('/client');
            }
        } else {
            $session->setFlashdata('msg', 'Email not found in our records.');
            return redirect()->to('/client');
        }
    }

    public function dashboard()
    {
        if (!session()->get('isClientLoggedIn')) {
            return redirect()->to('/client');
        }

        $caseModel = new CaseModel();
        $clientId = session()->get('client_id');
        $data['cases'] = $caseModel->where('client_id', $clientId)->orderBy('created_at', 'DESC')->findAll();

        return view('client/dashboard', $data);
    }

    public function caseDetail($id)
    {
        if (!session()->get('isClientLoggedIn')) {
            return redirect()->to('/client');
        }

        $caseModel = new CaseModel();
        $documentModel = new DocumentModel();
        $messageModel = new MessageModel();
        $clientId = session()->get('client_id');

        $data['case'] = $caseModel->find($id);

        if (!$data['case'] || $data['case']['client_id'] != $clientId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Case not found or access denied.");
        }

        $data['documents'] = $documentModel->where('case_id', $id)->orderBy('created_at', 'DESC')->findAll();
        $data['messages'] = $messageModel->where('case_id', $id)->orderBy('created_at', 'ASC')->findAll();

        return view('client/case_detail', $data);
    }

    /**
     * Handle document uploads by the client for a specific case.
     */
    public function uploadCaseDocument()
    {
        if (!session()->get('isClientLoggedIn')) {
            return redirect()->to('/client');
        }

        $documentModel = new DocumentModel();
        $caseModel = new CaseModel();
        $caseId = $this->request->getPost('case_id');
        $clientId = session()->get('client_id');

        $case = $caseModel->find($caseId);
        if (!$case || $case['client_id'] != $clientId) {
            return redirect()->to('/client')->with('error', 'Access denied.');
        }

        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $data = [
                'case_id'     => $caseId,
                'uploaded_by' => 'client',
                'file_name'   => $file->getClientName(),
                'file_path'   => 'uploads/' . $newName,
                'description' => $this->request->getPost('description'),
                'created_at'  => date('Y-m-d H:i:s')
            ];

            $documentModel->insert($data);
            return redirect()->to('/client/case/' . $caseId)->with('success', 'Document uploaded successfully.');
        }

        return redirect()->to('/client/case/' . $caseId)->with('error', 'Failed to upload document.');
    }

    /**
     * Handle sending a message from the client to the assigned lawyer/admin.
     */
    public function sendCaseMessage()
    {
        if (!session()->get('isClientLoggedIn')) {
            return redirect()->to('/client');
        }

        $messageModel = new MessageModel();
        $caseModel = new CaseModel();
        $caseId = $this->request->getPost('case_id');
        $clientId = session()->get('client_id');

        $case = $caseModel->find($caseId);
        if (!$case || $case['client_id'] != $clientId) {
            return redirect()->to('/client')->with('error', 'Access denied.');
        }

        $message = $this->request->getPost('message');
        if (trim($message) !== '') {
            $data = [
                'case_id'     => $caseId,
                'sender_role' => 'client',
                'message'     => $message,
                'created_at'  => date('Y-m-d H:i:s')
            ];
            $messageModel->insert($data);
        }

        return redirect()->to('/client/case/' . $caseId);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/client');
    }

    // =========================================================
    // --- Billing & Invoices ---
    // =========================================================

    public function invoices()
    {
        if (!session()->get('isClientLoggedIn')) return redirect()->to('/client');

        $invoiceModel = new InvoiceModel();
        $clientId = session()->get('client_id');

        $data['invoices'] = $invoiceModel->getClientInvoices($clientId);

        return view('client/invoices', $data);
    }

    public function invoiceDetail($id)
    {
        if (!session()->get('isClientLoggedIn')) return redirect()->to('/client');

        $invoiceModel = new InvoiceModel();
        $clientId = session()->get('client_id');

        $invoice = $invoiceModel->getInvoiceDetail($id);

        if (!$invoice || $invoice['client_id'] != $clientId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Invoice not found or access denied.");
        }

        $data['invoice'] = $invoice;

        return view('client/invoice_detail', $data);
    }

    public function payInvoice($id)
    {
        if (!session()->get('isClientLoggedIn')) return redirect()->to('/client');

        $invoiceModel = new InvoiceModel();
        $clientId = session()->get('client_id');

        $invoice = $invoiceModel->find($id);

        if (!$invoice || $invoice['client_id'] != $clientId) {
            return redirect()->to('/client/invoices')->with('error', 'Access denied.');
        }

        // Simulate successful payment
        $invoiceModel->update($id, ['status' => 'Paid']);

        return redirect()->to('/client/invoice/' . $id)->with('success', 'Simulated payment successful! Thank you.');
    }

    // =========================================================
    // --- Client Calendar ---
    // =========================================================

    public function calendar()
    {
        if (!session()->get('isClientLoggedIn')) return redirect()->to('/client');

        $caseModel = new CaseModel();
        $invoiceModel = new InvoiceModel();
        $clientId = session()->get('client_id');

        // Fetch client's cases with hearings
        $cases = $caseModel->where('client_id', $clientId)
                           ->where('hearing_date IS NOT NULL')
                           ->findAll();

        // Fetch client's invoices
        $invoices = $invoiceModel->getClientInvoices($clientId);

        $events = [];

        foreach ($cases as $c) {
            $events[] = [
                'title' => 'Hearing: ' . $c['case_title'],
                'start' => date('Y-m-d', strtotime($c['hearing_date'])),
                'type'  => 'hearing',
                'color' => '#dc3545', // Red
                'url'   => base_url('client/case/' . $c['id'])
            ];
        }

        foreach ($invoices as $i) {
            if ($i['status'] !== 'Paid') {
                $events[] = [
                    'title' => 'Invoice due: ' . $i['invoice_number'] . ' - $' . number_format($i['amount'], 2),
                    'start' => $i['due_date'],
                    'type'  => 'invoice',
                    'color' => ($i['status'] === 'Overdue') ? '#721c24' : '#ffc107',
                    'url'   => base_url('client/invoice/' . $i['id'])
                ];
            }
        }

        $data['eventsJson'] = json_encode($events);

        return view('client/calendar', $data);
    }
}
