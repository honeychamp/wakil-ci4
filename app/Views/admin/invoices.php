<?php $this->extend('admin/layout'); ?>
<?php $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-file-invoice-dollar me-2 text-warning"></i> Invoices &amp; Billing</h4>
    <?php if (session()->get('role') !== 'lawyer'): ?>
    <button class="btn btn-warning fw-semibold" data-bs-toggle="modal" data-bs-target="#addInvoiceModal">
        <i class="fa-solid fa-file-invoice me-1"></i> Generate Invoice
    </button>
    <?php else: ?>
    <span class="badge bg-secondary fs-6"><i class="fa-solid fa-eye me-1"></i> View Only</span>
    <?php endif; ?>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Invoice Statistics Overview Cards -->
<div class="row g-3 mb-4">
    <?php
    $totalBilled = 0;
    $totalPaid = 0;
    $totalUnpaid = 0;
    foreach ($invoices as $inv) {
        $totalBilled += $inv['amount'];
        if ($inv['status'] === 'Paid') {
            $totalPaid += $inv['amount'];
        } else {
            $totalUnpaid += $inv['amount'];
        }
    }
    ?>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white p-3">
            <small class="text-white-50">Total Billed</small>
            <h3 class="fw-bold m-0">$<?= number_format($totalBilled, 2) ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white p-3">
            <small class="text-white-50">Total Paid (Revenue)</small>
            <h3 class="fw-bold m-0">$<?= number_format($totalPaid, 2) ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-danger text-white p-3">
            <small class="text-white-50">Outstanding Receivables</small>
            <h3 class="fw-bold m-0">$<?= number_format($totalUnpaid, 2) ?></h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($invoices)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-file-invoice-dollar fa-3x mb-3 d-block"></i>
                <p class="mb-0">No invoices have been generated yet.</p>
            </div>
        <?php else: ?>
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Invoice No.</th>
                    <th>Client</th>
                    <th>Associated Case</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <?php if (session()->get('role') !== 'lawyer'): ?>
                    <th class="text-center">Change Status</th>
                    <th class="text-center">Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $inv): ?>
                <tr>
                    <td>
                        <strong><?= esc($inv['invoice_number']) ?></strong><br>
                        <small class="text-muted"><?= date('M d, Y', strtotime($inv['created_at'])) ?></small>
                    </td>
                    <td><?= esc($inv['client_name']) ?></td>
                    <td>
                        <?php if ($inv['case_title']): ?>
                            <span class="small text-dark fw-bold"><?= esc($inv['case_title']) ?></span><br>
                            <small class="text-muted">Docket: <?= esc($inv['case_number']) ?></small>
                        <?php else: ?>
                            <span class="text-muted small">None</span>
                        <?php endif; ?>
                    </td>
                    <td><strong>$<?= number_format($inv['amount'], 2) ?></strong></td>
                    <td>
                        <span class="<?= ($inv['status'] !== 'Paid' && strtotime($inv['due_date']) < time()) ? 'text-danger fw-bold' : '' ?>">
                            <?= date('M d, Y', strtotime($inv['due_date'])) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($inv['status'] === 'Paid'): ?>
                            <span class="badge bg-success">Paid</span>
                        <?php elseif ($inv['status'] === 'Overdue'): ?>
                            <span class="badge bg-danger">Overdue</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Unpaid</span>
                        <?php endif; ?>
                    </td>
                    <?php if (session()->get('role') !== 'lawyer'): ?>
                    <td class="text-center">
                        <form action="<?= base_url('admin/invoices/updateStatus') ?>" method="POST" class="d-inline-flex gap-1 align-items-center">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $inv['id'] ?>">
                            <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                <option value="Unpaid" <?= $inv['status'] === 'Unpaid' ? 'selected' : '' ?>>Unpaid</option>
                                <option value="Paid" <?= $inv['status'] === 'Paid' ? 'selected' : '' ?>>Paid</option>
                                <option value="Overdue" <?= $inv['status'] === 'Overdue' ? 'selected' : '' ?>>Overdue</option>
                            </select>
                        </form>
                    </td>
                    <td class="text-center">
                        <a href="<?= base_url('admin/invoices/delete/' . $inv['id']) ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Are you sure you want to delete this invoice?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<!-- Add Invoice Modal -->
<div class="modal fade" id="addInvoiceModal" tabindex="-1" aria-labelledby="addInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form action="<?= base_url('admin/invoices/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold" id="addInvoiceModalLabel"><i class="fa-solid fa-file-invoice me-2"></i> Generate Invoice</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Client <span class="text-danger">*</span></label>
                        <select name="client_id" class="form-select" required>
                            <option value="">Choose Client...</option>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client['id'] ?>"><?= esc($client['name']) ?> (<?= esc($client['email']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Associated Case (Optional)</label>
                        <select name="case_id" class="form-select">
                            <option value="">None / Consultations</option>
                            <?php foreach ($cases as $case): ?>
                                <option value="<?= $case['id'] ?>"><?= esc($case['case_title']) ?> (Docket: <?= esc($case['case_number']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Amount ($) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" step="0.01" min="0" class="form-control" placeholder="0.00" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Due Date <span class="text-danger">*</span></label>
                            <input type="date" name="due_date" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Invoice Number (Optional)</label>
                        <input type="text" name="invoice_number" class="form-control" placeholder="Auto-generated if left blank">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Invoice Status</label>
                        <select name="status" class="form-select">
                            <option value="Unpaid">Unpaid</option>
                            <option value="Paid">Paid</option>
                            <option value="Overdue">Overdue</option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">Billing Description / Legal Memo <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Description of billing items..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning fw-bold">Generate &amp; Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
