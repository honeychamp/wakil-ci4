<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<section class="py-5 bg-light text-center">
    <div class="container py-4">
        <h1 class="fw-bold" style="color: var(--primary-color);">About Brocelle Law Firm</h1>
        <div class="mx-auto mt-2 mb-3" style="width: 50px; height: 3px; background-color: var(--secondary-color);"></div>
        <p class="text-muted lead">A legacy of excellence, integrity, and relentless advocacy.</p>
    </div>
</section>

<!-- About Content -->
<section class="py-5">
    <div class="container py-4">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=800&auto=format&fit=crop" alt="Law Firm Office" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6 px-lg-5">
                <h2 class="fw-bold mb-3" style="color: var(--primary-color);">Our History</h2>
                <p class="text-muted">Founded in 1998, Brocelle Law Firm has grown from a small practice into one of the most respected legal institutions in the state. For over two decades, we have dedicated ourselves to providing exceptional legal representation to individuals and businesses facing complex legal challenges.</p>
                <p class="text-muted">Our firm was built on a foundation of unyielding ethical standards, exhaustive preparation, and a deep understanding of the law. We don't just take cases; we take causes.</p>
            </div>
        </div>

        <div class="row align-items-center flex-column-reverse flex-lg-row">
            <div class="col-lg-6 px-lg-5 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3" style="color: var(--primary-color);">Our Mission & Vision</h2>
                <p class="text-muted"><strong>Our Mission:</strong> To provide strategic, high-quality legal services that protect our clients' rights, preserve their assets, and secure their futures.</p>
                <p class="text-muted"><strong>Our Vision:</strong> To be the standard of excellence in the legal profession, recognized for our unwavering commitment to justice, our innovative legal strategies, and our profound dedication to our clients and our community.</p>
                
                <div class="mt-4">
                    <a href="<?= base_url('team') ?>" class="btn btn-gold px-4 py-2">Meet Our Team</a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1505664173696-0736fbbc4560?q=80&w=800&auto=format&fit=crop" alt="Scales of Justice" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 text-white text-center" style="background-color: var(--primary-color);">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <h2 class="display-4 fw-bold" style="color: var(--secondary-color);">25+</h2>
                <p class="fs-5">Years Experience</p>
            </div>
            <div class="col-md-3 col-6">
                <h2 class="display-4 fw-bold" style="color: var(--secondary-color);">5k+</h2>
                <p class="fs-5">Cases Won</p>
            </div>
            <div class="col-md-3 col-6">
                <h2 class="display-4 fw-bold" style="color: var(--secondary-color);">98%</h2>
                <p class="fs-5">Success Rate</p>
            </div>
            <div class="col-md-3 col-6">
                <h2 class="display-4 fw-bold" style="color: var(--secondary-color);">50M+</h2>
                <p class="fs-5">Recovered</p>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
