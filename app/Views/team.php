<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<section class="py-5 bg-light text-center">
    <div class="container py-4">
        <h1 class="fw-bold" style="color: var(--primary-color);">Our Legal Team</h1>
        <div class="mx-auto mt-2 mb-3" style="width: 50px; height: 3px; background-color: var(--secondary-color);"></div>
        <p class="text-muted lead">Meet the dedicated professionals fighting for your rights.</p>
    </div>
</section>

<!-- Team Section -->
<section class="py-5">
    <div class="container py-4">

        <?php if (empty($members)): ?>
        <!-- Empty state -->
        <div class="text-center py-5">
            <i class="fa-solid fa-users-slash fa-4x mb-4" style="color: var(--secondary-color); opacity:0.4;"></i>
            <h4 class="text-muted">Team profiles coming soon.</h4>
            <p class="text-muted">Our attorneys' profiles will be listed here shortly.</p>
        </div>

        <?php else: ?>
        <div class="row g-4 justify-content-center">
            <?php foreach ($members as $member): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm text-center" style="transition:transform 0.2s,box-shadow 0.2s;"
                     onmouseenter="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'"
                     onmouseleave="this.style.transform='';this.style.boxShadow=''">

                    <!-- Photo -->
                    <?php if ($member['photo']): ?>
                        <img src="<?= base_url($member['photo']) ?>" class="card-img-top" alt="<?= esc($member['name']) ?>"
                             style="height: 320px; object-fit: cover; object-position: top;">
                    <?php else: ?>
                        <div class="card-img-top d-flex align-items-center justify-content-center" style="height:320px; background:linear-gradient(135deg,#0b1f3a,#1a365d);">
                            <i class="fa-solid fa-user fa-5x" style="color:#c5a859; opacity:0.5;"></i>
                        </div>
                    <?php endif; ?>

                    <div class="card-body p-4">
                        <h4 class="card-title fw-bold mb-1" style="color: var(--primary-color);"><?= esc($member['name']) ?></h4>
                        <h6 class="text-muted mb-3"><?= esc($member['position']) ?></h6>
                        <?php if ($member['bio']): ?>
                            <p class="card-text small text-muted"><?= esc($member['bio']) ?></p>
                        <?php endif; ?>

                        <div class="mt-3 d-flex justify-content-center gap-3">
                            <?php if ($member['linkedin']): ?>
                                <a href="<?= esc($member['linkedin']) ?>" target="_blank" class="text-muted" title="LinkedIn">
                                    <i class="fa-brands fa-linkedin fs-5"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($member['email']): ?>
                                <a href="mailto:<?= esc($member['email']) ?>" class="text-muted" title="Email">
                                    <i class="fa-solid fa-envelope fs-5"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>
