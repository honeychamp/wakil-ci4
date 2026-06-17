<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Brocelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #0b1f3a;
            --secondary-color: #c5a859;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #0b1f3a;
            color: white;
        }
        .sidebar a {
            color: #ccc;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #1a365d;
            color: #c5a859;
            border-left: 3px solid #c5a859;
        }
        .content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .topbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 p-0 sidebar d-none d-md-block">
            <div class="p-3 text-center border-bottom border-secondary mb-3">
                <?php if(session()->get('role') === 'lawyer'): ?>
                    <h5 class="m-0" style="color: #c5a859;"><i class="fa-solid fa-user-tie me-1"></i> Lawyer Portal</h5>
                    <small class="text-muted" style="font-size:0.7rem;">Restricted Access</small>
                <?php else: ?>
                    <h5 class="m-0" style="color: #c5a859;">Brocelle Admin</h5>
                <?php endif; ?>
            </div>
            <?php $uri = service('request')->getUri()->getPath(); ?>

            <a href="<?= base_url('admin/dashboard') ?>" class="<?= $uri === 'admin/dashboard' ? 'active' : '' ?>">
                <i class="fa-solid fa-gauge me-2"></i> Dashboard
            </a>

            <?php if(session()->get('role') !== 'lawyer'): ?>
            <a href="<?= base_url('admin/clients') ?>" class="<?= strpos($uri, 'admin/clients') !== false ? 'active' : '' ?>">
                <i class="fa-solid fa-users me-2"></i> Clients
            </a>
            <?php endif; ?>

            <a href="<?= base_url('admin/cases') ?>" class="<?= strpos($uri, 'admin/cases') !== false || strpos($uri, 'admin/case/') !== false ? 'active' : '' ?>">
                <i class="fa-solid fa-briefcase me-2"></i> Cases
            </a>

            <a href="<?= base_url('admin/invoices') ?>" class="<?= strpos($uri, 'admin/invoices') !== false ? 'active' : '' ?>">
                <i class="fa-solid fa-file-invoice-dollar me-2"></i> Invoices
            </a>

            <a href="<?= base_url('admin/calendar') ?>" class="<?= strpos($uri, 'admin/calendar') !== false ? 'active' : '' ?>">
                <i class="fa-solid fa-calendar-days me-2"></i> Calendar
            </a>

            <?php if(session()->get('role') !== 'lawyer'): ?>
            <div style="border-top: 1px solid #1a365d; margin: 10px 0;"></div>
            <small class="text-muted px-3 py-1 d-block" style="font-size:0.65rem; letter-spacing:1px; text-transform:uppercase;">Content Management</small>
            <a href="<?= base_url('admin/blogs') ?>" class="<?= strpos($uri, 'admin/blogs') !== false ? 'active' : '' ?>">
                <i class="fa-solid fa-newspaper me-2"></i> Blog CMS
            </a>
            <a href="<?= base_url('admin/team') ?>" class="<?= strpos($uri, 'admin/team') !== false ? 'active' : '' ?>">
                <i class="fa-solid fa-user-tie me-2"></i> Team CMS
            </a>
            <a href="<?= base_url('admin/notifications') ?>" class="<?= strpos($uri, 'admin/notifications') !== false ? 'active' : '' ?>">
                <i class="fa-solid fa-bell me-2"></i> Notifications
            </a>
            <?php endif; ?>

            <div style="border-top: 1px solid #1a365d; margin: 10px 0;"></div>
            <a href="<?= base_url() ?>" target="_blank">
                <i class="fa-solid fa-globe me-2"></i> View Website
            </a>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-0 content">
            <!-- Topbar -->
            <div class="topbar p-3 d-flex justify-content-between align-items-center mb-4">
                <h5 class="m-0 text-muted">
                    <?php if(session()->get('role') === 'lawyer'): ?>
                        <span class="badge me-2" style="background:#0b1f3a; font-size:0.7rem;">LAWYER</span>
                    <?php endif; ?>
                    Brocelle Law Firm
                </h5>
                <div>
                    <span class="me-3">Welcome, <strong><?= session()->get('username') ?></strong></span>
                    <a href="<?= base_url('admin/logout') ?>" class="btn btn-sm btn-outline-danger">Logout</a>
                </div>
            </div>

            <!-- Flash Messages handled by SweetAlert2 at bottom -->

            <!-- Page Content -->
            <div class="px-4 pt-3">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
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
