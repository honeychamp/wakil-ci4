<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\TeamModel;
use App\Models\ClientModel;
use App\Models\CaseModel;

class Home extends BaseController
{
    /**
     * The 10 practice areas of Brocelle Law Firm.
     * Each has a slug (URL), name, icon, short description, and detailed info.
     */
    private function getLaws(): array
    {
        return [
            'corporate-business-law' => [
                'slug'        => 'corporate-business-law',
                'name'        => 'Corporate & Business Law',
                'icon'        => 'fa-briefcase',
                'color'       => '#0b1f3a',
                'tagline'     => 'Protecting your business at every stage.',
                'description' => 'We provide comprehensive legal support to businesses of all sizes — from startups to large corporations. Our experienced attorneys handle everything from company formation to complex commercial disputes.',
                'details'     => [
                    'What We Handle' => [
                        'Business Formation & LLC Registration',
                        'Corporate Governance & Compliance',
                        'Mergers, Acquisitions & Due Diligence',
                        'Contract Drafting, Review & Negotiation',
                        'Shareholder Agreements & Disputes',
                        'Joint Ventures & Partnerships',
                    ],
                    'Common Issues' => [
                        'Partner disputes over company assets',
                        'Breach of contract by vendors or customers',
                        'Regulatory non-compliance or license issues',
                        'Hostile takeover attempts',
                    ],
                    'Expected Fees'    => 'PKR 25,000 – 150,000+ depending on complexity',
                    'Timeline'         => '1 week to 6+ months based on case type',
                    'What You Can Do'  => 'Gather all company documents, contracts, and correspondence. Note all dates of important events.',
                ],
            ],

            'criminal-defense' => [
                'slug'        => 'criminal-defense',
                'name'        => 'Criminal Defense',
                'icon'        => 'fa-gavel',
                'color'       => '#7b1f1f',
                'tagline'     => 'Your freedom is our priority.',
                'description' => 'Facing criminal charges can be the most terrifying experience of your life. Our aggressive criminal defense team fights tirelessly to protect your rights, freedom, and reputation.',
                'details'     => [
                    'What We Handle' => [
                        'White-Collar Crimes & Financial Fraud',
                        'Drug Offenses & Trafficking',
                        'DUI & Traffic Violations',
                        'Assault, Battery & Violent Crimes',
                        'Cybercrime & Digital Offenses',
                        'Murder & Manslaughter Defense',
                    ],
                    'Common Issues' => [
                        'False accusations or planted evidence',
                        'Wrongful arrest or illegal search',
                        'First-time offender seeking minimal penalty',
                        'Need for bail negotiation',
                    ],
                    'Expected Fees'    => 'PKR 30,000 – 200,000+ depending on severity',
                    'Timeline'         => '1 month to 2+ years for serious cases',
                    'What You Can Do'  => 'Do NOT speak to police without your lawyer. Write down everything you remember about the incident.',
                ],
            ],

            'family-divorce-law' => [
                'slug'        => 'family-divorce-law',
                'name'        => 'Family & Divorce Law',
                'icon'        => 'fa-house-chimney-heart',
                'color'       => '#6b3a2a',
                'tagline'     => 'Compassionate guidance through difficult times.',
                'description' => 'Family legal matters are deeply personal. We provide sensitive, efficient representation in all family law matters, always keeping the best interests of children and all parties in focus.',
                'details'     => [
                    'What We Handle' => [
                        'Divorce & Legal Separation (Khula/Talaq)',
                        'Child Custody & Visitation Rights',
                        'Child & Spousal Support (Alimony / Nafaqa)',
                        'Adoption & Foster Care Proceedings',
                        'Domestic Violence Protection Orders',
                        'Prenuptial & Postnuptial Agreements',
                    ],
                    'Common Issues' => [
                        'Spouse refusing to agree to divorce terms',
                        'Custody battle over children',
                        'Non-payment of maintenance (Nafaqa)',
                        'Property division disputes after separation',
                    ],
                    'Expected Fees'    => 'PKR 15,000 – 80,000+ depending on complexity',
                    'Timeline'         => '2 months to 1 year for contested cases',
                    'What You Can Do'  => 'Collect Nikah Nama, property documents, and any evidence of abuse or misconduct.',
                ],
            ],

            'real-estate-property-law' => [
                'slug'        => 'real-estate-property-law',
                'name'        => 'Real Estate & Property Law',
                'icon'        => 'fa-building',
                'color'       => '#2a5c3a',
                'tagline'     => 'Securing your property rights.',
                'description' => 'Whether you are buying, selling, renting, or in a property dispute, our real estate attorneys ensure your interests are fully protected at every step.',
                'details'     => [
                    'What We Handle' => [
                        'Property Purchase & Sale Agreements',
                        'Title Verification & Ownership Disputes',
                        'Landlord-Tenant Disputes & Eviction',
                        'Inheritance & Property Division (Wirasat)',
                        'Illegal Encroachment Cases',
                        'Construction & Contractor Disputes',
                    ],
                    'Common Issues' => [
                        'Disputed property ownership or fake documents',
                        'Landlord refusing to return security deposit',
                        'Illegal occupation of inherited property',
                        'Developer not delivering promised project',
                    ],
                    'Expected Fees'    => 'PKR 20,000 – 100,000+',
                    'Timeline'         => '3 months to several years for court battles',
                    'What You Can Do'  => 'Gather all property documents: Sale Deed, Fard, Mutation records, Rent Agreement.',
                ],
            ],

            'personal-injury-law' => [
                'slug'        => 'personal-injury-law',
                'name'        => 'Personal Injury Law',
                'icon'        => 'fa-person-falling',
                'color'       => '#1a3a5c',
                'tagline'     => 'You deserve compensation for your suffering.',
                'description' => 'If you have been injured due to someone else\'s negligence, you deserve full and fair compensation. Our personal injury lawyers are experienced in maximizing your recovery.',
                'details'     => [
                    'What We Handle' => [
                        'Road & Traffic Accident Claims',
                        'Medical Malpractice & Negligence',
                        'Workplace Injury & Accidents',
                        'Defective Products & Consumer Harm',
                        'Slip & Fall Accidents',
                        'Wrongful Death Claims',
                    ],
                    'Common Issues' => [
                        'Insurance company denying or undervaluing claim',
                        'Medical bills piling up after accident',
                        'Employer blaming employee for workplace injury',
                        'Doctor\'s error causing permanent disability',
                    ],
                    'Expected Fees'    => 'Often on contingency (no win, no fee) basis',
                    'Timeline'         => '3 to 18 months',
                    'What You Can Do'  => 'Get medical treatment immediately. Keep all medical bills and photos of injuries. Collect witness contacts.',
                ],
            ],

            'employment-labor-law' => [
                'slug'        => 'employment-labor-law',
                'name'        => 'Employment & Labor Law',
                'icon'        => 'fa-hard-hat',
                'color'       => '#4a3a0a',
                'tagline'     => 'Protecting workers and employers alike.',
                'description' => 'Whether you are an employee facing workplace injustice or an employer navigating complex labor regulations, our team provides clear, decisive legal guidance.',
                'details'     => [
                    'What We Handle' => [
                        'Wrongful Termination & Unfair Dismissal',
                        'Workplace Harassment & Discrimination',
                        'Salary, Wage & Overtime Disputes',
                        'Employment Contract Review',
                        'Non-Compete & Confidentiality Agreements',
                        'Labor Court Representation',
                    ],
                    'Common Issues' => [
                        'Fired without valid reason or proper notice',
                        'Not paid overtime or full salary',
                        'Harassed by manager or senior employee',
                        'Forced to sign unfair employment contract',
                    ],
                    'Expected Fees'    => 'PKR 15,000 – 60,000+',
                    'Timeline'         => '1 to 12 months',
                    'What You Can Do'  => 'Keep copies of your appointment letter, payslips, and any threatening messages or emails from employer.',
                ],
            ],

            'immigration-law' => [
                'slug'        => 'immigration-law',
                'name'        => 'Immigration Law',
                'icon'        => 'fa-passport',
                'color'       => '#0a3a4a',
                'tagline'     => 'Navigating borders, opening doors.',
                'description' => 'Immigration law is complex and constantly changing. Our immigration attorneys help individuals, families, and businesses navigate visa applications, citizenship processes, and deportation defense.',
                'details'     => [
                    'What We Handle' => [
                        'Visa Applications & Extensions',
                        'Work Permit & Residency Processing',
                        'Family Sponsorship & Reunification',
                        'Citizenship & Naturalization Applications',
                        'Deportation Defense',
                        'Asylum & Refugee Status Claims',
                    ],
                    'Common Issues' => [
                        'Visa rejected or delayed without clear reason',
                        'Overstay issues and fear of deportation',
                        'Employer sponsoring wrong visa category',
                        'Family reunion application stuck in backlog',
                    ],
                    'Expected Fees'    => 'PKR 20,000 – 120,000+ depending on destination country',
                    'Timeline'         => '1 month to 2+ years for citizenship',
                    'What You Can Do'  => 'Gather all travel documents, previous visa rejections, employment contracts, and financial statements.',
                ],
            ],

            'intellectual-property-law' => [
                'slug'        => 'intellectual-property-law',
                'name'        => 'Intellectual Property (IP) Law',
                'icon'        => 'fa-lightbulb',
                'color'       => '#3a0a5c',
                'tagline'     => 'Protecting your ideas, innovations, and brand.',
                'description' => 'Your creative work and innovations are valuable assets. Our IP lawyers help you register, protect, and enforce your intellectual property rights against infringement and theft.',
                'details'     => [
                    'What We Handle' => [
                        'Trademark Registration & Protection',
                        'Copyright Registration & Infringement Cases',
                        'Patent Filing & Defense',
                        'Trade Secret & Confidentiality Protection',
                        'Brand Name & Logo Disputes',
                        'Technology & Software Licensing',
                    ],
                    'Common Issues' => [
                        'Someone using your brand name or logo',
                        'Competitor copying your product design',
                        'Plagiarism of creative content or software',
                        'Breach of licensing agreement',
                    ],
                    'Expected Fees'    => 'PKR 25,000 – 150,000+',
                    'Timeline'         => '2 months to 2 years for full registration',
                    'What You Can Do'  => 'Document your original work with dates (emails, design files). Take screenshots of any infringement immediately.',
                ],
            ],

            'bankruptcy-debt-law' => [
                'slug'        => 'bankruptcy-debt-law',
                'name'        => 'Bankruptcy & Debt Law',
                'icon'        => 'fa-scale-unbalanced',
                'color'       => '#5c2a0a',
                'tagline'     => 'A fresh financial start is possible.',
                'description' => 'Overwhelming debt can feel impossible to escape. Our bankruptcy and debt resolution attorneys help you understand your options and find the best path forward to financial recovery.',
                'details'     => [
                    'What We Handle' => [
                        'Personal Bankruptcy Filing',
                        'Business Insolvency & Winding Up',
                        'Debt Restructuring & Negotiation',
                        'Creditor Harassment & Illegal Recovery',
                        'Bank Loan Default Defense',
                        'Asset Protection Planning',
                    ],
                    'Common Issues' => [
                        'Cannot pay bank loans or credit card debt',
                        'Creditors or recovery agents harassing family',
                        'Business unable to pay suppliers or employees',
                        'Property being auctioned due to bank default',
                    ],
                    'Expected Fees'    => 'PKR 20,000 – 80,000+',
                    'Timeline'         => '3 to 18 months',
                    'What You Can Do'  => 'List all debts, creditors, assets, and income. Stop ignoring calls — let your lawyer handle all communication.',
                ],
            ],

            'tax-financial-law' => [
                'slug'        => 'tax-financial-law',
                'name'        => 'Tax & Financial Law',
                'icon'        => 'fa-file-invoice-dollar',
                'color'       => '#0a4a1a',
                'tagline'     => 'Legally minimize your tax burden.',
                'description' => 'Navigating Pakistan\'s complex tax laws requires expert guidance. Our tax attorneys help individuals and businesses ensure full compliance, minimize tax liability, and resolve FBR disputes.',
                'details'     => [
                    'What We Handle' => [
                        'Income Tax Return Filing & Compliance',
                        'FBR Audit Defense & Notices',
                        'Tax Planning & Optimization',
                        'Sales Tax / GST Registration & Disputes',
                        'Customs & Import Duty Disputes',
                        'Financial Fraud & Money Laundering Defense',
                    ],
                    'Common Issues' => [
                        'Received FBR audit notice or demand',
                        'Tax return rejected or under scrutiny',
                        'Confused about filer vs non-filer status',
                        'Business facing heavy sales tax penalties',
                    ],
                    'Expected Fees'    => 'PKR 15,000 – 100,000+',
                    'Timeline'         => '1 month to 1 year for complex disputes',
                    'What You Can Do'  => 'Gather all tax returns, FBR notices, bank statements, and business financial records.',
                ],
            ],
        ];
    }

    // ------------------------------------------------------------------
    // Public Pages
    // ------------------------------------------------------------------

    public function index(): string
    {
        $blogModel = new BlogModel();
        $teamModel = new TeamModel();
        $laws      = $this->getLaws();

        $data = [
            'title'        => 'Home',
            'latestBlogs'  => $blogModel->getPublished() ? array_slice($blogModel->getPublished(), 0, 3) : [],
            'teamMembers'  => $teamModel->getOrdered(),
            'laws'         => $laws,
        ];

        return view('home', $data);
    }

    public function about(): string
    {
        $data = ['title' => 'About Us'];
        return view('about', $data);
    }

    /**
     * List all 10 practice areas on the Services page.
     */
    public function services(): string
    {
        $data = [
            'title' => 'Practice Areas',
            'laws'  => $this->getLaws(),
        ];
        return view('services', $data);
    }

    /**
     * Show the detailed page for a single law/practice area.
     * The slug in the URL determines which law to display.
     */
    public function serviceDetail(string $slug): string
    {
        $laws = $this->getLaws();

        if (!isset($laws[$slug])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Practice area not found.");
        }

        $data = [
            'title' => $laws[$slug]['name'] . ' - Brocelle Law Firm',
            'law'   => $laws[$slug],
        ];

        return view('service_detail', $data);
    }

    /**
     * Handle case submission from the public law detail page.
     * 
     * Workflow:
     * 1. Validate input.
     * 2. Create client account if email not found (auto-generate password).
     * 3. Auto-assign case to a lawyer specializing in that law area.
     * 4. Log the client in automatically.
     * 5. Show credentials via SweetAlert and redirect to portal.
     */
    public function submitCaseRequest()
    {
        // 1. Validate the form
        $rules = [
            'full_name'    => 'required|min_length[3]',
            'email'        => 'required|valid_email',
            'phone'        => 'required|min_length[7]',
            'law_slug'     => 'required',
            'issue_title'  => 'required|min_length[5]',
            'issue_detail' => 'required|min_length[20]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Please fill in all required fields correctly.');
        }

        $clientModel = new ClientModel();
        $caseModel   = new CaseModel();
        $teamModel   = new TeamModel();
        $laws        = $this->getLaws();

        $lawSlug  = $this->request->getPost('law_slug');
        $lawName  = $laws[$lawSlug]['name'] ?? $lawSlug;
        $email    = $this->request->getPost('email');
        $name     = $this->request->getPost('full_name');
        $phone    = $this->request->getPost('phone');

        // 2. Check if client already exists; if not, create new account
        $isNewClient   = false;
        $plainPassword = '';
        $client        = $clientModel->where('email', $email)->first();

        if (!$client) {
            // Auto-generate a secure password
            $plainPassword = 'BRO-' . strtoupper(substr(md5(uniqid()), 0, 8));
            $clientData    = [
                'name'     => $name,
                'email'    => $email,
                'phone'    => $phone,
                'password' => password_hash($plainPassword, PASSWORD_DEFAULT),
            ];
            $clientId    = $clientModel->insert($clientData);
            $client      = $clientModel->find($clientId);
            $isNewClient = true;
        } else {
            $clientId = $client['id'];
        }

        // 3. Find a lawyer who specializes in this law area
        $lawyer   = $teamModel->findBySpecialization($lawName);
        $lawyerId = $lawyer ? $lawyer['id'] : null;

        // 4. Create the case record
        $caseNumber = 'BRO-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $caseData   = [
            'client_id'     => $clientId,
            'lawyer_id'     => $lawyerId,
            'case_title'    => $this->request->getPost('issue_title'),
            'case_number'   => $caseNumber,
            'description'   => $this->request->getPost('issue_detail') . "\n\nExpected Outcome: " . $this->request->getPost('expected_outcome'),
            'practice_area' => $lawName,
            'status'        => 'Pending Evaluation',
        ];
        $caseModel->insert($caseData);

        // 5. Do NOT log the client in automatically. They must log in themselves.
        // Set credentials flash for SweetAlert display in the portal
        if ($isNewClient) {
            session()->setFlashdata('new_account', json_encode([
                'email'    => $email,
                'password' => $plainPassword,
            ]));
            session()->setFlashdata('success', 'Your case has been filed! Your account has been created. Please log in with the credentials shown.');
        } else {
            session()->setFlashdata('success', 'Your case "' . $this->request->getPost('issue_title') . '" has been filed successfully and assigned to our team!');
        }

        return redirect()->to('/client'); // Redirect to login page
    }

    public function team(): string
    {
        $teamModel = new TeamModel();
        $data = [
            'title'   => 'Our Team',
            'members' => $teamModel->getOrdered(),
        ];
        return view('team', $data);
    }

    public function contact(): string
    {
        $data = ['title' => 'Contact Us'];
        return view('contact', $data);
    }

    public function blog(): string
    {
        $blogModel = new BlogModel();
        $data = [
            'title' => 'Legal Blog',
            'blogs' => $blogModel->getPublished(),
        ];
        return view('blog', $data);
    }

    public function blogDetail(string $slug): string
    {
        $blogModel = new BlogModel();
        $blog      = $blogModel->getBySlug($slug);

        if (!$blog) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Blog post not found.");
        }

        return view('blog_detail', [
            'title' => $blog['title'],
            'blog'  => $blog,
        ]);
    }
}
