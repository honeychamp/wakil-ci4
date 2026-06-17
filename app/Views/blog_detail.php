<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Blog Post Header -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #0b1f3a 0%, #1a365d 100%);">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <?php if ($blog['category']): ?>
                    <span class="badge mb-3 px-3 py-2" style="background-color:#c5a859;color:#0b1f3a;font-size:0.85rem;">
                        <?= esc($blog['category']) ?>
                    </span>
                <?php endif; ?>
                <h1 class="fw-bold mb-3" style="font-size:2.2rem; line-height:1.3;">
                    <?= esc($blog['title']) ?>
                </h1>
                <div class="text-white-50 small">
                    <i class="fa-solid fa-user me-1"></i> <?= esc($blog['author']) ?>
                    &nbsp;&bull;&nbsp;
                    <i class="fa-regular fa-calendar me-1"></i> <?= date('F d, Y', strtotime($blog['created_at'])) ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="py-5">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Cover Image -->
                <?php if ($blog['image']): ?>
                    <img src="<?= base_url($blog['image']) ?>" class="img-fluid rounded-3 shadow mb-5 w-100"
                         alt="<?= esc($blog['title']) ?>" style="max-height:450px; object-fit:cover;">
                <?php endif; ?>

                <!-- Article Body -->
                <article class="blog-content" style="font-size:1.05rem; line-height:1.85; color:#333;">
                    <?= nl2br(esc($blog['content'])) ?>
                </article>

                <hr class="my-5">

                <!-- Back Link -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="<?= base_url('blog') ?>" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i> Back to Blog
                    </a>
                    <a href="<?= base_url('contact') ?>" class="btn" style="background-color:#c5a859;color:#0b1f3a;font-weight:600;">
                        <i class="fa-solid fa-phone me-2"></i> Get Legal Advice
                    </a>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="col-lg-3 offset-lg-1 mt-5 mt-lg-0">
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h6 class="fw-bold mb-3" style="color:#0b1f3a; border-bottom:2px solid #c5a859; padding-bottom:8px;">
                        Need Legal Help?
                    </h6>
                    <p class="text-muted small">Our experienced attorneys are ready to assist you. Schedule a free consultation today.</p>
                    <a href="<?= base_url('contact') ?>" class="btn btn-sm w-100 fw-semibold" style="background-color:#c5a859;color:#0b1f3a;">
                        Contact Us
                    </a>
                </div>

                <div class="card border-0 shadow-sm p-4">
                    <h6 class="fw-bold mb-3" style="color:#0b1f3a; border-bottom:2px solid #c5a859; padding-bottom:8px;">
                        Practice Areas
                    </h6>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2"><i class="fa-solid fa-chevron-right me-2" style="color:#c5a859;"></i>Corporate Law</li>
                        <li class="mb-2"><i class="fa-solid fa-chevron-right me-2" style="color:#c5a859;"></i>Family Law</li>
                        <li class="mb-2"><i class="fa-solid fa-chevron-right me-2" style="color:#c5a859;"></i>Criminal Defense</li>
                        <li class="mb-2"><i class="fa-solid fa-chevron-right me-2" style="color:#c5a859;"></i>Real Estate Law</li>
                        <li class="mb-2"><i class="fa-solid fa-chevron-right me-2" style="color:#c5a859;"></i>Employment Law</li>
                        <li><i class="fa-solid fa-chevron-right me-2" style="color:#c5a859;"></i>Immigration Law</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
