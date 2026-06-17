<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Portal Login - Brocelle Law Firm</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0b1f3a;
            --secondary-color: #c5a859;
            --bg-light: #f4f7f6;
        }
        body {
            background-color: var(--bg-light);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Georgia', serif;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            background-color: #ffffff;
            overflow: hidden;
        }
        .login-header {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 30px 20px;
            text-align: center;
            border-bottom: 3px solid var(--secondary-color);
        }
        .login-header h4 {
            font-family: 'Playfair Display', serif;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .btn-portal {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-weight: bold;
            transition: 0.3s;
            border: none;
        }
        .btn-portal:hover {
            background-color: #dcb865;
            color: var(--primary-color);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <div class="card login-card">
        <div class="login-header">
            <h4 class="mb-1"><i class="fa-solid fa-scale-balanced me-2"></i>Brocelle Law</h4>
            <span class="text-white-50 small">Secure Client Case Portal</span>
        </div>
        <div class="card-body p-4">
            <?php if(session()->getFlashdata('msg')): ?>
                <!-- Handled by SweetAlert2 -->
            <?php endif; ?>

            <form action="<?= base_url('client/loginAuth') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Client Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="yourname@example.com" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Secret Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-portal w-100 py-2">
                    Enter Secure Portal
                </button>
            </form>
            
            <div class="text-center mt-4">
                <a href="<?= base_url() ?>" class="text-muted text-decoration-none small">&larr; Return to Firm Website</a>
            </div>

            <!-- Forgot Password Note -->
            <div class="mt-4 p-3 rounded text-center" style="background:#fff8e1; border:1px solid #ffc107;">
                <p class="mb-1 small fw-bold" style="color:#856404;">
                    <i class="fa-solid fa-lock-open me-1"></i> Forgot your password?
                </p>
                <p class="mb-0 small text-muted">
                    Please contact <strong>Brocelle Law Firm</strong> directly.<br>
                    Our team will reset your portal access.
                </p>
                <a href="<?= base_url('contact') ?>" class="btn btn-sm mt-2 fw-semibold"
                   style="background:#c5a859; color:#0b1f3a; font-size:0.75rem;">
                    <i class="fa-solid fa-phone me-1"></i> Contact Us
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // Show new account credentials in a prominent popup if redirected from case filing
            <?php $newAccount = session()->getFlashdata('new_account'); ?>
            <?php if($newAccount): ?>
                <?php $creds = json_decode($newAccount, true); ?>
                setTimeout(function() {
                    Swal.fire({
                        title: 'Your Login Credentials',
                        html: '<p class="text-muted mb-3">Your case is filed! Please save these details to log in to your portal.</p>'
                            + '<div style="background:#f8f9fa;border-radius:10px;padding:16px;text-align:left;border:1px solid #dee2e6;">'
                            + '<div class="mb-2"><small class="text-muted d-block fw-bold">EMAIL</small>'
                            + '<strong style="color:#0b1f3a;font-size:1rem;"><?= esc($creds['email'] ?? '') ?></strong></div>'
                            + '<div><small class="text-muted d-block fw-bold">AUTO-GENERATED PASSWORD</small>'
                            + '<strong style="color:#c5a859;font-size:1.3rem;letter-spacing:2px;"><?= esc($creds['password'] ?? '') ?></strong></div>'
                            + '</div>'
                            + '<p class="text-danger small mt-3"><i class="fa-solid fa-triangle-exclamation me-1"></i>Screenshot this password now! You can change it later.</p>',
                        icon: 'success',
                        confirmButtonText: 'I have saved them. Let me login.',
                        confirmButtonColor: '#0b1f3a',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        width: '500px'
                    });
                }, 500);
            <?php endif; ?>

            <?php if(session()->getFlashdata('success') && !session()->getFlashdata('new_account')): ?>
                Swal.fire({
                    title: 'Success',
                    text: "<?= esc(session()->getFlashdata('success')) ?>",
                    icon: 'success',
                    confirmButtonColor: '#c5a859'
                });
            <?php endif; ?>

            <?php if(session()->getFlashdata('msg')): ?>
                Swal.fire({
                    title: 'Access Denied',
                    text: "<?= esc(session()->getFlashdata('msg')) ?>",
                    icon: 'error',
                    confirmButtonColor: '#0b1f3a'
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
