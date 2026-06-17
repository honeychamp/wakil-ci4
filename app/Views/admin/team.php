<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0" style="color:#0b1f3a;">
        <i class="fa-solid fa-user-tie me-2" style="color:#c5a859;"></i> Team & Lawyer Management
    </h4>
</div>

<div class="row g-4">
    <!-- Add Team Member Form -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-dark text-white fw-bold py-3">
                <i class="fa-solid fa-user-plus me-2"></i> Add Team Member
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('admin/team/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Sarah Johnson" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Position / Title <span class="text-danger">*</span></label>
                        <input type="text" name="position" class="form-control" placeholder="e.g. Senior Partner" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-scale-balanced me-1" style="color:#c5a859;"></i>
                            Law Specialization
                        </label>
                        <select name="specialization" class="form-select">
                            <option value="">-- Select Practice Area --</option>
                            <option value="Corporate & Business Law">Corporate & Business Law</option>
                            <option value="Criminal Defense">Criminal Defense</option>
                            <option value="Family & Divorce Law">Family & Divorce Law</option>
                            <option value="Real Estate & Property Law">Real Estate & Property Law</option>
                            <option value="Personal Injury Law">Personal Injury Law</option>
                            <option value="Employment & Labor Law">Employment & Labor Law</option>
                            <option value="Immigration Law">Immigration Law</option>
                            <option value="Intellectual Property (IP) Law">Intellectual Property (IP) Law</option>
                            <option value="Bankruptcy & Debt Law">Bankruptcy & Debt Law</option>
                            <option value="Tax & Financial Law">Tax & Financial Law</option>
                        </select>
                        <div class="form-text">Cases from this law area will be auto-assigned to this lawyer.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Bio</label>
                        <textarea name="bio" class="form-control" rows="3" placeholder="Short professional biography..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="attorney@brocelle.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">LinkedIn URL</label>
                        <input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Display Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0" min="0">
                        <div class="form-text">Lower numbers appear first.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>

                    <div class="border rounded p-3 mb-3" style="background:#f8f9fa; border-color:#c5a859 !important;">
                        <label class="form-label fw-bold small" style="color:#0b1f3a;">
                            <i class="fa-solid fa-key me-1" style="color:#c5a859;"></i>
                            Lawyer Portal Password
                            <span class="text-muted fw-normal">(optional)</span>
                        </label>
                        <input type="password" name="password" class="form-control" placeholder="Set portal login password...">
                        <div class="form-text mt-1">
                            <i class="fa-solid fa-info-circle me-1"></i>
                            Set a password to allow this lawyer to log in at <code>/admin</code> using their email.
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 fw-bold" style="background:#0b1f3a; color:#c5a859;">
                        <i class="fa-solid fa-user-plus me-2"></i> Add Team Member
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Team Members List -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-dark text-white fw-bold py-3">
                <i class="fa-solid fa-users me-2"></i> Current Team (<?= count($members) ?> members)
            </div>
            <div class="card-body p-0">
                <?php if (empty($members)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-users-slash fa-3x mb-3 d-block"></i>
                        <p class="mb-0">No team members added yet.</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($members as $member): ?>
                        <div class="list-group-item p-3">
                            <div class="d-flex align-items-center gap-3">
                                <!-- Photo -->
                                <?php if ($member['photo']): ?>
                                    <img src="<?= base_url($member['photo']) ?>"
                                         width="65" height="65"
                                         style="object-fit:cover;border-radius:50%;border:2px solid #c5a859;"
                                         alt="<?= esc($member['name']) ?>">
                                <?php else: ?>
                                    <div style="width:65px;height:65px;border-radius:50%;background:#1a365d;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="fa-solid fa-user fa-lg text-warning"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Info -->
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2">
                                        <strong><?= esc($member['name']) ?></strong>
                                        <?php if (!empty($member['password'])): ?>
                                            <span class="badge" style="background:#c5a859; color:#0b1f3a; font-size:0.6rem;">
                                                <i class="fa-solid fa-key me-1"></i>Portal Enabled
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-muted small"><?= esc($member['position']) ?></div>
                                    <?php if (!empty($member['specialization'])): ?>
                                        <div class="mt-1">
                                            <span class="badge" style="background:#0b1f3a22; color:#0b1f3a; font-size:0.65rem; border:1px solid #0b1f3a44;">
                                                <i class="fa-solid fa-scale-balanced me-1"></i><?= esc($member['specialization']) ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($member['email']): ?>
                                        <div class="text-muted small">
                                            <i class="fa-solid fa-envelope me-1"></i><?= esc($member['email']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($member['bio']): ?>
                                        <div class="text-muted small mt-1" style="max-width:400px;">
                                            <?= esc(substr($member['bio'], 0, 100)) ?><?= strlen($member['bio']) > 100 ? '...' : '' ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Order badge + Delete -->
                                <div class="text-end flex-shrink-0">
                                    <span class="badge bg-secondary mb-2 d-block">Order: <?= $member['sort_order'] ?></span>
                                    <a href="<?= base_url('admin/team/delete/' . $member['id']) ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Remove <?= esc($member['name']) ?> from the team?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
