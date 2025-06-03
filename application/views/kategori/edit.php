<?php echo form_open($this->uri->uri_string(), 'class=""'); ?>
    <div class='box admin-box box-info pt-3'>
        <div class='box-header with-border'>
            <h3 class='box-title'>Kategori</h3>
        </div>
        <div class='box-body'>
            <div id="accordion">
                <div class="card">
                    <div class="card-header alert alert-success" id="headingOne">
                        <h5 class="mb-0">
                            Data Kategori
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
                                    <div class="form-group">
                                        <?php echo form_label("Nama Kategori", 'nama_kategori', array('class' => 'control-label')); ?>
                                        <input id='nama_kategori' class='form-control' type='text' name='nama_kategori' value="<?php echo set_value('nama_kategori', isset($kategori->nama_kategori) ? $kategori->nama_kategori : ''); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="next-wrapper">
                                        <a href="<?= site_url('kategori') ?>" class="btn btn-warning">Batal</a>
                                        <button type="submit" name="save" class="btn btn-primary">Simpan</button>
                                        <div class="float-right">
                                            <input name='delete' class='btn btn-danger delete-me' value="Hapus" style="width: 90px;" >
                                        </div>
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
