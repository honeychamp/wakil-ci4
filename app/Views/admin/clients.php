<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<!-- Notification Messages -->
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i><?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- Left: Client Registration Form -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold" style="color: #0b1f3a;">
                    <i class="fa-solid fa-user-plus me-2" style="color: #c5a859;"></i>Add New Client
                </h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/addClient') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="e.g. john@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" placeholder="e.g. (123) 456-7890">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Portal Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Set password for portal" required>
                    </div>
                    <button type="submit" class="btn w-100 fw-bold" style="background-color: var(--secondary-color, #c5a859); color: #0b1f3a;">
                        Register Client
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right: Client List -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="color: #0b1f3a;">
                    <i class="fa-solid fa-users me-2" style="color: #c5a859;"></i>Registered Clients
                </h5>
                <span class="badge bg-secondary"><?= count($clients) ?> total</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($clients)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-user-slash fa-2x mb-2 d-block"></i>
                                        No registered clients found. Use the registration form to add clients.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $i = 1; foreach($clients as $client): ?>
                                    <tr>
                                        <td class="text-muted"><?= $i++ ?></td>
                                        <td><strong><?= esc($client['name']) ?></strong></td>
                                        <td><a href="mailto:<?= esc($client['email']) ?>"><?= esc($client['email']) ?></a></td>
                                        <td><?= esc($client['phone'] ?: 'N/A') ?></td>
                                        <td><small class="text-muted"><?= date('d M Y', strtotime($client['created_at'])) ?></small></td>
                                        <td>
                                            <!-- Reset Password Button -->
                                            <button class="btn btn-sm btn-outline-warning me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#resetPwdModal"
                                                data-client-id="<?= $client['id'] ?>"
                                                data-client-name="<?= esc($client['name']) ?>"
                                                title="Reset Password">
                                                <i class="fa-solid fa-key"></i>
                                            </button>
                                            <!-- Delete Button -->
                                            <a href="<?= base_url('admin/deleteClient/' . $client['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this client? This will delete all their cases and files.')"
                                               title="Delete Client">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!-- Reset Client Password Modal -->
<div class="modal fade" id="resetPwdModal" tabindex="-1" aria-labelledby="resetPwdLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content border-0 shadow">
            <form action="<?= base_url('admin/resetClientPassword') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="client_id" id="resetClientId">
                <div class="modal-header" style="background:#0b1f3a;">
                    <h6 class="modal-title text-white fw-bold" id="resetPwdLabel">
                        <i class="fa-solid fa-key me-2" style="color:#c5a859;"></i>
                        Reset Password
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">
                        Resetting password for: <strong id="resetClientName" class="text-dark"></strong>
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">New Password <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" id="newPwdInput" class="form-control" placeholder="Min. 6 characters" minlength="6" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Repeat new password" minlength="6" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold">
                        <i class="fa-solid fa-rotate me-1"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Populate modal with client data when opened
    document.getElementById('resetPwdModal').addEventListener('show.bs.modal', function(e) {
        const btn = e.relatedTarget;
        document.getElementById('resetClientId').value   = btn.getAttribute('data-client-id');
        document.getElementById('resetClientName').textContent = btn.getAttribute('data-client-name');
        document.getElementById('newPwdInput').value = '';
    });
</script>
