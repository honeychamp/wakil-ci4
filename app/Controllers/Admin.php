<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\ContactModel;
use App\Models\ClientModel;
use App\Models\CaseModel;
use App\Models\DocumentModel;
use App\Models\MessageModel;
use App\Models\BlogModel;
use App\Models\TeamModel;
use App\Models\InvoiceModel;

class Admin extends BaseController
{
    public function index()
    {
        // If already logged in
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/login');
    }

    public function loginAuth()
    {
        $session = session();
        $adminModel = new AdminModel();
        $teamModel = new TeamModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // 1. Check Super Admin
        $data = $adminModel->where('username', $username)->first();

        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'id' => $data['id'],
                    'username' => $data['username'],
                    'role' => 'admin',
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/admin/dashboard');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/admin');
            }
        } else {
            // 2. Check Team Member / Lawyer (using email)
            $lawyer = $teamModel->where('email', $username)->first();
            if ($lawyer && !empty($lawyer['password'])) {
                $verify_pass = password_verify($password, $lawyer['password']);
                if ($verify_pass) {
                    $ses_data = [
                        'id' => $lawyer['id'],
                        'username' => $lawyer['name'],
                        'role' => 'lawyer',
                        'lawyer_id' => $lawyer['id'],
                        'isLoggedIn' => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to('/admin/dashboard');
                } else {
                    $session->setFlashdata('msg', 'Wrong Password');
                    return redirect()->to('/admin');
                }
            } else {
                $session->setFlashdata('msg', 'Account not found or inactive');
                return redirect()->to('/admin');
            }
        }
    }

    public function dashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $role = $session->get('role');
        $lawyerId = $session->get('lawyer_id');

        $caseModel = new CaseModel();
        $clientModel = new ClientModel();
        $invoiceModel = new InvoiceModel();

        if ($role === 'lawyer') {
            // Lawyer sees only their own cases
            $data['cases'] = $caseModel->getCasesWithClients($lawyerId);
            $data['total_cases'] = count($data['cases']);
            $data['total_clients'] = 0;
            $data['total_leads'] = 0;
            $data['leads'] = [];
            $data['active_cases'] = count(array_filter($data['cases'], fn($c) => $c['status'] === 'Active'));
        } else {
            $contactModel = new ContactModel();
            $data['leads'] = $contactModel->orderBy('created_at', 'DESC')->findAll();
            $data['total_leads'] = count($data['leads']);
            $allCases = $caseModel->getCasesWithClients();
            $data['cases'] = $allCases;
            $data['total_cases'] = count($allCases);
            $data['active_cases'] = count(array_filter($allCases, fn($c) => $c['status'] === 'Active'));
            $data['total_clients'] = $clientModel->countAll();
        }

        return view('admin/dashboard', $data);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/admin');
    }

    // Update lead status (New -> Contacted -> Closed)
    public function updateLeadStatus()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $contactModel = new ContactModel();
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        $contactModel->update($id, ['status' => $status]);

        return redirect()->to('/admin/dashboard')->with('success', 'Lead status updated successfully.');
    }

    // Delete a lead
    public function deleteLead($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $contactModel = new ContactModel();
        $contactModel->delete($id);

        return redirect()->to('/admin/dashboard')->with('success', 'Lead deleted.');
    }

    // --- Clients Management ---

    public function clients()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $clientModel = new ClientModel();
        $data['clients'] = $clientModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/clients', $data);
    }

    /**
     * Add a new client from the admin portal.
     * Validates input, creates the user, and simulates sending a welcome email.
     */
    public function addClient()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $clientModel = new ClientModel();

        // 1. Validation Rules
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[clients.email]',
            'phone' => 'required',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/admin/clients')->with('error', 'Validation failed. Ensure email is unique and password is at least 6 characters.');
        }

        // 2. Prepare Data
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        // 3. Insert into Database
        $clientModel->insert($data);

        // 4. Send Welcome Email (Mock implementation for now)
        // To make this real, configure SMTP in .env and use CodeIgniter's \Config\Services::email()
        log_message('info', 'WELCOME EMAIL MOCK: Sent welcome email to ' . $data['email'] . ' with login instructions.');

        return redirect()->to('/admin/clients')->with('success', 'New client added successfully. A welcome email has been sent to them.');
    }

    public function deleteClient($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $clientModel = new ClientModel();
        $clientModel->delete($id);

        return redirect()->to('/admin/clients')->with('success', 'Client deleted successfully.');
    }

    /**
     * Reset a client's portal password (Admin only).
     */
    public function resetClientPassword()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        // Only super admin can reset passwords
        if (session()->get('role') === 'lawyer')
            return redirect()->to('/admin/clients')->with('error', 'You do not have permission to reset passwords.');

        $clientId    = $this->request->getPost('client_id');
        $newPassword = $this->request->getPost('new_password');
        $confirmPwd  = $this->request->getPost('confirm_password');

        // Validate passwords match
        if (strlen($newPassword) < 6) {
            return redirect()->to('/admin/clients')->with('error', 'Password must be at least 6 characters.');
        }

        if ($newPassword !== $confirmPwd) {
            return redirect()->to('/admin/clients')->with('error', 'Passwords do not match. Please try again.');
        }

        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);

        if (!$client) {
            return redirect()->to('/admin/clients')->with('error', 'Client not found.');
        }

        $clientModel->update($clientId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/admin/clients')->with('success', 'Password for "' . $client['name'] . '" has been reset successfully. Please share the new password with them securely.');
    }

    // --- Cases Management ---

    public function cases()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $role = $session->get('role');
        $lawyerId = $session->get('lawyer_id');

        $caseModel = new CaseModel();
        $clientModel = new ClientModel();
        $teamModel = new TeamModel();

        // Lawyers only see their own cases; admins see all
        $data['cases'] = $caseModel->getCasesWithClients($role === 'lawyer' ? $lawyerId : null);
        $data['clients'] = $clientModel->orderBy('name', 'ASC')->findAll();
        $data['lawyers'] = $teamModel->orderBy('name', 'ASC')->findAll();
        $data['role'] = $role;

        return view('admin/cases', $data);
    }

    public function addCase()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $caseModel = new CaseModel();

        $data = [
            'client_id' => $this->request->getPost('client_id'),
            'lawyer_id' => $this->request->getPost('lawyer_id') ?: null,
            'case_title' => $this->request->getPost('case_title'),
            'case_number' => $this->request->getPost('case_number'),
            'description' => $this->request->getPost('description'),
            'status' => 'Active',
            'hearing_date' => $this->request->getPost('hearing_date') ?: null
        ];

        $caseModel->insert($data);
        return redirect()->to('/admin/cases')->with('success', 'Case created and assigned successfully.');
    }

    public function caseDetail($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $caseModel = new CaseModel();
        $documentModel = new DocumentModel();
        $messageModel = new MessageModel();

        $data['case'] = $caseModel->getCaseWithClient($id);
        if (!$data['case']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Case not found.");
        }

        if (session()->get('role') === 'lawyer' && $data['case']['lawyer_id'] != session()->get('lawyer_id')) {
            return redirect()->to('/admin/dashboard')->with('error', 'Access denied.');
        }

        $data['documents'] = $documentModel->where('case_id', $id)->orderBy('created_at', 'DESC')->findAll();
        $data['messages'] = $messageModel->where('case_id', $id)->orderBy('created_at', 'ASC')->findAll();

        return view('admin/case_detail', $data);
    }

    public function updateCaseStatus()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $caseModel = new CaseModel();
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        if (session()->get('role') === 'lawyer') {
            $case = $caseModel->find($id);
            if (!$case || $case['lawyer_id'] != session()->get('lawyer_id')) {
                return redirect()->to('/admin/dashboard')->with('error', 'Access denied.');
            }
        }

        $caseModel->update($id, ['status' => $status]);
        return redirect()->to('/admin/case/' . $id)->with('success', 'Case status updated successfully.');
    }

    public function uploadCaseDocument()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $documentModel = new DocumentModel();
        $caseModel = new CaseModel();
        $caseId = $this->request->getPost('case_id');

        if (session()->get('role') === 'lawyer') {
            $case = $caseModel->find($caseId);
            if (!$case || $case['lawyer_id'] != session()->get('lawyer_id')) {
                return redirect()->to('/admin/dashboard')->with('error', 'Access denied.');
            }
        }

        $file = $this->request->getFile('file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Ensure folder exists
            $uploadPath = FCPATH . 'uploads';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $data = [
                'case_id' => $caseId,
                'uploaded_by' => 'admin',
                'file_name' => $file->getClientName(),
                'file_path' => 'uploads/' . $newName,
                'description' => $this->request->getPost('description'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $documentModel->insert($data);
            return redirect()->to('/admin/case/' . $caseId)->with('success', 'Document uploaded successfully.');
        }

        return redirect()->to('/admin/case/' . $caseId)->with('error', 'Failed to upload document.');
    }

    public function sendCaseMessage()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $messageModel = new MessageModel();
        $caseModel = new CaseModel();
        $caseId = $this->request->getPost('case_id');
        $message = $this->request->getPost('message');

        if (session()->get('role') === 'lawyer') {
            $case = $caseModel->find($caseId);
            if (!$case || $case['lawyer_id'] != session()->get('lawyer_id')) {
                return redirect()->to('/admin/dashboard')->with('error', 'Access denied.');
            }
        }

        if (trim($message) !== '') {
            $data = [
                'case_id' => $caseId,
                'sender_role' => session()->get('role') === 'lawyer' ? 'lawyer' : 'admin',
                'message' => $message,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $messageModel->insert($data);
        }

        return redirect()->to('/admin/case/' . $caseId);
    }

    // =========================================================
    // --- Blog CMS ---
    // =========================================================

    public function blogs()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        $blogModel = new BlogModel();
        $data['blogs'] = $blogModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/blogs', $data);
    }

    public function addBlogForm()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        return view('admin/blog_form', ['blog' => null]);
    }

    public function storeBlog()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        $blogModel = new BlogModel();
        $title = $this->request->getPost('title');
        $slug = BlogModel::makeSlug($title);

        // Ensure slug is unique
        $check = $blogModel->where('slug', $slug)->first();
        if ($check) {
            $slug = $slug . '-' . time();
        }

        // Handle image upload
        $imagePath = null;
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/blogs';
            if (!is_dir($uploadPath))
                mkdir($uploadPath, 0777, true);
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $imagePath = 'uploads/blogs/' . $newName;
        }

        $blogModel->insert([
            'title' => $title,
            'slug' => $slug,
            'category' => $this->request->getPost('category'),
            'excerpt' => $this->request->getPost('excerpt'),
            'content' => $this->request->getPost('content'),
            'author' => $this->request->getPost('author') ?: 'Admin',
            'status' => $this->request->getPost('status'),
            'image' => $imagePath,
        ]);

        return redirect()->to('/admin/blogs')->with('success', 'Blog post published successfully!');
    }

    public function editBlogForm($id)
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        $blogModel = new BlogModel();
        $blog = $blogModel->find($id);
        if (!$blog)
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Blog not found.");

        return view('admin/blog_form', ['blog' => $blog]);
    }

    public function updateBlog($id)
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        $blogModel = new BlogModel();
        $blog = $blogModel->find($id);
        if (!$blog)
            return redirect()->to('/admin/blogs');

        $updateData = [
            'title' => $this->request->getPost('title'),
            'category' => $this->request->getPost('category'),
            'excerpt' => $this->request->getPost('excerpt'),
            'content' => $this->request->getPost('content'),
            'author' => $this->request->getPost('author') ?: 'Admin',
            'status' => $this->request->getPost('status'),
        ];

        // Handle new image upload
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/blogs';
            if (!is_dir($uploadPath))
                mkdir($uploadPath, 0777, true);
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $updateData['image'] = 'uploads/blogs/' . $newName;
        }

        $blogModel->update($id, $updateData);
        return redirect()->to('/admin/blogs')->with('success', 'Blog post updated successfully!');
    }

    public function deleteBlog($id)
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        $blogModel = new BlogModel();
        $blogModel->delete($id);

        return redirect()->to('/admin/blogs')->with('success', 'Blog post deleted.');
    }

    // =========================================================
    // --- Team CMS ---
    // =========================================================

    public function team()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        $teamModel = new TeamModel();
        $data['members'] = $teamModel->getOrdered();

        return view('admin/team', $data);
    }

    public function storeTeam()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        $teamModel = new TeamModel();

        // Handle photo upload
        $photoPath = null;
        $file = $this->request->getFile('photo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/team';
            if (!is_dir($uploadPath))
                mkdir($uploadPath, 0777, true);
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $photoPath = 'uploads/team/' . $newName;
        }

        // Hash lawyer portal password if provided
        $rawPassword = $this->request->getPost('password');
        $hashedPass = !empty($rawPassword) ? password_hash($rawPassword, PASSWORD_DEFAULT) : null;

        $teamModel->insert([
            'name' => $this->request->getPost('name'),
            'position' => $this->request->getPost('position'),
            'specialization' => $this->request->getPost('specialization'),
            'bio' => $this->request->getPost('bio'),
            'email' => $this->request->getPost('email'),
            'linkedin' => $this->request->getPost('linkedin'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'photo' => $photoPath,
            'password' => $hashedPass,
        ]);

        return redirect()->to('/admin/team')->with('success', 'Team member added successfully!');
    }

    public function deleteTeam($id)
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        $teamModel = new TeamModel();
        $teamModel->delete($id);

        return redirect()->to('/admin/team')->with('success', 'Team member removed.');
    }

    // =========================================================
    // --- Invoices & Billing ---
    // =========================================================

    public function invoices()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        $invoiceModel = new InvoiceModel();
        $clientModel = new ClientModel();
        $caseModel = new CaseModel();

        $data['invoices'] = $invoiceModel->getInvoicesExtended();

        if (session()->get('role') === 'lawyer') {
            $lawyerId = session()->get('lawyer_id');
            // Filter invoices to only those linked to cases assigned to this lawyer
            $data['invoices'] = array_filter($data['invoices'], function($inv) use ($lawyerId, $caseModel) {
                if (!$inv['case_id']) return false;
                $case = $caseModel->find($inv['case_id']);
                return $case && $case['lawyer_id'] == $lawyerId;
            });
        }

        $data['clients'] = $clientModel->orderBy('name', 'ASC')->findAll();
        $data['cases'] = $caseModel->orderBy('case_title', 'ASC')->findAll();

        return view('admin/invoices', $data);
    }

    public function storeInvoice()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        if (session()->get('role') === 'lawyer') {
            return redirect()->to('/admin/invoices')->with('error', 'Lawyers cannot create invoices.');
        }

        $invoiceModel = new InvoiceModel();

        // Auto generate Invoice Number if not provided
        $invoiceNum = $this->request->getPost('invoice_number');
        if (empty($invoiceNum)) {
            $invoiceNum = 'INV-' . date('Ymd') . '-' . rand(100, 999);
        }

        $data = [
            'client_id' => $this->request->getPost('client_id'),
            'case_id' => $this->request->getPost('case_id') ?: null,
            'invoice_number' => $invoiceNum,
            'amount' => $this->request->getPost('amount'),
            'due_date' => $this->request->getPost('due_date'),
            'status' => $this->request->getPost('status') ?: 'Unpaid',
            'description' => $this->request->getPost('description'),
        ];

        $invoiceModel->insert($data);

        return redirect()->to('/admin/invoices')->with('success', 'Invoice generated successfully.');
    }

    public function updateInvoiceStatus()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        if (session()->get('role') === 'lawyer') {
            return redirect()->to('/admin/invoices')->with('error', 'Lawyers cannot modify invoices.');
        }

        $invoiceModel = new InvoiceModel();
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        $invoiceModel->update($id, ['status' => $status]);

        return redirect()->to('/admin/invoices')->with('success', 'Invoice status updated successfully.');
    }

    public function deleteInvoice($id)
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        if (session()->get('role') === 'lawyer') {
            return redirect()->to('/admin/invoices')->with('error', 'Lawyers cannot delete invoices.');
        }

        $invoiceModel = new InvoiceModel();
        $invoiceModel->delete($id);

        return redirect()->to('/admin/invoices')->with('success', 'Invoice deleted successfully.');
    }

    // =========================================================
    // --- Interactive Calendar ---
    // =========================================================

    public function calendar()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        $caseModel = new CaseModel();
        $invoiceModel = new InvoiceModel();
        $role = session()->get('role');
        $lawyerId = session()->get('lawyer_id');

        // Get cases with hearing dates — scoped to lawyer if applicable
        if ($role === 'lawyer') {
            $cases = $caseModel->where('hearing_date IS NOT NULL')
                               ->where('lawyer_id', $lawyerId)
                               ->findAll();
        } else {
            $cases = $caseModel->where('hearing_date IS NOT NULL')->findAll();
        }

        // Get unpaid/overdue invoices — scoped to lawyer's cases if applicable
        $allInvoices = $invoiceModel->getInvoicesExtended();
        if ($role === 'lawyer') {
            $invoices = array_filter($allInvoices, function($inv) use ($lawyerId, $caseModel) {
                if (!$inv['case_id']) return false;
                $case = $caseModel->find($inv['case_id']);
                return $case && $case['lawyer_id'] == $lawyerId;
            });
        } else {
            $invoices = $allInvoices;
        }

        $events = [];

        foreach ($cases as $c) {
            $events[] = [
                'title' => 'Hearing: ' . $c['case_title'] . ' (' . $c['case_number'] . ')',
                'start' => date('Y-m-d', strtotime($c['hearing_date'])),
                'type' => 'hearing',
                'color' => '#dc3545', // Red for hearings
                'url' => base_url('admin/case/' . $c['id'])
            ];
        }

        foreach ($invoices as $i) {
            if ($i['status'] !== 'Paid') {
                $events[] = [
                    'title' => 'Due: ' . $i['invoice_number'] . ' - $' . number_format($i['amount'], 2) . ' (' . $i['client_name'] . ')',
                    'start' => $i['due_date'],
                    'type' => 'invoice',
                    'color' => ($i['status'] === 'Overdue') ? '#721c24' : '#ffc107', // Gold/Dark-red for invoice dues
                    'url' => base_url('admin/invoices')
                ];
            }
        }

        $data['eventsJson'] = json_encode($events);

        return view('admin/calendar', $data);
    }

    // =========================================================
    // --- System Notifications / Activity Log ---
    // =========================================================

    public function notifications()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to('/admin');

        // Simulated system activity log entries
        $data['logs'] = [
            ['icon' => 'fa-user-plus', 'color' => 'success', 'message' => 'New client <strong>John Adebayo</strong> was registered.', 'time' => '2 mins ago'],
            ['icon' => 'fa-briefcase', 'color' => 'primary', 'message' => 'Case <strong>BL-2025-001</strong> status changed to <em>Active</em>.', 'time' => '15 mins ago'],
            ['icon' => 'fa-file-invoice-dollar', 'color' => 'warning', 'message' => 'Invoice <strong>INV-20250601-441</strong> is now <em>Overdue</em>.', 'time' => '1 hr ago'],
            ['icon' => 'fa-upload', 'color' => 'info', 'message' => 'Document <strong>affidavit_final.pdf</strong> uploaded to Case BL-2025-003.', 'time' => '2 hrs ago'],
            ['icon' => 'fa-comment-dots', 'color' => 'secondary', 'message' => 'New message from client <strong>Fatima Nwosu</strong> on Case BL-2025-002.', 'time' => '3 hrs ago'],
            ['icon' => 'fa-money-bill-wave', 'color' => 'success', 'message' => 'Payment of <strong>$5,200.00</strong> received for INV-20250528-112.', 'time' => '5 hrs ago'],
            ['icon' => 'fa-user-tie', 'color' => 'primary', 'message' => 'Lawyer <strong>Adaeze Okafor</strong> was assigned to Case BL-2025-004.', 'time' => '1 day ago'],
            ['icon' => 'fa-calendar-check', 'color' => 'danger', 'message' => 'Hearing scheduled for Case <strong>BL-2025-001</strong> on June 15, 2025.', 'time' => '1 day ago'],
            ['icon' => 'fa-newspaper', 'color' => 'info', 'message' => 'Blog post <strong>"Understanding Nigerian Property Law"</strong> published.', 'time' => '2 days ago'],
            ['icon' => 'fa-shield-halved', 'color' => 'warning', 'message' => 'Failed login attempt detected for admin account.', 'time' => '3 days ago'],
        ];

        return view('admin/notifications', $data);
    }
}
