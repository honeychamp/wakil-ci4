<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Brocelle Law Firm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .login-header {
            background-color: #0b1f3a;
            color: #c5a859;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
    </style>
</head>
<body>

    <div class="card login-card">
        <div class="login-header">
            <h4 class="mb-0">Brocelle Admin</h4>
        </div>
        <div class="card-body p-4">
            <?php if(session()->getFlashdata('msg')): ?>
                <!-- Handled by SweetAlert2 at bottom -->
            <?php endif; ?>

            <form action="<?= base_url('admin/loginAuth') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn w-100" style="background-color: #c5a859; color: #0b1f3a; font-weight: bold;">Login</button>
            </form>
            <div class="text-center mt-3">
                <a href="<?= base_url() ?>" class="text-muted text-decoration-none"><small>&larr; Back to Website</small></a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if(session()->getFlashdata('msg')): ?>
                Swal.fire({
                    title: 'Login Failed',
                    text: "<?= esc(session()->getFlashdata('msg')) ?>",
                    icon: 'error',
                    confirmButtonColor: '#0b1f3a'
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
