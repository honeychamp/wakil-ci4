<?php $this->extend('admin/layout'); ?>
<?php $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="fa-solid fa-pen-nib me-2 text-warning"></i>
        <?= $blog ? 'Edit Blog Post' : 'New Blog Post' ?>
    </h4>
    <a href="<?= base_url('admin/blogs') ?>" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="<?= $blog ? base_url('admin/blogs/update/' . $blog['id']) : base_url('admin/blogs/store') ?>"
              method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Post Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg"
                               placeholder="Enter an engaging title..."
                               value="<?= esc($blog['title'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Short Excerpt</label>
                        <textarea name="excerpt" class="form-control" rows="2"
                                  placeholder="Brief summary shown on blog listing page..."><?= esc($blog['excerpt'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="blogContent" class="form-control" rows="14"
                                  placeholder="Write your full blog post here..." required><?= esc($blog['content'] ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <div class="card bg-light border-0 p-3 mb-3">
                        <h6 class="fw-bold mb-3"><i class="fa-solid fa-gear me-1"></i> Post Settings</h6>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="draft" <?= isset($blog['status']) && $blog['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= isset($blog['status']) && $blog['status'] === 'published' ? 'selected' : '' ?>>Published</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <input type="text" name="category" class="form-control"
                                   placeholder="e.g. Family Law, News..."
                                   value="<?= esc($blog['category'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Author</label>
                            <input type="text" name="author" class="form-control"
                                   placeholder="Author name"
                                   value="<?= esc($blog['author'] ?? 'Admin') ?>">
                        </div>
                    </div>

                    <div class="card bg-light border-0 p-3 mb-3">
                        <h6 class="fw-bold mb-3"><i class="fa-solid fa-image me-1"></i> Cover Image</h6>
                        <?php if (!empty($blog['image'])): ?>
                            <img src="<?= base_url($blog['image']) ?>" class="img-fluid rounded mb-2" alt="Current cover">
                            <p class="text-muted small mb-2">Upload a new image to replace.</p>
                        <?php endif; ?>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-warning w-100 fw-bold py-2">
                        <i class="fa-solid fa-save me-2"></i>
                        <?= $blog ? 'Update Post' : 'Publish Post' ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $this->endSection(); ?>
