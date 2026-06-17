<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color:#0b1f3a;">
            <i class="fa-solid fa-bell me-2" style="color:#c5a859;"></i> System Notifications
        </h4>
        <p class="text-muted small mb-0">Recent activity log across the entire Brocelle platform.</p>
    </div>
    <span class="badge bg-secondary px-3 py-2">
        <i class="fa-solid fa-clock me-1"></i> Live Feed (Simulated)
    </span>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-list-ul me-2" style="color:#c5a859;"></i> Activity Log
                </h6>
                <small class="text-muted"><?= count($logs) ?> recent events</small>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php foreach($logs as $i => $log): ?>
                    <li class="list-group-item d-flex align-items-start py-3 px-4 <?= $i === 0 ? 'bg-light' : '' ?>">
                        <div class="me-3 mt-1">
                            <span class="badge rounded-circle bg-<?= $log['color'] ?> p-2" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center;">
                                <i class="fa-solid <?= $log['icon'] ?> fa-sm"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 small"><?= $log['message'] ?></p>
                            <small class="text-muted"><i class="fa-regular fa-clock me-1"></i><?= $log['time'] ?></small>
                        </div>
                        <?php if($i === 0): ?>
                            <span class="badge bg-danger ms-2" style="font-size:0.6rem;">NEW</span>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="card-footer bg-white text-center py-3">
                <small class="text-muted">
                    <i class="fa-solid fa-info-circle me-1"></i>
                    This is a simulated activity log. Real-time DB logging will be added in the next phase.
                </small>
            </div>
        </div>
    </div>

    <!-- Right Panel: Summary Cards -->
    <div class="col-lg-4 mt-4 mt-lg-0">

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-chart-pie me-2" style="color:#c5a859;"></i> Event Breakdown</h6>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted"><i class="fa-solid fa-circle text-success me-1" style="font-size:0.5rem;"></i> Payments & Clients</small>
                    <span class="badge bg-success">2</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted"><i class="fa-solid fa-circle text-primary me-1" style="font-size:0.5rem;"></i> Case Updates</small>
                    <span class="badge bg-primary">3</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted"><i class="fa-solid fa-circle text-warning me-1" style="font-size:0.5rem;"></i> Invoice Alerts</small>
                    <span class="badge bg-warning text-dark">2</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted"><i class="fa-solid fa-circle text-info me-1" style="font-size:0.5rem;"></i> Documents & Messages</small>
                    <span class="badge bg-info">2</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted"><i class="fa-solid fa-circle text-danger me-1" style="font-size:0.5rem;"></i> Security Alerts</small>
                    <span class="badge bg-danger">1</span>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #0b1f3a, #1a365d);">
            <div class="card-body text-white text-center py-4">
                <i class="fa-solid fa-shield-halved fa-2x mb-3" style="color:#c5a859;"></i>
                <h6 class="fw-bold mb-1">System Status</h6>
                <p class="small mb-3 opacity-75">All services operational</p>
                <div class="d-flex justify-content-center gap-3">
                    <div class="text-center">
                        <div class="rounded-circle bg-success mx-auto mb-1" style="width:10px;height:10px;"></div>
                        <small style="font-size:0.65rem; opacity:0.8;">Database</small>
                    </div>
                    <div class="text-center">
                        <div class="rounded-circle bg-success mx-auto mb-1" style="width:10px;height:10px;"></div>
                        <small style="font-size:0.65rem; opacity:0.8;">Auth</small>
                    </div>
                    <div class="text-center">
                        <div class="rounded-circle bg-success mx-auto mb-1" style="width:10px;height:10px;"></div>
                        <small style="font-size:0.65rem; opacity:0.8;">Storage</small>
                    </div>
                    <div class="text-center">
                        <div class="rounded-circle bg-success mx-auto mb-1" style="width:10px;height:10px;"></div>
                        <small style="font-size:0.65rem; opacity:0.8;">Mail</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
