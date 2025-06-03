<div class="row pt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Setting harga jual</h3>
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
                    <table id="hargajualList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Sub kategori</th>
                                <!-- <th>Gudang</th> -->
                                <th>Harga jual</th>
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
    const debounceKeyUp = debounce(kirimHargaKeServer, 1000);

    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), delay);
        };
    }

    function kirimHargaKeServer(kategori, kategori_sub) {
        var harga_jual = $('#hargajual-' + kategori + '-' + kategori_sub).val();
        $.post("<?php echo site_url('hargajual/update_hargajual/') ?>" + kategori + '/' + kategori_sub, { harga: harga_jual }, function (data) {
            if (!data.success) {
                Swal.fire('error', data.message, 'error');
            }
        }, "json");
    }

    $("#hargajualList").DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo base_url('hargajual/get_data'); ?>",
            "type": "POST"
        },
        "columns": [
            { "data": "nama_kategori" },
            { "data": "sub_kategori" },
            { "data": "id_kategori" }, // akan diganti di rowCallback
        ],
        "rowCallback": function (row, data) {
            var input = $('<input>', {
                type: 'number',
                class: 'form-control form-numeric',
                id: 'hargajual-' + data.id_kategori + '-' + data.id_sub_kategori,
                val: data.harga_jual
            });

            input.on('keyup', debounce(function () {
                kirimHargaKeServer(data.id_kategori, data.id_sub_kategori);
            }, 1000));

            $('td:eq(2)', row).html(input);
        },
    });
  });
</script>
