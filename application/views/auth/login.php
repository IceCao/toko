<style>
    body {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: Arial, sans-serif;
    }
    .login-container {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }
    .login-container h3 {
        font-weight: bold;
        color: #333;
    }
    .btn-primary {
        background-color: #6a11cb;
        border-color: #6a11cb;
    }
    .btn-primary:hover {
        background-color: #2575fc;
        border-color: #2575fc;
    }
    a {
        color: #6a11cb;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
<div class="login-container">
    <h3 class="text-center mb-4">Login</h3>
    <form action="<?= site_url('auth/cekLogin'); ?>" method="post">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <input type="submit" name="login" class="btn btn-primary w-100" value="Login">
    </form>
    <p class="text-center mt-3">
        <a href="<?php echo site_url('auth/daftar') ?>">Belum punya akun? Daftar</a>
    </p>
</div>