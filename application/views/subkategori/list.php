<div class="row pt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sub Kategori</h3>
                <div class="float-right">
                    <a href="<?= site_url('subkategori/create'); ?>" class="btn btn-primary">Tambah</a>
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
                    <table id="subkategoriList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Sub Kategori</th>
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
    $("#subkategoriList").DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo base_url('subkategori/get_data'); ?>",
            "type": "POST"
        },
        "columns": [
            { "data": "nama_kategori" },
            { "data": "sub_kategori" },
            { "data": "id_sub_kategori" },
        ],
        "rowCallback": function (row, data) {
            $('td:eq(2)', row).html(`<a href="<?php echo site_url('subkategori/edit/'); ?>${data.id_sub_kategori}" class="btn btn-warning btn-sm">Edit</a>`);
        },
    });
  });
</script>