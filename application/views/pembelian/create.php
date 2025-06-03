<?php echo form_open_multipart($this->uri->uri_string()); ?>
    <div class='box admin-box box-info pt-3'>
        <div class='box-header with-border'>
            <h3 class='box-title'>Pembelian</h3>
        </div>
        <div class='box-body'>
            <div id="accordion">
                <div class="card">
                    <div class="card-header alert alert-success" id="headingOne">
                        <h5 class="mb-0">
                            Data Pembelian
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
                                        <select class='form-control' name="id_kategori" id="id_kategori">
                                            <?php if (isset($kategori)) : ?>                                                
                                                <?php foreach ($kategori as $row): ?>
                                                    <option value="<?= $row->id_kategori ?>"><?= $row->nama_kategori ?></option>
                                                <?php endforeach; ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label("Nama produk", 'id_sub_kategori', array('class' => 'control-label')); ?>
                                        <select class='form-control' name="id_sub_kategori" id="id_sub_kategori">
                                            <?php if (isset($sub_kategori)) : ?>                                                
                                                <?php foreach ($sub_kategori as $row): ?>
                                                    <option value="<?= $row->id_sub_kategori ?>"><?= $row->sub_kategori ?></option>
                                                <?php endforeach; ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label("Gudang", 'id_gudang', array('class' => 'control-label')); ?>
                                        <select class='form-control' name="id_gudang" id="id_gudang">
                                            <?php if (isset($gudang)) : ?>                                                
                                                <?php foreach ($gudang as $row): ?>
                                                    <option value="<?= $row->id_gudang ?>"><?= $row->nama_gudang ?></option>
                                                <?php endforeach; ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                </div>

                                <div class='col-md-6'>
                                    <div class='form-group<?php echo form_error('harga') ? ' error' : ''; ?>'>
                                        <?php echo form_label('Harga Beli', 'harga', array('class' => '')); ?>
                                        <input type='number' class='form-control form-numeric' required name='harga' />
                                        <span class='help-inline'><?php echo form_error('harga'); ?></span>
                                    </div>
                                </div>

                                <div class='col-md-6'>
                                    <div class='form-group<?php echo form_error('stok') ? ' error' : ''; ?>'>
                                        <?php echo form_label('Stok', 'stok', array('class' => '')); ?>
                                        <input type='number' class='form-control form-numeric' required name='stok'/>
                                        <span class='help-inline'><?php echo form_error('stok'); ?></span>
                                    </div>
                                </div>  

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= form_label('Tanggal Awal', 'tgl_awal', array('class' => 'control-label')); ?>
                                        <div class="input-group date read-datepicker" id="tgl_awal" data-target-input="nearest" readonly>
                                            <input type="text" name="tgl_awal" class="form-control datetimepicker-input" 
                                                data-target="#tgl_awal" required />
                                            <div class="input-group-append" data-target="#tgl_awal" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class='col-md-12'>
                                    <div class='form-group<?php echo form_error('desc') ? ' error' : ''; ?>'>
                                        <?php echo form_label('Deskripsi', 'desc', array('class' => '')); ?>
                                        <textarea name="desc" class='form-control'></textarea>
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
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="button" class="btn btn-success" id="add-attachment-row" style="float: right;">Tambah Foto</button>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="next-wrapper">
                                        <a href="<?= site_url('pembelian') ?>" class="btn btn-warning">Batal</a>
                                        <button type="submit" name="save" class="btn btn-primary">Simpan</button>
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
    $('#id_kategori').on('change', function(){
        var html = '';
        $.post("<?php echo base_url('pembelian/get_subkategori/'); ?>" + this.value, function (param) {
            param.forEach(function(val, i){
                html += '<option value="' + val.id + '">' + val.sub_kategori + '</option>';
            });
            $('#id_sub_kategori').html(html).trigger('chosen:updated').change();
        }, 'json');
    });

    $('#tgl_awal').datetimepicker({
        format: 'DD-MM-YYYY'
    });
  });
</script>