<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1>Justice, Integrity, and Excellence</h1>
                <p>Top-rated legal representation for individuals and businesses. Let our experienced attorneys fight for your rights and deliver the results you deserve.</p>
                <div class="mt-4">
                    <a href="#contact" class="btn btn-gold btn-lg me-3 px-4 py-2">Consult an Attorney</a>
                    <a href="#services" class="btn btn-outline-light btn-lg px-4 py-2">Our Services</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Practice Areas Section -->
<section id="services" class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Practice Areas</h2>
            <div class="mx-auto mt-2 mb-3" style="width: 50px; height: 3px; background-color: var(--secondary-color);"></div>
            <p class="text-muted">Comprehensive legal solutions tailored to your specific needs.</p>
        </div>
        
        <div class="row g-4">
            <!-- Service 1 -->
            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center p-4">
                    <div class="card-body">
                        <div class="service-icon"><i class="fa-solid fa-briefcase"></i></div>
                        <h4 class="card-title h5 mb-3">Corporate Law</h4>
                        <p class="card-text text-muted">Business formation, mergers, acquisitions, and comprehensive contract negotiation.</p>
                        <a href="<?= base_url('services') ?>" class="text-decoration-none fw-bold" style="color: var(--secondary-color);">Read More <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Service 2 -->
            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center p-4">
                    <div class="card-body">
                        <div class="service-icon"><i class="fa-solid fa-gavel"></i></div>
                        <h4 class="card-title h5 mb-3">Criminal Defense</h4>
                        <p class="card-text text-muted">Aggressive representation for DUI, white-collar crimes, and state/federal charges.</p>
                        <a href="<?= base_url('services') ?>" class="text-decoration-none fw-bold" style="color: var(--secondary-color);">Read More <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Service 3 -->
            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center p-4">
                    <div class="card-body">
                        <div class="service-icon"><i class="fa-solid fa-house-chimney-window"></i></div>
                        <h4 class="card-title h5 mb-3">Family Law</h4>
                        <p class="card-text text-muted">Compassionate support for divorce, child custody, alimony, and adoption cases.</p>
                        <a href="<?= base_url('services') ?>" class="text-decoration-none fw-bold" style="color: var(--secondary-color);">Read More <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Service 4 -->
            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center p-4">
                    <div class="card-body">
                        <div class="service-icon"><i class="fa-solid fa-building"></i></div>
                        <h4 class="card-title h5 mb-3">Real Estate Law</h4>
                        <p class="card-text text-muted">Handling property disputes, lease agreements, and residential/commercial closings.</p>
                        <a href="<?= base_url('services') ?>" class="text-decoration-none fw-bold" style="color: var(--secondary-color);">Read More <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Service 5 -->
            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center p-4">
                    <div class="card-body">
                        <div class="service-icon"><i class="fa-solid fa-user-injured"></i></div>
                        <h4 class="card-title h5 mb-3">Personal Injury</h4>
                        <p class="card-text text-muted">Fighting for maximum compensation in auto accidents and medical malpractice.</p>
                        <a href="<?= base_url('services') ?>" class="text-decoration-none fw-bold" style="color: var(--secondary-color);">Read More <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Service 6 -->
            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center p-4">
                    <div class="card-body">
                        <div class="service-icon"><i class="fa-solid fa-scale-unbalanced"></i></div>
                        <h4 class="card-title h5 mb-3">Employment Law</h4>
                        <p class="card-text text-muted">Protecting rights against wrongful termination, discrimination, and wage disputes.</p>
                        <a href="<?= base_url('services') ?>" class="text-decoration-none fw-bold" style="color: var(--secondary-color);">Read More <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Preview / Why Choose Us Section -->
<section class="py-5">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1505664173696-0736fbbc4560?q=80&w=800&auto=format&fit=crop" alt="Lawyer discussing case" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6 px-lg-5">
                <h2 class="fw-bold mb-3" style="color: var(--primary-color);">Why Choose Brocelle Law Firm?</h2>
                <p class="text-muted mb-4">With over 20 years of combined experience, our legal team has successfully handled thousands of complex cases. We believe in aggressive representation backed by thorough preparation.</p>
                
                <div class="d-flex mb-3">
                    <div class="me-3 fs-3" style="color: var(--secondary-color);"><i class="fa-solid fa-check-circle"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1">Experienced Attorneys</h5>
                        <p class="text-muted small">Top-tier graduates with decades of courtroom experience.</p>
                    </div>
                </div>
                
                <div class="d-flex mb-3">
                    <div class="me-3 fs-3" style="color: var(--secondary-color);"><i class="fa-solid fa-check-circle"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1">Client-Centered Approach</h5>
                        <p class="text-muted small">We prioritize clear communication and personalized legal strategies.</p>
                    </div>
                </div>
                
                <div class="d-flex mb-4">
                    <div class="me-3 fs-3" style="color: var(--secondary-color);"><i class="fa-solid fa-check-circle"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1">Proven Track Record</h5>
                        <p class="text-muted small">Millions recovered in settlements and numerous not-guilty verdicts.</p>
                    </div>
                </div>
                
                <a href="<?= base_url('about') ?>" class="btn btn-outline-gold px-4 py-2">Learn More About Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Team Section (Dynamic) -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Leading Attorneys</h2>
            <div class="mx-auto mt-2 mb-3" style="width: 50px; height: 3px; background-color: var(--secondary-color);"></div>
            <p class="text-muted">Meet the dedicated professionals fighting for your rights.</p>
        </div>

        <?php if (empty($teamMembers)): ?>
            <div class="text-center text-muted py-4">
                <p>Team profiles coming soon.</p>
            </div>
        <?php else: ?>
            <div class="row g-4 justify-content-center">
                <?php foreach ($teamMembers as $member): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm text-center">
                            <?php if ($member['photo']): ?>
                                <img src="<?= base_url($member['photo']) ?>" class="card-img-top" alt="<?= esc($member['name']) ?>" style="height: 300px; object-fit: cover; object-position: top;">
                            <?php else: ?>
                                <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 300px; background: linear-gradient(135deg,#0b1f3a,#1a365d);">
                                    <i class="fa-solid fa-user fa-4x" style="color:#c5a859; opacity:0.5;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-1" style="color: var(--primary-color);"><?= esc($member['name']) ?></h5>
                                <p class="text-muted small mb-3"><?= esc($member['position']) ?></p>
                                <div class="d-flex justify-content-center gap-3 mt-2">
                                    <?php if ($member['linkedin']): ?>
                                        <a href="<?= esc($member['linkedin']) ?>" target="_blank" class="text-muted"><i class="fa-brands fa-linkedin fs-5"></i></a>
                                    <?php endif; ?>
                                    <?php if ($member['email']): ?>
                                        <a href="mailto:<?= esc($member['email']) ?>" class="text-muted"><i class="fa-solid fa-envelope fs-5"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-5">
                <a href="<?= base_url('team') ?>" class="btn btn-outline-gold px-4">View All Team Members</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5" style="background-color: var(--primary-color);">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-white">What Our Clients Say</h2>
            <div class="mx-auto mt-2 mb-3" style="width: 50px; height: 3px; background-color: var(--secondary-color);"></div>
            <p style="color: #aaa;">Trusted by thousands of clients nationwide.</p>
        </div>

        <div class="row g-4">
            <!-- Testimonial 1 -->
            <div class="col-md-4">
                <div class="card border-0 h-100 p-4" style="background-color: #1a365d; color: white; border-radius: 8px;">
                    <div class="mb-3" style="color: var(--secondary-color); font-size: 1.2rem;">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="mb-4" style="color: #ccc; font-style: italic;">"Brocelle Law Firm helped me win my custody case. Their team was compassionate, professional, and always kept me informed. I couldn't have done it without them."</p>
                    <div class="d-flex align-items-center mt-auto">
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" style="width:45px; height:45px; font-size:1.2rem;"><i class="fa-solid fa-user"></i></div>
                        <div>
                            <strong style="color: var(--secondary-color);">Emily R.</strong><br>
                            <small style="color: #aaa;">Family Law Client</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="col-md-4">
                <div class="card border-0 h-100 p-4" style="background-color: #1a365d; color: white; border-radius: 8px;">
                    <div class="mb-3" style="color: var(--secondary-color); font-size: 1.2rem;">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="mb-4" style="color: #ccc; font-style: italic;">"When I was facing serious criminal charges, I was terrified. Michael Chang built a bulletproof defense and got my case dismissed. Absolutely outstanding legal work."</p>
                    <div class="d-flex align-items-center mt-auto">
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" style="width:45px; height:45px; font-size:1.2rem;"><i class="fa-solid fa-user"></i></div>
                        <div>
                            <strong style="color: var(--secondary-color);">David K.</strong><br>
                            <small style="color: #aaa;">Criminal Defense Client</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="col-md-4">
                <div class="card border-0 h-100 p-4" style="background-color: #1a365d; color: white; border-radius: 8px;">
                    <div class="mb-3" style="color: var(--secondary-color); font-size: 1.2rem;">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="mb-4" style="color: #ccc; font-style: italic;">"Robert Brocelle handled our company's merger flawlessly. His expertise in corporate law saved us from potential legal pitfalls. A truly world-class firm."</p>
                    <div class="d-flex align-items-center mt-auto">
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" style="width:45px; height:45px; font-size:1.2rem;"><i class="fa-solid fa-user"></i></div>
                        <div>
                            <strong style="color: var(--secondary-color);">Jennifer M.</strong><br>
                            <small style="color: #aaa;">Corporate Law Client</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Insights Section (Dynamic) -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Latest Legal Insights</h2>
            <div class="mx-auto mt-2 mb-3" style="width: 50px; height: 3px; background-color: var(--secondary-color);"></div>
            <p class="text-muted">Stay informed with the latest updates and advice from our legal experts.</p>
        </div>

        <?php if (empty($latestBlogs)): ?>
            <div class="text-center text-muted py-4">
                <p>No blog posts published yet.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($latestBlogs as $post): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <?php if ($post['image']): ?>
                                <img src="<?= base_url($post['image']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg,#0b1f3a,#1a365d);">
                                    <i class="fa-solid fa-gavel fa-3x" style="color:#c5a859; opacity:0.5;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body p-4">
                                <span class="badge mb-2" style="background-color: var(--secondary-color); color: var(--primary-color);"><?= esc($post['category'] ?: 'Legal') ?></span>
                                <h5 class="card-title fw-bold" style="color: var(--primary-color);"><?= esc($post['title']) ?></h5>
                                <p class="card-text text-muted small"><?= esc($post['excerpt'] ?: substr(strip_tags($post['content']), 0, 100) . '...') ?></p>
                            </div>
                            <div class="card-footer bg-white border-0 px-4 pb-4">
                                <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> <?= date('M d, Y', strtotime($post['created_at'])) ?></small>
                                <a href="<?= base_url('blog/' . $post['slug']) ?>" class="btn btn-sm float-end" style="color: var(--secondary-color); font-weight: 600;">Read More &rarr;</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-5">
                <a href="<?= base_url('blog') ?>" class="btn btn-outline-gold px-4">View All Insights</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Quick Contact Section -->
<section id="contact" class="py-5" style="background-color: var(--primary-color); color: white;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold mb-3" style="color: var(--secondary-color);">Need Legal Advice?</h2>
                <p class="mb-4">Don't navigate the complex legal system alone. Contact us today for a confidential consultation.</p>
                
                <div class="card border-0 rounded-3 text-start p-4" style="background-color: white; color: var(--text-dark);">
                    <?php if(session()->getFlashdata('success')): ?>
                        <!-- Success handled by SweetAlert2 in layout/main.php -->
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
                                <label class="form-label fw-bold">Legal Issue (Practice Area)</label>
                                <select name="practice_area" class="form-select" required>
                                    <option value="" selected>Choose an area...</option>
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
                                <textarea name="description" class="form-control" rows="3" placeholder="Describe your case briefly..." required></textarea>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-gold btn-lg w-100 fw-bold">Request Consultation</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
