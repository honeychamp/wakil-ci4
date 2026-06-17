<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($case['case_title']) ?> - Case Details</title>
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
                    <a href="<?= base_url('client/dashboard') ?>" class="btn btn-sm btn-outline-light px-3">&larr; Dashboard</a>
                    <a href="<?= base_url('client/logout') ?>" class="btn btn-sm btn-outline-danger px-3">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="container py-5">
        
        <!-- Flash Alerts -->
        <?php if(session()->getFlashdata('success')): ?>
            <!-- Handled by SweetAlert2 -->
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <!-- Handled by SweetAlert2 -->
        <?php endif; ?>

        <!-- Case Header Info -->
        <div class="card card-custom mb-4 bg-white">
            <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">My Case File</span>
                    <h3 class="fw-bold mb-1" style="color: var(--primary-color); font-family: 'Playfair Display', serif;"><?= esc($case['case_title']) ?></h3>
                    <p class="mb-0 text-muted">Docket Number: <code class="text-dark fw-bold"><?= esc($case['case_number']) ?></code></p>
                </div>
                <div class="mt-3 mt-md-0">
                    <?php
                    $badgeClass = match($case['status']) {
                        'Active' => 'bg-primary',
                        'Won'    => 'bg-success',
                        'Lost'   => 'bg-danger',
                        'Closed' => 'bg-secondary',
                        default  => 'bg-info'
                    };
                    ?>
                    <span class="fs-6 badge <?= $badgeClass ?> px-3 py-2"><?= esc($case['status']) ?></span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Case Info & Hearings -->
            <div class="col-lg-4">
                <div class="card card-custom p-4 bg-white mb-4">
                    <h5 class="fw-bold mb-3" style="color: var(--primary-color); font-family: 'Playfair Display', serif;">
                        <i class="fa-solid fa-circle-info me-2 text-muted"></i>Case Overview
                    </h5>
                    
                    <p class="fw-bold small mb-1 text-muted">Description / Summary</p>
                    <p class="text-muted small mb-4"><?= nl2br(esc($case['description'] ?: 'No summary description details entered.')) ?></p>
                    
                    <p class="fw-bold small mb-1 text-muted">Next Scheduled Hearing</p>
                    <p class="mb-0">
                        <i class="fa-solid fa-calendar-days me-2 text-muted"></i>
                        <?php if($case['hearing_date']): ?>
                            <strong><?= date('d M Y, h:i A', strtotime($case['hearing_date'])) ?></strong>
                        <?php else: ?>
                            <span class="text-muted">No hearings scheduled yet.</span>
                        <?php endif; ?>
                    </p>
                </div>

                <!-- Counsel Details -->
                <div class="card card-custom p-4 bg-white">
                    <h5 class="fw-bold mb-3" style="color: var(--primary-color); font-family: 'Playfair Display', serif;">
                        <i class="fa-solid fa-gavel me-2 text-muted"></i>Legal Counsel
                    </h5>
                    <p class="mb-2"><strong>Brocelle Representation</strong></p>
                    <p class="text-muted small mb-0"><i class="fa-solid fa-envelope me-1"></i> counsel@brocellelaw.com</p>
                    <p class="text-muted small"><i class="fa-solid fa-phone me-1"></i> +1 (800) 123-4567</p>
                </div>
            </div>

            <!-- Right Column: Document Vault & Chat -->
            <div class="col-lg-8">
                <!-- Document Vault -->
                <div class="card card-custom bg-white mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                        <h5 class="mb-0 fw-bold" style="color: var(--primary-color); font-family: 'Playfair Display', serif;">
                            <i class="fa-solid fa-box-archive me-2" style="color: var(--secondary-color);"></i>Document Vault
                        </h5>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#clientUploadCollapse">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload Document
                        </button>
                    </div>
                    <div class="card-body">
                        <!-- Collapsible client upload form -->
                        <div class="collapse mb-3" id="clientUploadCollapse">
                            <form action="<?= base_url('client/uploadCaseDocument') ?>" method="POST" enctype="multipart/form-data" class="p-3 bg-light rounded border">
                                <?= csrf_field() ?>
                                <input type="hidden" name="case_id" value="<?= $case['id'] ?>">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-5">
                                        <label class="form-label small fw-bold mb-1">Select File</label>
                                        <input type="file" name="file" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label small fw-bold mb-1">Description / Memo</label>
                                        <input type="text" name="description" class="form-control form-control-sm" placeholder="e.g. Identity Proof / Contract copy" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Document List -->
                        <?php if(empty($documents)): ?>
                            <div class="text-center py-4 text-muted small">
                                <i class="fa-regular fa-folder-open fa-2x mb-2 d-block"></i> No files exchanged yet.
                            </div>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach($documents as $doc): ?>
                                    <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-3 text-danger me-3"><i class="fa-solid fa-file-lines"></i></div>
                                            <div>
                                                <h6 class="mb-0 fw-bold small"><?= esc($doc['file_name']) ?></h6>
                                                <p class="mb-0 text-muted small"><?= esc($doc['description']) ?></p>
                                                <small class="text-muted" style="font-size: 0.75rem;">
                                                    Shared by: <span class="badge bg-secondary"><?= $doc['uploaded_by'] === 'client' ? 'You' : 'Lawyer' ?></span> | <?= date('d M Y h:i A', strtotime($doc['created_at'])) ?>
                                                </small>
                                            </div>
                                        </div>
                                        <a href="<?= base_url($doc['file_path']) ?>" class="btn btn-sm btn-light" target="_blank" download>
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Messaging -->
                <div class="card card-custom bg-white">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="mb-0 fw-bold" style="color: var(--primary-color); font-family: 'Playfair Display', serif;">
                            <i class="fa-solid fa-comments me-2" style="color: var(--secondary-color);"></i>Counsel Communication
                        </h5>
                    </div>
                    <div class="card-body bg-light" style="max-height: 350px; overflow-y: auto;">
                        <?php if(empty($messages)): ?>
                            <div class="text-center py-5 text-muted small">
                                <i class="fa-regular fa-comments fa-2x mb-2 d-block"></i> No messages. Post a secure inquiry to your counsel below.
                            </div>
                        <?php else: ?>
                            <div class="d-flex flex-column gap-3">
                                <?php foreach($messages as $msg): ?>
                                    <?php $isClient = ($msg['sender_role'] === 'client'); ?>
                                    <div class="d-flex flex-column <?= $isClient ? 'align-items-end' : 'align-items-start' ?>">
                                        <div class="p-3 rounded shadow-sm text-white" style="max-width: 75%; font-size: 0.9rem; background-color: <?= $isClient ? '#c5a859' : '#0b1f3a' ?>; border-radius: 12px !important; color: <?= $isClient ? '#0b1f3a !important' : '#ffffff !important' ?>;">
                                            <?= nl2br(esc($msg['message'])) ?>
                                        </div>
                                        <small class="text-muted mt-1 px-2" style="font-size: 0.7rem;">
                                            <?= $isClient ? 'You' : 'Counsel' ?> | <?= date('d M h:i A', strtotime($msg['created_at'])) ?>
                                        </small>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Message Post Box -->
                    <div class="card-footer bg-white border-0 py-3">
                        <form action="<?= base_url('client/sendCaseMessage') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="case_id" value="<?= $case['id'] ?>">
                            <div class="input-group">
                                <textarea name="message" class="form-control" rows="1" placeholder="Type a message to your legal counsel..." required></textarea>
                                <button type="submit" class="btn btn-gold px-3">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <footer class="text-center text-muted small py-4 mt-5 border-top">
        &copy; <?= date('Y') ?> Brocelle Law Firm. All rights reserved. Secure Portal Interface.
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if(session()->getFlashdata('success')): ?>
                Swal.fire({
                    title: 'Success!',
                    text: "<?= esc(session()->getFlashdata('success')) ?>",
                    icon: 'success',
                    confirmButtonColor: '#c5a859'
                });
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                Swal.fire({
                    title: 'Action Failed',
                    text: "<?= esc(session()->getFlashdata('error')) ?>",
                    icon: 'error',
                    confirmButtonColor: '#0b1f3a'
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
