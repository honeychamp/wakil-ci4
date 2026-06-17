<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Hero Banner -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #0b1f3a 0%, #1a3a6b 100%);">
    <div class="container py-3">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('services') ?>" class="text-white-50 text-decoration-none">Practice Areas</a></li>
                <li class="breadcrumb-item active text-white"><?= esc($law['name']) ?></li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <!-- Icon + Title -->
                <div class="d-flex align-items-center gap-4 mb-3">
                    <div style="width:80px;height:80px;background:rgba(197,168,89,0.15);border:2px solid #c5a859;border-radius:20px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid <?= $law['icon'] ?> fa-2x" style="color:#c5a859;"></i>
                    </div>
                    <div>
                        <p class="mb-1 small text-uppercase fw-bold" style="color:#c5a859; letter-spacing:2px;">Practice Area</p>
                        <h1 class="fw-bold mb-0"><?= esc($law['name']) ?></h1>
                    </div>
                </div>
                <p class="text-white-50 lead"><?= esc($law['description']) ?></p>

                <!-- Key Quick Stats -->
                <div class="row g-3 mt-2">
                    <div class="col-auto">
                        <div class="px-3 py-2 rounded-3" style="background:rgba(255,255,255,0.08); border:1px solid rgba(197,168,89,0.3);">
                            <small class="text-white-50 d-block" style="font-size:0.7rem;">ESTIMATED FEES</small>
                            <span class="fw-semibold text-white small"><?= esc($law['details']['Expected Fees']) ?></span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="px-3 py-2 rounded-3" style="background:rgba(255,255,255,0.08); border:1px solid rgba(197,168,89,0.3);">
                            <small class="text-white-50 d-block" style="font-size:0.7rem;">TYPICAL TIMELINE</small>
                            <span class="fw-semibold text-white small"><?= esc($law['details']['Timeline']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content Row -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">

            <!-- LEFT COLUMN: Law Details -->
            <div class="col-lg-7">

                <!-- What We Handle -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header border-0 py-3 px-4" style="background:#0b1f3a;">
                        <h5 class="mb-0 text-white fw-bold">
                            <i class="fa-solid fa-list-check me-2" style="color:#c5a859;"></i>What We Handle
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-2">
                            <?php foreach ($law['details']['What We Handle'] as $item): ?>
                            <div class="col-12">
                                <div class="d-flex align-items-start gap-2">
                                    <i class="fa-solid fa-circle-check mt-1" style="color:#c5a859; font-size:0.9rem; flex-shrink:0;"></i>
                                    <span class="text-muted"><?= esc($item) ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Common Issues -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header border-0 py-3 px-4" style="background:#7b1f1f;">
                        <h5 class="mb-0 text-white fw-bold">
                            <i class="fa-solid fa-triangle-exclamation me-2" style="color:#ffcc55;"></i>Common Issues Clients Face
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <?php foreach ($law['details']['Common Issues'] as $i => $issue): ?>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background:#fff5f5; border-left:3px solid #c0392b;">
                                    <span class="text-muted small"><?= esc($issue) ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- What You Can Do -->
                <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid #c5a859 !important;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color:#0b1f3a;">
                            <i class="fa-solid fa-lightbulb me-2" style="color:#c5a859;"></i>What You Should Do Right Now
                        </h5>
                        <p class="text-muted mb-0"><?= esc($law['details']['What You Can Do']) ?></p>
                    </div>
                </div>

                <!-- Other Practice Areas -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color:#0b1f3a;">
                            <i class="fa-solid fa-th-large me-2" style="color:#c5a859;"></i>Other Practice Areas
                        </h6>
                        <a href="<?= base_url('services') ?>" class="btn btn-outline-dark btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i>View All 10 Practice Areas
                        </a>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Case Filing Form -->
            <div class="col-lg-5">
                <div class="sticky-top" style="top: 20px;">
                    <div class="card border-0 shadow" style="border-top: 4px solid #c5a859 !important; border-radius: 16px; overflow:hidden;">
                        <div class="card-header border-0 py-4 px-4" style="background: linear-gradient(135deg, #0b1f3a, #1a3a6b);">
                            <h5 class="text-white fw-bold mb-1">
                                <i class="fa-solid fa-file-pen me-2" style="color:#c5a859;"></i>File Your Case
                            </h5>
                            <p class="text-white-50 small mb-0">Fill the form below. An account will be created for you instantly.</p>
                        </div>
                        <div class="card-body p-4">
                            <form action="<?= base_url('services/submit-case') ?>" method="POST" id="caseForm">
                                <?= csrf_field() ?>
                                <!-- Hidden field: law_slug and law name -->
                                <input type="hidden" name="law_slug" value="<?= esc($law['slug']) ?>">

                                <!-- Personal Info -->
                                <h6 class="fw-bold text-uppercase mb-3 small" style="color:#0b1f3a; letter-spacing:1px;">
                                    <i class="fa-solid fa-user me-1" style="color:#c5a859;"></i>Your Information
                                </h6>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" class="form-control" placeholder="e.g. Ahmed Khan" required minlength="3">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="yourname@example.com" required>
                                    <div class="form-text">
                                        <i class="fa-solid fa-info-circle me-1 text-muted"></i>
                                        <small>Your portal login will be created at this email.</small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" placeholder="e.g. 03001234567" required minlength="7">
                                </div>

                                <hr class="my-3">

                                <!-- Case Details -->
                                <h6 class="fw-bold text-uppercase mb-3 small" style="color:#0b1f3a; letter-spacing:1px;">
                                    <i class="fa-solid fa-folder-open me-1" style="color:#c5a859;"></i>Your Case Details
                                </h6>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Case / Issue Title <span class="text-danger">*</span></label>
                                    <input type="text" name="issue_title" class="form-control" placeholder="e.g. Property dispute with neighbour" required minlength="5">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Describe Your Issue in Detail <span class="text-danger">*</span></label>
                                    <textarea name="issue_detail" class="form-control" rows="5"
                                              placeholder="Explain what happened, when it happened, who is involved, and any documents you have..."
                                              required minlength="20"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-semibold">Expected Outcome / What You Want</label>
                                    <textarea name="expected_outcome" class="form-control" rows="2"
                                              placeholder="e.g. I want my property back, I want compensation, I need guidance..."></textarea>
                                </div>

                                <!-- Submit -->
                                <button type="submit" id="submitCaseBtn" class="btn w-100 fw-bold py-3" style="background:#c5a859; color:#0b1f3a; border-radius:10px; font-size:1rem;">
                                    <i class="fa-solid fa-paper-plane me-2"></i>Submit My Case Request
                                </button>

                                <p class="text-center text-muted mt-3 small">
                                    <i class="fa-solid fa-lock me-1"></i>Your information is 100% private and secure.
                                </p>
                            </form>
                        </div>
                    </div>

                    <!-- Already have account -->
                    <div class="text-center mt-3">
                        <small class="text-muted">Already have an account?
                            <a href="<?= base_url('client') ?>" class="fw-bold" style="color:#c5a859;">Login to Client Portal →</a>
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Form Submit Loading State -->
<script>
document.getElementById('caseForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitCaseBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Filing Your Case...';
});
</script>

<?= $this->endSection() ?>
