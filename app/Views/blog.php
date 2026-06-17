<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<section class="py-5 bg-light text-center">
    <div class="container py-4">
        <h1 class="fw-bold" style="color: var(--primary-color);">Legal Insights &amp; Blog</h1>
        <div class="mx-auto mt-2 mb-3" style="width: 50px; height: 3px; background-color: var(--secondary-color);"></div>
        <p class="text-muted lead">Stay informed with our latest articles on legal trends and advice.</p>
    </div>
</section>

<!-- Blog Posts -->
<section class="py-5">
    <div class="container py-4">

        <?php if (empty($blogs)): ?>
        <!-- Empty State -->
        <div class="text-center py-5">
            <i class="fa-solid fa-pen-nib fa-4x mb-4" style="color: var(--secondary-color); opacity:0.4;"></i>
            <h4 class="text-muted">No blog posts yet.</h4>
            <p class="text-muted">Check back soon — our attorneys are working on insightful articles for you.</p>
        </div>

        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($blogs as $post): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm" style="transition: transform 0.2s, box-shadow 0.2s;"
                     onmouseenter="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'"
                     onmouseleave="this.style.transform='';this.style.boxShadow=''">

                    <!-- Cover Image -->
                    <?php if ($post['image']): ?>
                        <img src="<?= base_url($post['image']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>" style="height: 220px; object-fit: cover;">
                    <?php else: ?>
                        <div class="card-img-top d-flex align-items-center justify-content-center" style="height:220px; background: linear-gradient(135deg,#0b1f3a,#1a365d);">
                            <i class="fa-solid fa-gavel fa-3x" style="color:#c5a859; opacity:0.5;"></i>
                        </div>
                    <?php endif; ?>

                    <div class="card-body p-4">
                        <span class="badge mb-2" style="background-color: var(--secondary-color); color: var(--primary-color);">
                            <?= esc($post['category'] ?: 'Legal') ?>
                        </span>
                        <h5 class="card-title fw-bold" style="color: var(--primary-color);">
                            <?= esc($post['title']) ?>
                        </h5>
                        <p class="card-text text-muted small">
                            <?= esc($post['excerpt'] ?: substr(strip_tags($post['content']), 0, 130) . '...') ?>
                        </p>
                    </div>

                    <div class="card-footer bg-white border-0 px-4 pb-4 d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fa-regular fa-calendar me-1"></i>
                            <?= date('M d, Y', strtotime($post['created_at'])) ?>
                            &nbsp;&bull;&nbsp;
                            <i class="fa-solid fa-user me-1"></i><?= esc($post['author']) ?>
                        </small>
                        <a href="<?= base_url('blog/' . $post['slug']) ?>" class="btn btn-sm fw-semibold" style="color: var(--secondary-color);">
                            Read More &rarr;
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>
