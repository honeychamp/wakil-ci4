<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brocelle Law Firm | <?= esc($title ?? 'Expert Legal Services') ?></title>
    
    <!-- Google Fonts for Professional Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fa-solid fa-scale-balanced me-2"></i>Brocelle Law Firm
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url() ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('about') ?>">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('services') ?>">Practice Areas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('team') ?>">Our Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('blog') ?>">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('contact') ?>">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a class="btn btn-gold px-4" href="<?= base_url('contact') ?>">Free Consultation</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Section (Dynamic) -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="footer-custom mt-5">
        <div class="container">
            <div class="row">
                <!-- About Column -->
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-heading"><i class="fa-solid fa-scale-balanced me-2"></i>Brocelle Law</h5>
                    <p>We provide exceptional legal representation with a commitment to integrity, excellence, and client success. Fighting for your rights.</p>
                    <div class="mt-3">
                        <a href="#" class="me-3 fs-5"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="me-3 fs-5"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="me-3 fs-5"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links Column -->
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="mb-2"><a href="<?= base_url('about') ?>">About the Firm</a></li>
                        <li class="mb-2"><a href="<?= base_url('services') ?>">Practice Areas</a></li>
                        <li class="mb-2"><a href="<?= base_url('team') ?>">Attorneys</a></li>
                        <li class="mb-2"><a href="<?= base_url('blog') ?>">Blog</a></li>
                        <li class="mb-2"><a href="<?= base_url('contact') ?>">Contact Us</a></li>
                    </ul>
                </div>
                
                <!-- Contact Column -->
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-heading">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fa-solid fa-location-dot me-2"></i> 123 Legal Avenue, Suite 100, City, ST 12345</li>
                        <li class="mb-2"><i class="fa-solid fa-phone me-2"></i> +1 (800) 123-4567</li>
                        <li class="mb-2"><i class="fa-solid fa-envelope me-2"></i> contact@brocellelaw.com</li>
                    </ul>
                </div>
            </div>
            
            <hr class="mt-4 mb-4 border-secondary">
            
            <div class="row text-center">
                <div class="col-12">
                    <p class="mb-0">&copy; <?= date('Y') ?> Brocelle Law Firm. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 for Elegant Notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if(session()->getFlashdata('success')): ?>
                Swal.fire({
                    title: 'Success!',
                    text: "<?= esc(session()->getFlashdata('success')) ?>",
                    icon: 'success',
                    confirmButtonColor: '#c5a859'
                });
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                Swal.fire({
                    title: 'Error!',
                    text: "<?= esc(session()->getFlashdata('error')) ?>",
                    icon: 'error',
                    confirmButtonColor: '#0b1f3a'
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
