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

<!-- Case Header Info -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <div>
            <span class="text-uppercase fw-bold text-muted small">Case File details</span>
            <h3 class="fw-bold mb-1" style="color: #0b1f3a;"><?= esc($case['case_title']) ?></h3>
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
    <!-- Left Column: Case Details & Status Update -->
    <div class="col-lg-4">
        <!-- Client Details -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold" style="color: #0b1f3a;"><i class="fa-solid fa-user me-2" style="color: #c5a859;"></i>Client Profile</h6>
            </div>
            <div class="card-body">
                <h5 class="fw-bold mb-1"><?= esc($case['client_name']) ?></h5>
                <p class="text-muted small mb-3">Associated Case Client</p>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><i class="fa-solid fa-envelope me-2 text-muted"></i> <a href="mailto:<?= esc($case['client_email']) ?>"><?= esc($case['client_email']) ?></a></li>
                    <li class="mb-0"><i class="fa-solid fa-phone me-2 text-muted"></i> <?= esc($case['client_phone'] ?: 'N/A') ?></li>
                </ul>
            </div>
        </div>

        <!-- Case Description & Dates -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold" style="color: #0b1f3a;"><i class="fa-solid fa-circle-info me-2" style="color: #c5a859;"></i>Case Details</h6>
            </div>
            <div class="card-body">
                <p class="fw-bold small mb-1 text-muted">Description</p>
                <p class="text-muted small mb-4"><?= nl2br(esc($case['description'] ?: 'No description provided.')) ?></p>

                <p class="fw-bold small mb-1 text-muted">Next Hearing Date</p>
                <p class="mb-4">
                    <i class="fa-solid fa-calendar-days me-2 text-muted"></i>
                    <?php if($case['hearing_date']): ?>
                        <strong><?= date('d M Y, h:i A', strtotime($case['hearing_date'])) ?></strong>
                    <?php else: ?>
                        <span class="text-muted">Not scheduled yet.</span>
                    <?php endif; ?>
                </p>

                <!-- Status Update Form -->
                <form action="<?= base_url('admin/updateCaseStatus') ?>" method="POST" class="border-top pt-3">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $case['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Change Case Status</label>
                        <select name="status" class="form-select">
                            <option value="Active" <?= $case['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                            <option value="Won"    <?= $case['status'] === 'Won'    ? 'selected' : '' ?>>Won (Success)</option>
                            <option value="Lost"   <?= $case['status'] === 'Lost'   ? 'selected' : '' ?>>Lost</option>
                            <option value="Closed" <?= $case['status'] === 'Closed' ? 'selected' : '' ?>>Closed / Archived</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm w-100 fw-bold" style="background-color: #0b1f3a; color: #c5a859;">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Documents Vault & Client Chat -->
    <div class="col-lg-8">
        <!-- Document Vault -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold" style="color: #0b1f3a;">
                    <i class="fa-solid fa-box-archive me-2" style="color: #c5a859;"></i>Document Vault (File Sharing)
                </h6>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#uploadCollapse">
                    <i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload File
                </button>
            </div>
            <div class="card-body">
                <!-- Collapsible upload form -->
                <div class="collapse mb-3" id="uploadCollapse">
                    <form action="<?= base_url('admin/uploadCaseDocument') ?>" method="POST" enctype="multipart/form-data" class="p-3 bg-light rounded border">
                        <?= csrf_field() ?>
                        <input type="hidden" name="case_id" value="<?= $case['id'] ?>">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label small fw-bold mb-1">Select Document</label>
                                <input type="file" name="file" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small fw-bold mb-1">Brief Description</label>
                                <input type="text" name="description" class="form-control form-control-sm" placeholder="e.g. Court Petition Proof" required>
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
                        <i class="fa-regular fa-folder-open fa-2x mb-2 d-block"></i> No documents uploaded yet.
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach($documents as $doc): ?>
                            <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 text-danger me-3"><i class="fa-solid fa-file-pdf"></i></div>
                                    <div>
                                        <h6 class="mb-0 fw-bold small"><?= esc($doc['file_name']) ?></h6>
                                        <p class="mb-0 text-muted small"><?= esc($doc['description']) ?></p>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            Uploaded by: <span class="badge bg-secondary"><?= esc($doc['uploaded_by']) ?></span> | <?= date('d M Y h:i A', strtotime($doc['created_at'])) ?>
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

        <!-- Secure Chat -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold" style="color: #0b1f3a;">
                    <i class="fa-solid fa-comments me-2" style="color: #c5a859;"></i>Secure Client Communication
                </h6>
            </div>
            <div class="card-body bg-light" style="max-height: 350px; overflow-y: auto;">
                <?php if(empty($messages)): ?>
                    <div class="text-center py-5 text-muted small">
                        <i class="fa-regular fa-comments fa-2x mb-2 d-block"></i> No messages posted yet. Start the conversation with your client below.
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php
                            $currentRole = session()->get('role');
                            foreach($messages as $msg):
                            // Firm side = admin or lawyer messages (right); client = left
                            $isFirmSide = in_array($msg['sender_role'], ['admin', 'lawyer']);
                            $isCurrentUser = ($msg['sender_role'] === $currentRole);
                            $senderLabel = $isFirmSide
                                ? ($isCurrentUser ? 'You' : ucfirst($msg['sender_role']))
                                : 'Client';
                        ?>
                            <div class="d-flex flex-column <?= $isFirmSide ? 'align-items-end' : 'align-items-start' ?>">
                                <div class="p-3 rounded shadow-sm text-white" style="max-width: 75%; font-size: 0.9rem; background-color: <?= $isFirmSide ? '#0b1f3a' : '#c5a859' ?>; border-radius: 12px !important;">
                                    <?= nl2br(esc($msg['message'])) ?>
                                </div>
                                <small class="text-muted mt-1 px-2" style="font-size: 0.7rem;">
                                    <?= $senderLabel ?> | <?= date('d M h:i A', strtotime($msg['created_at'])) ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Message Input Area -->
            <div class="card-footer bg-white border-0 py-3">
                <form action="<?= base_url('admin/sendCaseMessage') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="case_id" value="<?= $case['id'] ?>">
                    <div class="input-group">
                        <textarea name="message" class="form-control" rows="1" placeholder="Type a secure message to client..." required></textarea>
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
