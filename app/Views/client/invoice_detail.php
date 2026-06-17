<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?= esc($invoice['invoice_number']) ?> - Details</title>
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
        .invoice-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
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
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .invoice-card { box-shadow: none !important; border: none !important; }
        }
        /* Credit Card Flip */
        .card-scene { width: 100%; height: 200px; perspective: 800px; margin-bottom: 1.5rem; }
        .card-3d {
            width: 100%; height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.7s cubic-bezier(0.4,0.2,0.2,1);
            border-radius: 16px;
        }
        .card-3d.flipped { transform: rotateY(180deg); }
        .card-front, .card-back {
            position: absolute; inset: 0;
            backface-visibility: hidden;
            border-radius: 16px;
            padding: 20px 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }
        .card-front {
            background: linear-gradient(135deg, #0b1f3a 0%, #1a365d 50%, #0f2d52 100%);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .card-back {
            background: linear-gradient(135deg, #1a365d 0%, #0b1f3a 100%);
            transform: rotateY(180deg);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .card-chip { width: 42px; height: 32px; background: linear-gradient(135deg,#c5a859,#e8d080,#c5a859); border-radius: 5px; }
        .card-stripe { background: #333; height: 40px; width: 100%; margin: 12px 0; }
        .card-cvv-box { background: white; color: #333; padding: 4px 12px; border-radius: 4px; font-size: 0.9rem; letter-spacing: 4px; text-align: right; }
        .card-number-display { font-size: 1.05rem; letter-spacing: 3px; font-family: monospace; margin: 8px 0; }
        .card-label { font-size: 0.55rem; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; }
        .card-value { font-size: 0.85rem; }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark header-custom py-3 no-print">
        <div class="container">
            <a class="navbar-brand navbar-brand-portal" href="<?= base_url('client/dashboard') ?>">
                <i class="fa-solid fa-scale-balanced me-2"></i>Brocelle Client Portal
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="<?= base_url('client/invoices') ?>" class="btn btn-sm btn-outline-light px-3">&larr; Back to Invoices</a>
                <a href="<?= base_url('client/logout') ?>" class="btn btn-sm btn-outline-danger px-3">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="container py-5">
        
        <?php if(session()->getFlashdata('success')): ?>
            <!-- Handled by SweetAlert2 -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?= session()->getFlashdata('success') ?>',
                    confirmButtonColor: '#0b1f3a'
                });
            </script>
        <?php endif; ?>

        <!-- Invoice Form Grid -->
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <div class="card invoice-card bg-white p-5">
                    <!-- Invoice Header -->
                    <div class="row mb-5 border-bottom pb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h2 class="fw-bold" style="color: var(--primary-color); font-family: 'Playfair Display', serif;">
                                <i class="fa-solid fa-scale-balanced me-2" style="color: var(--secondary-color);"></i>Brocelle Law
                            </h2>
                            <p class="text-muted small mb-0">100 Legal Plaza, Suite 400</p>
                            <p class="text-muted small mb-0">New York, NY 10001</p>
                            <p class="text-muted small mb-0">billing@brocellelaw.com</p>
                            <p class="text-muted small">+1 (800) 123-4567</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h1 class="fw-bold text-uppercase text-muted h3 mb-2">Invoice Statement</h1>
                            <h4 class="fw-bold" style="color: var(--primary-color);"><?= esc($invoice['invoice_number']) ?></h4>
                            
                            <div class="mt-3">
                                <span class="text-muted small">Date Issued:</span>
                                <strong><?= date('M d, Y', strtotime($invoice['created_at'])) ?></strong><br>
                                <span class="text-muted small">Due Date:</span>
                                <strong class="<?= ($invoice['status'] !== 'Paid' && strtotime($invoice['due_date']) < time()) ? 'text-danger' : '' ?>">
                                    <?= date('M d, Y', strtotime($invoice['due_date'])) ?>
                                </strong>
                            </div>
                        </div>
                    </div>

                    <!-- Client / Case Info -->
                    <div class="row mb-5">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h6 class="text-uppercase text-muted fw-bold small mb-2">Billed To:</h6>
                            <h5 class="fw-bold mb-1" style="color: var(--primary-color);"><?= esc($invoice['client_name']) ?></h5>
                            <p class="text-muted small mb-0"><i class="fa-solid fa-envelope me-1"></i> <?= esc($invoice['client_email']) ?></p>
                            <p class="text-muted small"><i class="fa-solid fa-phone me-1"></i> <?= esc($invoice['client_phone']) ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="text-uppercase text-muted fw-bold small mb-2">Associated File:</h6>
                            <?php if($invoice['case_title']): ?>
                                <h5 class="fw-bold mb-1" style="color: var(--primary-color);"><?= esc($invoice['case_title']) ?></h5>
                                <p class="text-muted small mb-0">Docket Number: <strong><?= esc($invoice['case_number']) ?></strong></p>
                            <?php else: ?>
                                <p class="text-muted small mb-0">General Legal Counsel / Consultation</p>
                            <?php endif; ?>
                            
                            <div class="mt-3">
                                <span class="text-muted small">Payment Status:</span>
                                <?php if($invoice['status'] === 'Paid'): ?>
                                    <span class="badge bg-success px-3 py-1">PAID</span>
                                <?php elseif($invoice['status'] === 'Overdue'): ?>
                                    <span class="badge bg-danger px-3 py-1">OVERDUE</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark px-3 py-1">UNPAID</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Items / Fee Details Table -->
                    <h6 class="text-uppercase text-muted fw-bold small mb-3">Line Item Details:</h6>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light text-uppercase small">
                                <tr>
                                    <th class="ps-3">Description / Legal Services Rendered</th>
                                    <th class="text-center" style="width: 150px;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-3 py-4">
                                        <p class="mb-0 fw-bold"><?= esc($invoice['case_title'] ?: 'General Retainer & Advisory Consultation') ?></p>
                                        <p class="text-muted small mb-0 mt-1"><?= nl2br(esc($invoice['description'])) ?></p>
                                    </td>
                                    <td class="text-center py-4 fw-bold text-dark">$<?= number_format($invoice['amount'], 2) ?></td>
                                </tr>
                                <tr class="table-light">
                                    <td class="text-end fw-bold ps-3">Total Amount Due:</td>
                                    <td class="text-center fw-bold text-primary h5 m-0 py-3">$<?= number_format($invoice['amount'], 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Notes / Footer -->
                    <div class="mb-4">
                        <h6 class="fw-bold small text-uppercase text-muted mb-2">Legal Terms &amp; Conditions</h6>
                        <p class="text-muted small mb-0">Payments are due within 30 days from the invoice issuance date. For bank transfers or check payments, please contact our administrative coordinator at billing@brocellelaw.com.</p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5 border-top pt-4 no-print">
                        <button class="btn btn-outline-dark fw-semibold" onclick="window.print()">
                            <i class="fa-solid fa-print me-2"></i> Print Invoice
                        </button>

                        <?php if($invoice['status'] !== 'Paid'): ?>
                            <!-- Trigger Payment Modal -->
                            <button type="button" class="btn btn-gold btn-lg px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                <i class="fa-regular fa-credit-card me-2"></i> Pay Securely Online
                            </button>
                        <?php else: ?>
                            <span class="text-success fw-bold"><i class="fa-solid fa-circle-check me-2"></i> Paid Statement Receipt</span>
                        <?php endif; ?>
                    </div>

                </div>
                
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php if($invoice['status'] !== 'Paid'): ?>
<!-- =================== Payment Modal =================== -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px; overflow:hidden;">

            <!-- Modal Header -->
            <div class="modal-header py-3" style="background:#0b1f3a; border:none;">
                <h5 class="modal-title text-white fw-bold" id="paymentModalLabel">
                    <i class="fa-solid fa-lock me-2" style="color:#c5a859;"></i> Secure Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">

                <!-- 3D Credit Card Preview -->
                <div class="card-scene">
                    <div class="card-3d" id="creditCard3d">
                        <!-- Front -->
                        <div class="card-front">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="card-chip"></div>
                                <i class="fa-brands fa-cc-visa fa-2x" style="color:#c5a859;"></i>
                            </div>
                            <div>
                                <div class="card-number-display" id="cardNumberDisplay">•••• •••• •••• ••••</div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div>
                                        <div class="card-label">Card Holder</div>
                                        <div class="card-value" id="cardHolderDisplay">FULL NAME</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="card-label">Expires</div>
                                        <div class="card-value" id="cardExpiryDisplay">MM / YY</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Back -->
                        <div class="card-back">
                            <div class="card-stripe"></div>
                            <div class="px-2">
                                <div class="card-label mb-1">CVV</div>
                                <div class="card-cvv-box" id="cardCvvDisplay">•••</div>
                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>

                <!-- Amount Summary -->
                <div class="alert py-2 px-3 mb-3" style="background:#f8f9fa; border-left:4px solid #c5a859;">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Invoice: <strong><?= esc($invoice['invoice_number']) ?></strong></small>
                        <strong style="color:#0b1f3a; font-size:1.1rem;">$<?= number_format($invoice['amount'], 2) ?></strong>
                    </div>
                </div>

                <!-- Payment Form -->
                <form id="paymentForm" action="<?= base_url('client/invoice/pay/' . $invoice['id']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Card Number</label>
                        <input type="text" id="cardNumber" class="form-control" placeholder="1234 5678 9012 3456"
                               maxlength="19" oninput="formatCard(this)" required autocomplete="cc-number">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Card Holder Name</label>
                        <input type="text" id="cardHolder" class="form-control" placeholder="Name as on card"
                               oninput="document.getElementById('cardHolderDisplay').textContent = this.value.toUpperCase() || 'FULL NAME'" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-7">
                            <label class="form-label fw-semibold small">Expiry Date</label>
                            <input type="text" id="cardExpiry" class="form-control" placeholder="MM / YY"
                                   maxlength="7" oninput="formatExpiry(this)" required autocomplete="cc-exp">
                        </div>
                        <div class="col-5">
                            <label class="form-label fw-semibold small">CVV</label>
                            <input type="text" id="cardCvv" class="form-control" placeholder="•••"
                                   maxlength="4"
                                   onfocus="document.getElementById('creditCard3d').classList.add('flipped')"
                                   onblur="document.getElementById('creditCard3d').classList.remove('flipped')"
                                   oninput="document.getElementById('cardCvvDisplay').textContent = this.value || '•••'" required autocomplete="cc-csc">
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-2 mb-3">
                        <i class="fa-solid fa-lock text-success small"></i>
                        <small class="text-muted">256-bit SSL encrypted. Your card details are not stored.</small>
                    </div>

                </form>
            </div>

            <div class="modal-footer" style="border:none; background:#f8f9fa;">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-gold px-4 fw-bold" onclick="submitPayment()">
                    <i class="fa-solid fa-shield-halved me-2"></i>
                    Pay $<?= number_format($invoice['amount'], 2) ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function formatCard(el) {
    let v = el.value.replace(/\D/g,'').substring(0,16);
    el.value = v.match(/.{1,4}/g)?.join(' ') || v;
    document.getElementById('cardNumberDisplay').textContent = v.padEnd(16,'•').replace(/(.{4})/g,'$1 ').trim();
}
function formatExpiry(el) {
    let v = el.value.replace(/\D/g,'');
    if(v.length >= 2) v = v.substring(0,2) + ' / ' + v.substring(2,4);
    el.value = v;
    document.getElementById('cardExpiryDisplay').textContent = el.value || 'MM / YY';
}
function submitPayment() {
    const num  = document.getElementById('cardNumber').value.replace(/\s/g,'');
    const name = document.getElementById('cardHolder').value.trim();
    const exp  = document.getElementById('cardExpiry').value.trim();
    const cvv  = document.getElementById('cardCvv').value.trim();
    if(num.length < 16 || !name || exp.length < 7 || cvv.length < 3) {
        alert('Please fill in all card details correctly.');
        return;
    }
    const btn = document.querySelector('#paymentModal .btn-gold[onclick]');
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
    btn.disabled = true;
    setTimeout(() => document.getElementById('paymentForm').submit(), 1500);
}
</script>
<?php endif; ?>

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
        });
    </script>
</body>
</html>
