<div class="row pt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Users</h3>
                <div class="float-right">
                    <a href="<?= site_url('users/create'); ?>" class="btn btn-primary">Tambah</a>
                </div>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php elseif ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table id="usersList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $(function () {
    $("#usersList").DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo base_url('users/get_data'); ?>",
            "type": "POST"
        },
        "columns": [
            { "data": "nama_user" },
            { "data": "username" },
            { "data": "role" },
            { "data": "id_user" },
        ],
        "rowCallback": function (row, data) {
            $('td:eq(3)', row).html(`<a href="<?php echo site_url('users/edit/'); ?>${data.id_user}" class="btn btn-warning btn-sm">Edit</a>`);
        },
    });
  });
</script>