<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Invoices &amp; Billing - Brocelle Client Portal</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0b1f3a;
            --secondary-color: #c5a859;
            --text-dark: #333;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Georgia', serif;
            color: var(--text-dark);
        }
        .header-custom {
            background-color: var(--primary-color);
            border-bottom: 3px solid var(--secondary-color);
            color: white;
        }
        .navbar-brand-portal {
            color: var(--secondary-color) !important;
            font-family: 'Playfair Display', serif;
            font-weight: bold;
            font-size: 1.4rem;
        }
        .card-custom {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            border-radius: 8px;
        }
        .btn-gold {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-weight: bold;
            border: none;
        }
        .btn-gold:hover {
            background-color: #dcb865;
            color: var(--primary-color);
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark header-custom py-3">
        <div class="container">
            <a class="navbar-brand navbar-brand-portal" href="<?= base_url('client/dashboard') ?>">
                <i class="fa-solid fa-scale-balanced me-2"></i>Brocelle Client Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#clientNavbar" aria-controls="clientNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="clientNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="<?= base_url('client/dashboard') ?>"><i class="fa-solid fa-briefcase me-1"></i> Cases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold text-white" href="<?= base_url('client/invoices') ?>"><i class="fa-solid fa-file-invoice-dollar me-1"></i> Invoices</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="<?= base_url('client/calendar') ?>"><i class="fa-solid fa-calendar-days me-1"></i> Calendar</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="d-none d-md-inline text-white-50 small">Logged in: <strong><?= session()->get('client_name') ?></strong></span>
                    <a href="<?= base_url('client/logout') ?>" class="btn btn-sm btn-outline-danger px-3">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <span class="text-muted small uppercase fw-bold">Billing Dashboard</span>
                <h2 class="fw-bold" style="color: var(--primary-color); font-family: 'Playfair Display', serif;">My Invoices &amp; Statements</h2>
                <div style="width: 50px; height: 3px; background-color: var(--secondary-color); margin-top: 5px;"></div>
            </div>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <!-- Handled by SweetAlert2 -->
        <?php endif; ?>

        <?php if(empty($invoices)): ?>
            <div class="card card-custom border-0 shadow-sm text-center py-5 bg-white">
                <div class="card-body">
                    <i class="fa-solid fa-file-circle-exclamation fa-3x text-muted mb-3"></i>
                    <h5 class="fw-bold">No Invoices Issued</h5>
                    <p class="text-muted mb-0">You do not have any pending or completed billing statements at this time.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="card card-custom border-0 shadow-sm bg-white overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">Invoice Number</th>
                                <th>Case Description</th>
                                <th>Issued Date</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-center pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($invoices as $inv): ?>
                            <tr>
                                <td class="ps-4">
                                    <strong><?= esc($inv['invoice_number']) ?></strong>
                                </td>
                                <td>
                                    <?php if($inv['case_title']): ?>
                                        <span class="small fw-bold"><?= esc($inv['case_title']) ?></span><br>
                                        <small class="text-muted">Docket: <?= esc($inv['case_number']) ?></small>
                                    <?php else: ?>
                                        <span class="text-muted small">General Retainer / Consultation</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d M Y', strtotime($inv['created_at'])) ?></td>
                                <td>
                                    <span class="<?= ($inv['status'] !== 'Paid' && strtotime($inv['due_date']) < time()) ? 'text-danger fw-bold' : '' ?>">
                                        <?= date('d M Y', strtotime($inv['due_date'])) ?>
                                    </span>
                                </td>
                                <td><strong>$<?= number_format($inv['amount'], 2) ?></strong></td>
                                <td>
                                    <?php if($inv['status'] === 'Paid'): ?>
                                        <span class="badge bg-success">Paid</span>
                                    <?php elseif($inv['status'] === 'Overdue'): ?>
                                        <span class="badge bg-danger">Overdue</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Unpaid</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center pe-4">
                                    <a href="<?= base_url('client/invoice/' . $inv['id']) ?>" class="btn btn-sm btn-gold">
                                        View Invoice
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer class="text-center text-muted small py-4 mt-5 border-top">
        &copy; <?= date('Y') ?> Brocelle Law Firm. All rights reserved. Secure Portal Interface.
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if(session()->getFlashdata('error')): ?>
                Swal.fire({
                    title: 'Error',
                    text: "<?= esc(session()->getFlashdata('error')) ?>",
                    icon: 'error',
                    confirmButtonColor: '#0b1f3a'
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
