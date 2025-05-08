<div class="row pt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kategori</h3>
                <div class="float-right">
                    <a href="<?= site_url('kategori/create'); ?>" class="btn btn-primary">Tambah</a>
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
                    <table id="kategoriList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kategori</th>
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
    $("#kategoriList").DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo base_url('kategori/get_data'); ?>",
            "type": "POST"
        },
        "columns": [
            { "data": "nama_kategori" },
            { "data": "id_kategori" },
        ],
        "rowCallback": function (row, data) {
            $('td:eq(1)', row).html(`<a href="<?php echo site_url('kategori/edit/'); ?>${data.id_kategori}" class="btn btn-warning btn-sm">Edit</a>`);
        },
    });
  });
</script>