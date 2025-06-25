<div class="row pt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
					<div class="col-sm-10">
                        <h3 class="card-title">Report laba</h3>
					</div>
					<div class="col-sm-2">
                        <a class="btn btn-success float-right" id="print_exc">Excel</a>
                        <a class="btn btn-primary float-right" id="print_doc">Pdf</a>
					</div>
				</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <select name="gudang" id="gudang" class="form-control">
                            <option value="000">SEMUA</option>
                            <?php foreach($gudang as $val) : ?>
                                <option value="<?= $val->id_gudang ?>"><?= $val->nama_gudang ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="kategori" id="kategori" class="form-control">
                            <option value="000">SEMUA</option>
                            <?php foreach($kategori as $val) : ?>
                                <option value="<?= $val->id_kategori ?>"><?= $val->nama_kategori ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="subkategori" id="subkategori" class="form-control">
                            <option value="000">SEMUA</option>
                        </select>
                    </div>
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
                    <table id="barangList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Gudang</th>
                                <th>Kategori</th>
                                <th>Sub kategori</th>
                                <th>Stok</th>
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
    var gudang = $('#gudang').val();
    var kategori = $('#kategori').val();
    var kategorisub = $('#subkategori').val();

    $("#barangList").DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo base_url('report_barang/get_data/'); ?>" + gudang + '/' + kategori + '/' + kategorisub,
            "type": "POST"
        },
        "columns": [
            { "data": "nama_gudang" },
            { "data": "nama_kategori" },
            { "data": "sub_kategori" },
            { "data": "total_stok" },
        ],
        drawCallback: function (settings) {
        },
        "rowCallback": function (row, data) {
        },
        searching: false,
        paging: false,
        lengthChange: false,
        serverSide: false,
        info:false,
    });

    $('#gudang').on('change', function(){
        gudang = this.value;
        show_list();
    })

    $('#kategori').on('change', function(){
        kategori = this.value;
        var html = '<option value="000">SEMUA</option>';
        $.post("<?php echo base_url('report_barang/get_subkategori/') ?>" + this.value, function (param) {
            param.forEach(function(val, i){
                html += '<option value="' + val.id_sub_kategori + '">' + val.sub_kategori + '</option>';
            });
            $('#subkategori').html(html).trigger('chosen:updated').change();
        }, 'json');
    });

    $('#subkategori').on('change', function(){
        kategorisub = this.value;
        show_list();
    })
    
    function show_list(){
        $('#barangList').DataTable()
            .ajax.url(
                "<?php echo base_url('report_barang/get_data/'); ?>" + gudang + '/' + kategori + '/' + kategorisub
            )
        .load(function(json){
        });
    }
    
    $('#print_exc').on('click', function () {
        let filter = btoa(gudang + '/' + kategori + '/' + kategorisub).replace(/=/g, '');

        Swal.fire({
            title: 'Memproses Data',
            text: 'Mohon Menunggu',
            imageUrl: "<?php echo base_url() ?>" + 'assets/images/blue_loading.gif',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                window.open("<?php echo base_url('report_barang/print_exc/') ?>" + filter, '_blank');
                Swal.close(); // tutup swal
            }
        });
    });
    
    $('#print_doc').on('click', function () {
        let filter = btoa(gudang + '/' + kategori + '/' + kategorisub).replace(/=/g, '');

        Swal.fire({
            title: 'Memproses Data',
            text: 'Mohon Menunggu',
            imageUrl: "<?php echo base_url() ?>" + 'assets/images/blue_loading.gif',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                window.open("<?php echo base_url('report_barang/print_doc/') ?>" + filter, '_blank');
                Swal.close(); // tutup swal
            }
        });
    });

  });
</script>
