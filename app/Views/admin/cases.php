<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<?php $isLawyer = (session()->get('role') === 'lawyer'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0" style="color:#0b1f3a;">
        <i class="fa-solid fa-briefcase me-2" style="color:#c5a859;"></i>
        <?= $isLawyer ? 'My Assigned Cases' : 'Case Registry' ?>
    </h4>
    <span class="badge bg-secondary px-3 py-2"><?= count($cases) ?> case(s)</span>
</div>

<div class="row g-4">
    <!-- Left: Add Case Form (Admin Only) -->
    <?php if(!$isLawyer): ?>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold" style="color: #0b1f3a;">
                    <i class="fa-solid fa-folder-plus me-2" style="color: #c5a859;"></i>Create New Case
                </h5>
            </div>
            <div class="card-body">
                <?php if(empty($clients)): ?>
                    <div class="alert alert-warning py-2 mb-0 small">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Please <a href="<?= base_url('admin/clients') ?>">register a client</a> first to create a case.
                    </div>
                <?php else: ?>
                    <form action="<?= base_url('admin/addCase') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Assign Client</label>
                            <select name="client_id" class="form-select" required>
                                <option value="">Select client...</option>
                                <?php foreach($clients as $client): ?>
                                    <option value="<?= $client['id'] ?>"><?= esc($client['name']) ?> (<?= esc($client['email']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Assign Lawyer <span class="text-muted fw-normal">(optional)</span></label>
                            <select name="lawyer_id" class="form-select">
                                <option value="">— Unassigned —</option>
                                <?php foreach($lawyers as $lawyer): ?>
                                    <option value="<?= $lawyer['id'] ?>"><?= esc($lawyer['name']) ?> — <?= esc($lawyer['position']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Case Title</label>
                            <input type="text" name="case_title" class="form-control" placeholder="e.g. Property Dispute" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Case / Docket Number</label>
                            <input type="text" name="case_number" class="form-control" placeholder="e.g. CR-2026-8941" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Description / Notes</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Brief details about the case..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Next Hearing Date</label>
                            <input type="datetime-local" name="hearing_date" class="form-control">
                        </div>
                        <button type="submit" class="btn w-100 fw-bold" style="background-color: #c5a859; color: #0b1f3a;">
                            <i class="fa-solid fa-folder-plus me-2"></i>Create Case File
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Case Registry List -->
    <div class="<?= $isLawyer ? 'col-lg-12' : 'col-lg-8' ?>">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="color: #0b1f3a;">
                    <i class="fa-solid fa-briefcase me-2" style="color: #c5a859;"></i>
                    <?= $isLawyer ? 'My Assigned Case Files' : 'Legal Case Registry' ?>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Docket #</th>
                                <th>Case Title</th>
                                <th>Client</th>
                                <?php if(!$isLawyer): ?><th>Assigned Lawyer</th><?php endif; ?>
                                <th>Hearing Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($cases)): ?>
                                <tr>
                                    <td colspan="<?= $isLawyer ? 5 : 7 ?>" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                                        <?= $isLawyer ? 'No cases have been assigned to you yet.' : 'No active case files found.' ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($cases as $c): ?>
                                    <tr>
                                        <td><code class="text-dark fw-bold"><?= esc($c['case_number']) ?></code></td>
                                        <td><strong><?= esc($c['case_title']) ?></strong></td>
                                        <td>
                                            <?= esc($c['client_name']) ?><br>
                                            <small class="text-muted"><?= esc($c['client_email']) ?></small>
                                        </td>
                                        <?php if(!$isLawyer): ?>
                                        <td>
                                            <?php if(!empty($c['lawyer_name'])): ?>
                                                <span class="badge" style="background:#0b1f3a; color:#c5a859;">
                                                    <i class="fa-solid fa-user-tie me-1"></i><?= esc($c['lawyer_name']) ?>
                                                </span>
                                            <?php else: ?>
                                                <small class="text-muted fst-italic">Unassigned</small>
                                            <?php endif; ?>
                                        </td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if($c['hearing_date']): ?>
                                                <small class="text-danger fw-semibold"><?= date('d M Y', strtotime($c['hearing_date'])) ?></small><br>
                                                <small class="text-muted"><?= date('h:i A', strtotime($c['hearing_date'])) ?></small>
                                            <?php else: ?>
                                                <span class="text-muted small">Not Scheduled</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php $badgeClass = match($c['status']) { 'Active' => 'bg-primary', 'Won' => 'bg-success', 'Lost' => 'bg-danger', 'Closed' => 'bg-secondary', default => 'bg-info' }; ?>
                                            <span class="badge <?= $badgeClass ?>"><?= esc($c['status']) ?></span>
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
    </div>
</div>

<?= $this->endSection() ?>
