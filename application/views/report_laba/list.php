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
                        <div class="form-group">
                            <div class="input-group date read-datepicker" data-target-input="nearest">
                                <input type="text" class="form-control" id="tanggal" value="<?= date('Y-m-d') ?>" data-target="#tanggal"/>
                                <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <h5>Sampai</h5>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date read-datepicker" data-target-input="nearest">
                                <input type="text" class="form-control" id="tanggal_ke" value="<?= date('Y-m-d') ?>" data-target="#tanggal_ke"/>
                                <div class="input-group-append" data-target="#tanggal_ke" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
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
                    <table id="labaList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Kategori</th>
                                <th>Sub kategori</th>
                                <th>Harga beli</th>
                                <th>Harga jual</th>
                                <th>Laba</th>
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
    var dates = $('#tanggal').val();
    var dates_to = $('#tanggal_ke').val();
    var kategori = $('#kategori').val();
    var kategorisub = $('#subkategori').val();
    var total = 0;

    $("#labaList").DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo base_url('report_laba/get_data/'); ?>" + dates + '/' + dates_to + '/' + kategori + '/' + kategorisub,
            "type": "POST"
        },
        "columns": [
            { "data": "tgl_jual" },
            { "data": "nama_kategori" },
            { "data": "sub_kategori" },
            { "data": "harga_awal" },
            { "data": "harga_jual" },
            { "data": "laba" },
        ],
        drawCallback: function (settings) {
            total = settings.json?.total;
            $('tbody').append(`
            <tr role="row" class="" style="font-weight:bold">
                <td colspan="5" class="text-center" style="font-weight:bold">TOTAL</td>
                <td style="font-weight:bold">${formatRupiah(parseInt(total))}</td>
            </tr>`);
        },
        "rowCallback": function (row, data) {
            $('td:eq(3)', row).html(formatRupiah(data.harga_awal));
            $('td:eq(4)', row).html(formatRupiah(data.harga_jual));
            $('td:eq(5)', row).html(formatRupiah(data.laba));
        },
        searching: false,
        paging: false,
        lengthChange: false,
        serverSide: false,
        info:false,
    });

    $('#tanggal').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $("#tanggal").on("change.datetimepicker", ({ date, oldDate }) => {
        dates = $('#tanggal').val();
        show_list();
    });
    
    $('#tanggal_ke').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    
    $("#tanggal_ke").on("change.datetimepicker", ({ date, oldDate }) => {
        date_to = $('#tanggal_ke').val();
        show_list();
    });

    $('#kategori').on('change', function(){
        kategori = this.value;
        var html = '<option value="000">SEMUA</option>';
        $.post("<?php echo base_url('report_laba/get_subkategori/') ?>" + this.value, function (param) {
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
        $('#labaList').DataTable()
            .ajax.url(
                "<?php echo base_url('report_laba/get_data/'); ?>" + dates + '/' + dates_to + '/' + kategori + '/' + kategorisub
            )
        .load(function(json){
            total = json.recordsTotal;
        });
    }
    
    $('#print_exc').on('click', function () {
        let filter = btoa(dates + '/' + dates_to + '/' + kategori + '/' + kategorisub).replace(/=/g, '');

        Swal.fire({
            title: 'Memproses Data',
            text: 'Mohon Menunggu',
            imageUrl: "<?php echo base_url() ?>" + 'assets/images/blue_loading.gif',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                window.open("<?php echo base_url('report_laba/print_exc/') ?>" + filter, '_blank');
                Swal.close(); // tutup swal
            }
        });
    });
    
    $('#print_doc').on('click', function () {
        let filter = btoa(dates + '/' + dates_to + '/' + kategori + '/' + kategorisub).replace(/=/g, '');

        Swal.fire({
            title: 'Memproses Data',
            text: 'Mohon Menunggu',
            imageUrl: "<?php echo base_url() ?>" + 'assets/images/blue_loading.gif',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                window.open("<?php echo base_url('report_laba/print_doc/') ?>" + filter, '_blank');
                Swal.close(); // tutup swal
            }
        });
    });

  });
</script>
