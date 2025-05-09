<?php echo form_open_multipart($this->uri->uri_string()); ?>
    <div class='box admin-box box-info pt-3'>
        <div class='box-header with-border'>
            <h3 class='box-title'>Transaksi</h3>
        </div>
        <div class='box-body'>
            <div id="accordion">
                <div class="card">
                    <div class="card-header alert alert-success" id="headingOne">
                        <h5 class="mb-0">
                            Data Transaksi
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label("Nama kategori", 'id_kategori', array('class' => 'control-label')); ?>
                                        <input id='id_kategori' class='form-control' type='text' name='id_kategori' value="<?php echo set_value('id_kategori', isset($transaksi->nama_kategori) ? $transaksi->nama_kategori : ''); ?>" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label("Nama Produk", 'nama_produk', array('class' => 'control-label')); ?>
                                        <input id='nama_produk' class='form-control' type='text' name='nama_produk' value="<?php echo set_value('nama_produk', isset($transaksi->nama_produk) ? $transaksi->nama_produk : ''); ?>" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label("Nama Pembeli", 'nama_user', array('class' => 'control-label')); ?>
                                        <input id='nama_user' class='form-control' type='text' name='nama_user' value="<?php echo set_value('nama_user', isset($transaksi->nama_user) ? $transaksi->nama_user : ''); ?>" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label("Tanggal", 'tanggal', array('class' => 'control-label')); ?>
                                        <input id='tanggal' class='form-control' type='text' name='tanggal' value="<?php echo set_value('tanggal', isset($transaksi->tanggal) ? $transaksi->tanggal : ''); ?>" required readonly>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="next-wrapper">
                                        <a href="<?= site_url('transaksi') ?>" class="btn btn-warning">Batal</a>
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
