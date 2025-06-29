<!-- <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer> -->

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<script src="<?php echo base_url() ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/sparklines/sparkline.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script> -->
<script src="<?php echo base_url() ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/adminlte.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/js/demo.js"></script> -->
<!-- <script src="<?php echo base_url() ?>assets/js/pages/dashboard.js"></script> -->
<script>
  $(function () {
    $('.delete-me').on('click', function (e) {
      e.preventDefault();
      var form = $(this).closest('form');
      if (confirm('Apakah anda yakin menghapus data ini?')) {
        form.submit();
      }
    });

    const fileInput = document.getElementById('file_foto');
    const filePathInput = document.getElementById('file_path_foto');
    const attUrlSpan = document.getElementById('att_url_foto');
    const windowUrlBtn = document.getElementById('window_url_foto');

    function getUniqueTimestamp() {
      const now = new Date();
      return now.getFullYear().toString() +
        String(now.getMonth() + 1).padStart(2, '0') +
        String(now.getDate()).padStart(2, '0') +
        String(now.getHours()).padStart(2, '0') +
        String(now.getMinutes()).padStart(2, '0') +
        String(now.getSeconds()).padStart(2, '0');
    }

    
    $('#add-attachment-row').click(function () {
      addRow();
    });

    $('#attachment-wrapper').on('click', '.delete-row', function () {
      $(this).closest('tr').hide('slow', function () {
        $(this).remove();
      });
    });

    $('#attachment-wrapper').on('change', '.inputFile', function () {
      const fileInput = this;
      const file = fileInput.files[0];
      const count = $(fileInput).data('count');

      if (!file) return;

      const fileSizeMB = file.size / (1024 * 1024);
      if (fileSizeMB > 5) {
        alert('Ukuran file melebihi 5MB. Silakan pilih file yang lebih kecil.');
        $(fileInput).val('');
        $('#att_url_' + count).text('Belum ada file');
        $('#file_path_' + count).val('');
        $('#window_url_' + count).hide();
        return;
      }

      $('#att_url_' + count).text(file.name);

      const reader = new FileReader();
      reader.onload = function (e) {
        $('#file_path_' + count).val(e.target.result);
        $('#window_url_' + count).show();
      };
      reader.readAsDataURL(file);
    });

    $('#attachment-wrapper').on('click', '.btn-primary', function () {
      const id = $(this).attr('id').split('_')[2];
      const dataUrl = $('#file_path_' + id).val();

      if (dataUrl) {
        const newWindow = window.open('', '_blank');
        if (newWindow) {
          newWindow.document.write('<html><head><title>Preview Gambar</title></head><body>');
          newWindow.document.write('<img src="' + dataUrl + '" style="max-width:100%;">');
          newWindow.document.write('</body></html>');
          newWindow.document.close();
        } else {
          alert('Popup diblokir oleh browser. Silakan izinkan pop-up.');
        }
      }
    });

    function addRow() {
      const uniqueId = Date.now() + Math.floor(Math.random() * 1000);

      const html = `
        <tr>
          <td>
            <label class="uploader">
              <input type="file" name="files[]" id="inputFile${uniqueId}" data-count="${uniqueId}" class="inputFile" accept="image/*"> Get file
            </label><br>
            <button type="button" class="btn btn-danger delete-row">Hapus</button>
          </td>
          <td>
            <span class="badge badge-info" id="att_url_${uniqueId}">Belum ada file</span>
            <br><br>
            <button style="display: none" type="button" id="window_url_${uniqueId}" class="btn btn-primary">Lihat</button>
          </td>
        </tr>
      `;

      $('#attachment-wrapper tbody').append(html);
    }


    // fileInput.addEventListener('change', function () {
    //   const file = this.files[0];
    //   if (file) {
    //     const uniqueName = getUniqueTimestamp() + '.' + file.name.split('.').pop();
    //     filePathInput.value = URL.createObjectURL(file);
    //     attUrlSpan.textContent = uniqueName;
    //     windowUrlBtn.style.display = 'inline-block';
    //   } else {
    //     filePathInput.value = '';
    //     attUrlSpan.textContent = '';
    //     windowUrlBtn.style.display = 'none';
    //   }
    // });

    // windowUrlBtn.addEventListener('click', function () {
    //   const url = filePathInput.value;
    //   if (url) {
    //     window.open(url, '_blank');
    //   }
    // });
  });
</script>
</body>
</html>