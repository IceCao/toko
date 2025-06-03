<div class="row pt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pembelian</h3>
                <div class="float-right">
                    <a href="<?= site_url('pembelian/create'); ?>" class="btn btn-primary">Tambah</a>
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
                    <table id="pembelianList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama produk</th>
                                <th>Kategori</th>
                                <th>Gudang</th>
                                <th>Nama pembeli</th>
                                <th>Harga beli</th>
                                <th>Stok</th>
                                <th>Total harga</th>
                                <th>Tanggal beli</th>
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
    $("#pembelianList").DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo base_url('pembelian/get_data'); ?>",
            "type": "POST"
        },
        "columns": [
            { "data": "sub_kategori" },
            { "data": "nama_kategori" },
            { "data": "nama_gudang" },
            { "data": "nama_user" },
            { "data": "harga" },
            { "data": "stok" },
            { "data": "total_harga" },
            { "data": "tgl_beli" },
            { "data": "id_pembelian" },
        ],
        "rowCallback": function (row, data) {
            $('td:eq(4)', row).html(formatRupiah(data.harga));
            $('td:eq(6)', row).html(formatRupiah(data.total_harga));
            $('td:eq(8)', row).html(`<a href="<?php echo site_url('pembelian/edit/'); ?>${data.id_pembelian}" class="btn btn-warning btn-sm">Edit</a>`);
        },
    });
  });
</script>