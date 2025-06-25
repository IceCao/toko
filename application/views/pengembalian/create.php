<?php echo form_open($this->uri->uri_string(), 'class=""'); ?>
    <div class='box admin-box box-info pt-3'>
        <div class='box-header with-border'>
            <h3 class='box-title'>Pengembalian</h3>
        </div>
        <div class='box-body'>
            <div id="accordion">
                <div class="card">
                    <div class="card-header alert alert-success" id="headingOne">
                        <h5 class="mb-0">
                            Data Pengembalian
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
                                                                <th>Aksi</th>
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
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <div class="btn btn-primary float-right" id="pilih">Pilih</div>
                                        </div>
                                    </div>
                                    
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Pengembalian</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="hidden" id="total_harga" name="total_harga" value="">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover form-table" id="list_pengembalian_table" style="table-layout:fixed;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Aksi</th>
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
                                                </div>

                                                <div class="col-md-12">
                                                    <p class="float-right" id="total-harga">Total Harga : Rp 0</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= form_label('Tanggal pengembalian', 'tgl_return', array('class' => 'control-label')); ?>
                                        <div class="input-group date read-datepicker" id="tgl_return" data-target-input="nearest" readonly>
                                            <input type="text" name="tgl_return" class="form-control datetimepicker-input" 
                                                data-target="#tgl_return" required />
                                            <div class="input-group-append" data-target="#tgl_return" data-toggle="datetimepicker">
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
                                
                                <div class="col-md-12">
                                    <div class="next-wrapper">
                                        <a href="<?= site_url('pengembalian') ?>" class="btn btn-warning">Batal</a>
                                        <button type="submit" name="save" id="simpan" class="btn btn-primary">Simpan</button>
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
        $('#tgl_return').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        
        var checkedIds = [];
        $("#list_produk_table").DataTable({
            "processing": true,
            "ajax": {
                "url": "<?php echo base_url('pengembalian/get_produk'); ?>",
                "type": "POST"
            },
            "columns": [
                { data: 'total_stok' },
                { data: 'nama_kategori' },
                { data: 'sub_kategori' },
                { data: 'nama_gudang' },
                { data: 'harga_jual' },
                { data: 'total_stok' },
                { data: 'total_harga' },
            ],
            "rowCallback": function (row, data) {
                var checked = '';
                var params = data.id_kategori + '/' + data.id_sub_kategori + '/' + data.id_gudang;
                if (checkedIds.includes(params.toString())) {
                    checked = 'checked';
                }

                $('td:eq(0)', row).html('<input type="checkbox" name="produk[]" id="produk" class="large-checkbox produk" data-id="'+ params +'" value="'+ data.sub_kategori +'" '+ checked +'>');
            },
        });

        $('#list_produk_table').on('change', '.produk', function() {
            var id = $(this).data('id').toString();
            if ($(this).is(':checked')) {
                if (!checkedIds.includes(id)) {
                    checkedIds.push(id);
                }
            } else {
                checkedIds = checkedIds.filter(function(item) {
                    return item !== id;
                });
            }
        });

        window.gantiHarga = function(kategori, kategori_sub, gudang) {
            var harga_jual  = $('#hargajual-' + kategori + '-' + kategori_sub + '-' + gudang).val();
            var stok        = $('#stokjual-' + kategori + '-' + kategori_sub + '-' + gudang).val();
            var total_harga = stok * harga_jual;

            $('#totaljual-' + kategori + '-' + kategori_sub + '-' + gudang).val(total_harga);

            hitungTotalHarga();
        };

        function hitungTotalHarga() {
            var total = 0;
            $('#list_pengembalian_table .total_harga').each(function () {
                var value = parseFloat($(this).val()) || 0;
                total += value;
            });
            $('#total-harga').html('Total Harga : Rp ' + total);
            $('#total_harga').val(total);
            
        }


        $('#pilih').on('click',function(){
            Swal.fire({
                title: 'Memproses Data',
                text: 'Mohon Tunggu Sebentar',
                imageUrl: "<?php echo base_url(); ?>" + 'assets/img/blue_loading.gif',
                showConfirmButton: false,
                allowOutsideClick: false
            });

            if(checkedIds.length < 1){
                Swal.fire("Warning", "Mohon pilih data yang tersedia", "warning");
                return false;
            }

            $.post("<?php echo base_url('pengembalian/transfer_data'); ?>", { 'produk[]': checkedIds }, function(data){
                swal.close();
                $('#list_pengembalian_table tbody').html('');

                var html = '';
                var action = 0;
                data.produk.forEach(function (val, i) {
                    html += '<tr id="'+ i +'">' +
                        '<td>' +
                            '<button type="button" class="btn btn-danger hapus-btn" style="margin-right: 10px; margin-top: 5px;">Hapus</button>' +
                        '</td>' +
                        '<td>' +
                            '<input type="hidden" name="id_kategori[]" class="form-control" value="' + val.id_kategori + '" readonly>' +
                            '<input type="text" name="nama_kategori[]" class="form-control" value="' + val.nama_kategori + '" readonly>' +
                        '</td>' +
                        '<td>' +
                            '<input type="hidden" name="id_sub_kategori[]" class="form-control" value="' + val.id_sub_kategori + '" readonly>' +
                            '<input type="text" name="nama[]" class="form-control" value="' + val.sub_kategori + '" readonly>' +
                        '</td>' +
                        '<td>' +
                            '<input type="hidden" name="id_gudang[]" class="form-control" value="' + val.id_gudang + '" readonly>' +
                            '<input type="text" name="nama_gudang[]" class="form-control" value="' + val.nama_gudang + '" readonly>' +
                        '</td>' +
                        '<td>' +
                            '<input type="text" name="harga_jual[]" class="form-control" id="hargajual-' + val.id_kategori + "-" + val.id_sub_kategori + "-" + val.id_gudang +'" value="' + val.harga_jual + '" readonly>' +
                        '</td>' +
                        '<td>' +
                            '<input type="number" name="stok[]" class="form-control form-numeric" id="stokjual-' + val.id_kategori + "-" + val.id_sub_kategori + "-" + val.id_gudang +'" onkeyup="gantiHarga(' + val.id_kategori + ", " + val.id_sub_kategori + ", " + val.id_gudang + ')" value="' + val.total_stok + '" min="1" max="' + val.total_stok + '">' +
                        '</td>' +
                        '<td>' +
                            '<input type="text" name="total_harga[]" class="form-control total_harga" id="totaljual-' + val.id_kategori + "-" + val.id_sub_kategori + "-" + val.id_gudang + '" value="' + val.total_harga + '" readonly>' +
                        '</td>' +
                    '</tr>';

                    if(val.total_stok <= 0){
                        action = 1;
                    }
                });

                if(action == 0){
                    $('#list_pengembalian_table').append(html);
                    $('#total_harga').val(data.total_harga);
                    $('#total-harga').html('Total Harga : Rp ' + data.total_harga);
                } else {
                    Swal.fire("Warning", "Produk yang anda pilih stok 0, mohon tidak memilih produk tersebut.", "warning");
                }
            },'json');
        });

        $('#list_pengembalian_table').on('click', '.hapus-btn', function () {
            $(this).closest('tr').remove();
            hitungTotalHarga();
        });

        $('#simpan').on('click', function () {
            if($('#list_pengembalian_table > tbody > tr').length < 1){
                Swal.fire("Warning", "Data kosong, mohon pilih data yang tersedia terlebih dahulu", "warning");
                return false;
            }
            return true;
        });
    });
</script>
