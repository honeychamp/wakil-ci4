<?php $this->extend('admin/layout'); ?>
<?php $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-newspaper me-2 text-warning"></i> Blog Management</h4>
    <a href="<?= base_url('admin/blogs/add') ?>" class="btn btn-warning fw-semibold">
        <i class="fa-solid fa-plus me-1"></i> New Post
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($blogs)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-pen-nib fa-3x mb-3 d-block"></i>
                <p class="mb-0">No blog posts yet. Create your first post!</p>
            </div>
        <?php else: ?>
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blogs as $blog): ?>
                <tr>
                    <td>
                        <?php if ($blog['image']): ?>
                            <img src="<?= base_url($blog['image']) ?>" width="60" height="50" style="object-fit:cover;border-radius:6px;" alt="cover">
                        <?php else: ?>
                            <div style="width:60px;height:50px;background:#e9ecef;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                <i class="fa-solid fa-image text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong><?= esc($blog['title']) ?></strong><br>
                        <small class="text-muted">/blog/<?= esc($blog['slug']) ?></small>
                    </td>
                    <td><span class="badge bg-secondary"><?= esc($blog['category'] ?: 'General') ?></span></td>
                    <td><?= esc($blog['author']) ?></td>
                    <td>
                        <?php if ($blog['status'] === 'published'): ?>
                            <span class="badge bg-success">Published</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Draft</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('M d, Y', strtotime($blog['created_at'])) ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('admin/blogs/edit/' . $blog['id']) ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <a href="<?= base_url('admin/blogs/delete/' . $blog['id']) ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Delete this blog post?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php $this->endSection(); ?>
