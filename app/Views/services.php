<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<section class="py-5 text-center" style="background: linear-gradient(135deg, #0b1f3a 0%, #1a3a6b 100%);">
    <div class="container py-4">
        <p class="text-uppercase small fw-bold mb-2" style="color:#c5a859; letter-spacing:3px;">Expert Legal Representation</p>
        <h1 class="fw-bold mb-3 text-white">Our Practice Areas</h1>
        <div class="mx-auto mb-4" style="width: 60px; height: 3px; background-color: #c5a859;"></div>
        <p class="text-white-50 lead mx-auto" style="max-width:600px;">
            10 specialized legal disciplines, each handled by dedicated expert attorneys committed to your success.
        </p>
    </div>
</section>

<!-- 10 Laws Grid -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($laws as $slug => $law): ?>
            <div class="col-md-6 col-lg-4">
                <a href="<?= base_url('services/' . $law['slug']) ?>" class="text-decoration-none law-card-link">
                    <div class="card border-0 shadow-sm h-100 law-card">
                        <div class="card-body p-4 d-flex flex-column">
                            <!-- Icon Circle -->
                            <div class="law-icon-wrap mb-3">
                                <i class="fa-solid <?= $law['icon'] ?> fa-2x" style="color:#c5a859;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color:#0b1f3a;"><?= esc($law['name']) ?></h5>
                            <p class="text-muted small mb-3 flex-grow-1"><?= esc($law['description']) ?></p>
                            <div class="d-flex align-items-center mt-auto" style="color:#c5a859; font-size:0.85rem; font-weight:600;">
                                Learn More & File a Case
                                <i class="fa-solid fa-arrow-right ms-2"></i>
                            </div>
                        </div>
                        <div class="card-footer border-0 py-2 px-4" style="background:<?= $law['color'] ?>11;">
                            <small class="fw-semibold" style="color:<?= $law['color'] ?>;">
                                <i class="fa-solid fa-tag me-1"></i><?= esc($law['tagline']) ?>
                            </small>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- CTA -->
        <div class="text-center mt-5 p-5 rounded-4" style="background: linear-gradient(135deg, #0b1f3a, #1a3a6b);">
            <h3 class="text-white fw-bold mb-2">Not sure which practice area fits your case?</h3>
            <p class="text-white-50 mb-4">Contact our team and we'll connect you with the right specialist attorney.</p>
            <a href="<?= base_url('contact') ?>" class="btn btn-lg px-5 fw-bold" style="background:#c5a859; color:#0b1f3a;">
                <i class="fa-solid fa-phone me-2"></i>Free Consultation
            </a>
        </div>
    </div>
</section>

<style>
.law-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px !important;
    overflow: hidden;
}
.law-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.12) !important;
}
.law-icon-wrap {
    width: 60px;
    height: 60px;
    background: #0b1f3a10;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.law-card-link .law-card .d-flex {
    transition: gap 0.3s;
}
.law-card-link:hover .law-card .d-flex i {
    transform: translateX(4px);
    transition: transform 0.3s ease;
}
</style>

<?= $this->endSection() ?>
