<div class="row pt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gudang</h3>
                <div class="float-right">
                    <a href="<?= site_url('gudang/create'); ?>" class="btn btn-primary">Tambah</a>
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
                    <table id="gudangList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Gudang</th>
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
    $("#gudangList").DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo base_url('gudang/get_data'); ?>",
            "type": "POST"
        },
        "columns": [
            { "data": "nama_gudang" },
            { "data": "id_gudang" },
        ],
        "rowCallback": function (row, data) {
            $('td:eq(1)', row).html(`<a href="<?php echo site_url('gudang/edit/'); ?>${data.id_gudang}" class="btn btn-warning btn-sm">Edit</a>`);
        },
    });
  });
</script>