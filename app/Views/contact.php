<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<section class="py-5 bg-light text-center">
    <div class="container py-4">
        <h1 class="fw-bold" style="color: var(--primary-color);">Contact Us</h1>
        <div class="mx-auto mt-2 mb-3" style="width: 50px; height: 3px; background-color: var(--secondary-color);"></div>
        <p class="text-muted lead">Get in touch with our experienced legal team today.</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container py-4">
        <div class="row g-5">
            <!-- Left: Contact Info -->
            <div class="col-lg-5">
                <h3 class="fw-bold mb-4" style="color: var(--primary-color);">Our Office</h3>
                
                <div class="d-flex mb-4">
                    <div class="me-3 fs-3" style="color: var(--secondary-color);"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1">Address</h5>
                        <p class="text-muted mb-0">123 Legal Avenue, Suite 100<br>New York, NY 10001, USA</p>
                    </div>
                </div>
                
                <div class="d-flex mb-4">
                    <div class="me-3 fs-3" style="color: var(--secondary-color);"><i class="fa-solid fa-phone"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1">Phone</h5>
                        <p class="text-muted mb-0">+1 (800) 123-4567<br>+1 (800) 987-6543</p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="me-3 fs-3" style="color: var(--secondary-color);"><i class="fa-solid fa-envelope"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1">Email</h5>
                        <p class="text-muted mb-0">contact@brocellelaw.com<br>support@brocellelaw.com</p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="me-3 fs-3" style="color: var(--secondary-color);"><i class="fa-solid fa-clock"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1">Office Hours</h5>
                        <p class="text-muted mb-0">Monday – Friday: 9:00 AM – 6:00 PM<br>Saturday: 10:00 AM – 2:00 PM</p>
                    </div>
                </div>
            </div>

            <!-- Right: Contact Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4">
                    <h3 class="fw-bold mb-4" style="color: var(--primary-color);">Send Us a Message</h3>

                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('contact/submit') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="full_name" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" placeholder="(123) 456-7890" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Practice Area</label>
                                <select name="practice_area" class="form-select" required>
                                    <option value="">Choose an area...</option>
                                    <option value="Corporate Law">Corporate Law</option>
                                    <option value="Criminal Defense">Criminal Defense</option>
                                    <option value="Family Law">Family Law</option>
                                    <option value="Real Estate Law">Real Estate Law</option>
                                    <option value="Personal Injury">Personal Injury</option>
                                    <option value="Employment Law">Employment Law</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Brief Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Briefly describe your case..." required></textarea>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-gold btn-lg w-100 fw-bold">Submit Request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
