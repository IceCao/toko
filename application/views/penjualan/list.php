<div class="row pt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Penjualan</h3>
                <div class="float-right">
                    <a href="<?= site_url('penjualan/create'); ?>" class="btn btn-primary">Tambah</a>
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
                    <table id="penjualanList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Desc</th>
                                <th>Tgl jual</th>
                                <th>Total stok</th>
                                <th>Total harga</th>
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
    $("#penjualanList").DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo base_url('penjualan/get_data'); ?>",
            "type": "POST"
        },
        "columns": [
            { "data": "desc" },
            { "data": "tgl_jual" },
            { "data": "total_stok" },
            { "data": "total_harga" },
            { "data": "id_penjualan" },
        ],
        "rowCallback": function (row, data) {
            $('td:eq(3)', row).html(formatRupiah(data.total_harga));
            $('td:eq(4)', row).html(`<a href="<?php echo site_url('penjualan/edit/'); ?>${data.id_penjualan}" class="btn btn-warning btn-sm">Edit</a>`);
        },
    });
  });
</script>