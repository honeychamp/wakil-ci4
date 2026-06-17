<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php $role = session()->get('role'); ?>

<!-- ===================== LAWYER DASHBOARD ===================== -->
<?php if($role === 'lawyer'): ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color:#0b1f3a;">
            <i class="fa-solid fa-briefcase me-2" style="color:#c5a859;"></i> My Cases
        </h4>
        <p class="text-muted small mb-0">Cases assigned to you — <?= session()->get('username') ?></p>
    </div>
</div>

<!-- Lawyer Stats -->
<div class="row mb-4 g-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center">
            <div class="me-3 fs-1" style="color:#c5a859;"><i class="fa-solid fa-briefcase"></i></div>
            <div>
                <h3 class="mb-0 fw-bold"><?= $total_cases ?></h3>
                <p class="text-muted mb-0 small">Total Assigned Cases</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center">
            <div class="me-3 fs-1" style="color:#198754;"><i class="fa-solid fa-circle-check"></i></div>
            <div>
                <h3 class="mb-0 fw-bold"><?= $active_cases ?></h3>
                <p class="text-muted mb-0 small">Active Cases</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center">
            <div class="me-3 fs-1" style="color:#dc3545;"><i class="fa-solid fa-hourglass-half"></i></div>
            <div>
                <h3 class="mb-0 fw-bold"><?= $total_cases - $active_cases ?></h3>
                <p class="text-muted mb-0 small">Closed / Resolved</p>
            </div>
        </div>
    </div>
</div>

<!-- Lawyer's Cases Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold" style="color:#0b1f3a;">
            <i class="fa-solid fa-folder-open me-2" style="color:#c5a859;"></i> My Assigned Case Files
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Case</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Hearing Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($cases)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                                No cases have been assigned to you yet.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach($cases as $c): ?>
                        <tr>
                            <td class="text-muted"><?= $i++ ?></td>
                            <td>
                                <strong><?= esc($c['case_title']) ?></strong><br>
                                <small class="text-muted"><?= esc($c['case_number']) ?></small>
                            </td>
                            <td><?= esc($c['client_name']) ?></td>
                            <td>
                                <?php $sc = match($c['status']) { 'Active' => 'success', 'Closed' => 'secondary', 'Pending' => 'warning', default => 'info' }; ?>
                                <span class="badge bg-<?= $sc ?>"><?= esc($c['status']) ?></span>
                            </td>
                            <td>
                                <?= $c['hearing_date'] ? '<span class="text-danger fw-semibold">'.date('d M Y', strtotime($c['hearing_date'])).'</span>' : '<small class="text-muted">—</small>' ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/case/' . $c['id']) ?>" class="btn btn-sm" style="background:#0b1f3a; color:#c5a859; font-size:0.75rem;">
                                    <i class="fa-solid fa-eye me-1"></i> View
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

<?php else: ?>
<!-- ===================== ADMIN DASHBOARD ===================== -->

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0" style="color:#0b1f3a;">
        <i class="fa-solid fa-gauge me-2" style="color:#c5a859;"></i> Overview
    </h4>
    <a href="<?= base_url('admin/notifications') ?>" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-bell me-1"></i> Notifications
    </a>
</div>

<!-- Admin Stats -->
<div class="row mb-4 g-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center">
            <div class="me-3 fs-1" style="color:#c5a859;"><i class="fa-solid fa-inbox"></i></div>
            <div>
                <h3 class="mb-0 fw-bold"><?= $total_leads ?></h3>
                <p class="text-muted mb-0 small">Total Inquiries</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center">
            <div class="me-3 fs-1" style="color:#0b1f3a;"><i class="fa-solid fa-users"></i></div>
            <div>
                <h3 class="mb-0 fw-bold"><?= $total_clients ?></h3>
                <p class="text-muted mb-0 small">Total Clients</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center">
            <div class="me-3 fs-1" style="color:#198754;"><i class="fa-solid fa-briefcase"></i></div>
            <div>
                <h3 class="mb-0 fw-bold"><?= $total_cases ?></h3>
                <p class="text-muted mb-0 small">Total Cases</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center">
            <div class="me-3 fs-1" style="color:#dc3545;"><i class="fa-solid fa-gavel"></i></div>
            <div>
                <h3 class="mb-0 fw-bold"><?= $active_cases ?></h3>
                <p class="text-muted mb-0 small">Active Cases</p>
            </div>
        </div>
    </div>
</div>

<!-- Leads Table -->
<div class="card border-0 shadow-sm mb-5">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold" style="color: #0b1f3a;">
            <i class="fa-solid fa-users me-2" style="color: #c5a859;"></i>Website Inquiries / Leads
        </h5>
        <span class="badge bg-secondary"><?= count($leads) ?> total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Practice Area</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($leads)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>
                                No inquiries found yet. When someone fills the contact form, they will appear here.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach($leads as $lead): ?>
                            <tr>
                                <td class="text-muted"><?= $i++ ?></td>
                                <td>
                                    <small><?= date('d M Y', strtotime($lead['created_at'])) ?></small><br>
                                    <small class="text-muted"><?= date('h:i A', strtotime($lead['created_at'])) ?></small>
                                </td>
                                <td><strong><?= esc($lead['full_name']) ?></strong></td>
                                <td><a href="tel:<?= esc($lead['phone']) ?>"><?= esc($lead['phone']) ?></a></td>
                                <td><span class="badge" style="background-color:#c5a859; color:#0b1f3a;"><?= esc($lead['practice_area']) ?></span></td>
                                <td style="max-width: 200px;"><small class="text-muted"><?= esc($lead['description']) ?></small></td>
                                <td>
                                    <?php $statusClass = match($lead['status']) { 'New' => 'bg-danger', 'Contacted' => 'bg-warning text-dark', 'Closed' => 'bg-success', default => 'bg-secondary' }; ?>
                                    <span class="badge <?= $statusClass ?>"><?= esc($lead['status']) ?></span>
                                </td>
                                <td>
                                    <form action="<?= base_url('admin/updateLeadStatus') ?>" method="POST" class="d-inline-flex gap-1">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= $lead['id'] ?>">
                                        <select name="status" class="form-select form-select-sm" style="width: auto; min-width: 110px;">
                                            <option value="New"       <?= $lead['status'] === 'New'       ? 'selected' : '' ?>>New</option>
                                            <option value="Contacted" <?= $lead['status'] === 'Contacted' ? 'selected' : '' ?>>Contacted</option>
                                            <option value="Closed"    <?= $lead['status'] === 'Closed'    ? 'selected' : '' ?>>Closed</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary" title="Save Status">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                        </button>
                                    </form>
                                    <a href="<?= base_url('admin/deleteLead/' . $lead['id']) ?>"
                                       class="btn btn-sm btn-outline-danger ms-1"
                                       title="Delete Lead"
                                       onclick="return confirm('Are you sure you want to delete this lead?')">
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

<?php endif; ?>

<?= $this->endSection() ?>
