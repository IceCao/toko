<div class="row pt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Produk</h3>
                <div class="float-right">
                    <a href="<?= site_url('produk/create'); ?>" class="btn btn-primary">Tambah</a>
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
                    <table id="produkList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Qty</th>
                                <th>Satuan</th>
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
    $("#produkList").DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo base_url('produk/get_data'); ?>",
            "type": "POST"
        },
        "columns": [
            { "data": "nama_produk" },
            { "data": "nama_kategori" },
            { "data": "qty" },
            { "data": "satuan" },
            { "data": "id_produk" },
        ],
        "rowCallback": function (row, data) {
            $('td:eq(4)', row).html(`<a href="<?php echo site_url('produk/edit/'); ?>${data.id_produk}" class="btn btn-warning btn-sm">Edit</a>`);
        },
    });
  });
</script>