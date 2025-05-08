<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    form {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-title {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }
</style>

<h2 class="form-title mt-5">Pendaftaran Akun</h2>
<form action="<?= base_url('auth/create'); ?>" method="post">
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php elseif ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <label for="nama_user">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Enter Nama Lengkap" required>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
    </div>
    <div class="form-group">
        <label for="password_confirm">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm password" required>
    </div>
    <div class="d-flex bd-highlight mb-3">
        <div class="bd-highlight">
            <a href="<?php echo site_url() ?>" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        <div class="ms-auto bd-highlight">
            <input type='submit' name='save' class='btn btn-primary' value="Simpan">
        </div>
    </div>
  </div>
</form>