<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Case Dashboard - Brocelle Client Portal</title>
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
        .case-card {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            border-radius: 8px;
            transition: 0.3s;
        }
        .case-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
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
                        <a class="nav-link active fw-bold text-white" href="<?= base_url('client/dashboard') ?>"><i class="fa-solid fa-briefcase me-1"></i> Cases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="<?= base_url('client/invoices') ?>"><i class="fa-solid fa-file-invoice-dollar me-1"></i> Invoices</a>
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
                <span class="text-muted small uppercase fw-bold">Overview</span>
                <h2 class="fw-bold" style="color: var(--primary-color); font-family: 'Playfair Display', serif;">My Legal Case Files</h2>
                <div style="width: 50px; height: 3px; background-color: var(--secondary-color); margin-top: 5px;"></div>
            </div>
        </div>

        <?php if(empty($cases)): ?>
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <i class="fa-solid fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5 class="fw-bold">No Cases Registered Yet</h5>
                    <p class="text-muted mb-0">Our legal counsel hasn't initialized any case files for your account. Please contact us directly for status updates.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach($cases as $case): ?>
                    <div class="col-md-6">
                        <div class="card case-card p-4 bg-white">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge bg-light text-dark border mb-1">Docket: <?= esc($case['case_number']) ?></span>
                                    <h4 class="fw-bold mb-1" style="color: var(--primary-color); font-family: 'Playfair Display', serif;"><?= esc($case['case_title']) ?></h4>
                                </div>
                                <?php
                                $badgeClass = match($case['status']) {
                                    'Active' => 'bg-primary',
                                    'Won'    => 'bg-success',
                                    'Lost'   => 'bg-danger',
                                    'Closed' => 'bg-secondary',
                                    default  => 'bg-info'
                                };
                                ?>
                                <span class="badge <?= $badgeClass ?> px-2 py-1"><?= esc($case['status']) ?></span>
                            </div>
                            
                            <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 40px;">
                                <?= esc($case['description'] ?: 'No summary description available.') ?>
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-auto">
                                <small class="text-muted">
                                    <i class="fa-regular fa-calendar-days me-1"></i> Opened: <?= date('d M Y', strtotime($case['created_at'])) ?>
                                </small>
                                <a href="<?= base_url('client/case/' . $case['id']) ?>" class="btn btn-sm btn-gold">
                                    Track Case &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="text-center text-muted small py-4 mt-5 border-top">
        &copy; <?= date('Y') ?> Brocelle Law Firm. All rights reserved. Secure Portal Interface.
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Show general success message (case filed, etc.)
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({
                title: 'Case Filed Successfully!',
                text: "<?= esc(session()->getFlashdata('success')) ?>",
                icon: 'success',
                confirmButtonColor: '#c5a859'
            });
        <?php endif; ?>



        // Show error if any
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
