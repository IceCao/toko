<div class="row pt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaksi</h3>
                <!-- <div class="float-right">
                    <a href="<?= site_url('transaksi/create'); ?>" class="btn btn-primary">Tambah</a>
                </div> -->
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
                    <table id="transaksiList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Nama Pembeli</th>
                                <th>Tanggal</th>
                                <th>Status</th>
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
    $("#transaksiList").DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo base_url('transaksi/get_data'); ?>",
            "type": "POST"
        },
        "columns": [
            { "data": "nama_produk" },
            { "data": "nama_kategori" },
            { "data": "nama_user" },
            { "data": "tanggal" },
            { "data": "status" },
            { "data": "id_transaksi" },
        ],
        "rowCallback": function (row, data) {
            var color = '#0dfc05';
            if (data.status == 'proses') {
                color = '#fcc205';
            } else if (data.status == 'gagal') {
                color = '#fc0505';
            }
            $('td:eq(4)', row).html(`<span style="background-color: ${color}; padding:5px; border-radius:10px; color:black;">${data.status}</span>`);
            $('td:eq(5)', row).html(`<a href="<?php echo site_url('transaksi/edit/'); ?>${data.id_transaksi}" class="btn btn-warning btn-sm">Edit</a>`);
        },
    });
  });
</script>