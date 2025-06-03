<?php echo form_open($this->uri->uri_string(), 'class=""'); ?>
    <div class='box admin-box box-info pt-3'>
        <div class='box-header with-border'>
            <h3 class='box-title'>Penjualan</h3>
        </div>
        <div class='box-body'>
            <div id="accordion">
                <div class="card">
                    <div class="card-header alert alert-success" id="headingOne">
                        <h5 class="mb-0">
                            Data Penjualan
                        </h5>
                    </div>
                    <div id="collapse-1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if ($this->session->flashdata('success')): ?>
                                        <div class="alert alert-success" role="alert">
                                            <?= $this->session->flashdata('success'); ?>
                                        </div>
                                    <?php elseif ($this->session->flashdata('error')): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $this->session->flashdata('error'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Produk</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered table-hover table-striped" id="list_produk_table">
                                                        <thead>
                                                            <tr>
                                                                <th>Kategori</th>
                                                                <th>Nama Produk</th>
                                                                <th>Gudang</th>
                                                                <th>Harga Jual</th>
                                                                <th>Stok</th>
                                                                <th>Total Harga Jual</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12">
                                                    <p class="float-right" id="total-harga"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= form_label('Tanggal jual', 'tgl_jual', array('class' => 'control-label')); ?>
                                        <div class="input-group date read-datepicker" id="tgl_jual" data-target-input="nearest" readonly>
                                            <input type="text" name="tgl_jual" class="form-control datetimepicker-input" 
                                                data-target="#tgl_jual" required value="<?php echo set_value('tgl_jual', isset($penjualan->tgl_jual) ? $penjualan->tgl_jual : ''); ?>"/>
                                            <div class="input-group-append" data-target="#tgl_jual" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class='col-md-12'>
                                    <div class='form-group<?php echo form_error('desc') ? ' error' : ''; ?>'>
                                        <?php echo form_label('Deskripsi', 'desc', array('class' => '')); ?>
                                        <textarea name="desc" class='form-control'><?php echo set_value('desc', isset($penjualan->desc) ? $penjualan->desc : ''); ?></textarea>
                                        <span class='help-inline'><?php echo form_error('desc'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <?= form_label('Foto', 'foto', array('class' => 'control-label')); ?>
                                    <div id="attachment-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Aksi <small style="color: red;">Maks 5MB</small></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (isset($attachments)) : foreach ($attachments as $key => $val): ?>
                                                        <tr>
                                                            <td>
                                                                <label class="uploader">
                                                                    <input type="hidden" name="files[]" id="file_path_" value="<?= $val; ?>">
                                                                </label>
                                                                <button type="button" class="btn btn-danger delete-row">Hapus</button> 
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-info" id="att_url_"><?= $val; ?></span>
                                                                <br><br>
                                                                <button type="button" id="window_url_" class="btn btn-primary"
                                                                        onClick="lookAttachment('<?= $val; ?>')">
                                                                    Lihat
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="button" class="btn btn-success" id="add-attachment-row" style="float: right;">Tambah Foto</button>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="next-wrapper">
                                        <a href="<?= site_url('penjualan') ?>" class="btn btn-warning">Batal</a>
                                        <!-- <button type="submit" name="save" class="btn btn-primary">Simpan</button>
                                        <div class="float-right">
                                            <input name='delete' class='btn btn-danger delete-me' value="Hapus" style="width: 90px;" >
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>
<script>
    $(function () {
        $("#list_produk_table").DataTable({
            "processing": true,
            "ajax": {
                "url": "<?php echo base_url('penjualan/get_produk_jual/' . $penjualan->id_penjualan); ?>",
                "type": "POST",
                "dataSrc": function (json) {
                    let total = 0;
                    json.data.forEach(function (item) {
                        total += parseFloat(item.total_harga) || 0;
                    });
                    $('#total-harga').html('Total Harga : Rp ' + total.toLocaleString('id-ID'));
                    return json.data;
                }
            },
            "columns": [
                { data: 'nama_kategori' },
                { data: 'sub_kategori' },
                { data: 'nama_gudang' },
                { data: 'harga_jual' },
                { data: 'total_stok' },
                { data: 'total_harga' },
            ],
            "rowCallback": function (row, data) {
            },
        });
    });
</script>