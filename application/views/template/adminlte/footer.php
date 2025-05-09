<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/sparklines/sparkline.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
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

    fileInput.addEventListener('change', function () {
      const file = this.files[0];
      if (file) {
        const uniqueName = getUniqueTimestamp() + '.' + file.name.split('.').pop();
        filePathInput.value = URL.createObjectURL(file);
        attUrlSpan.textContent = uniqueName;
        windowUrlBtn.style.display = 'inline-block';
      } else {
        filePathInput.value = '';
        attUrlSpan.textContent = '';
        windowUrlBtn.style.display = 'none';
      }
    });

    windowUrlBtn.addEventListener('click', function () {
      const url = filePathInput.value;
      if (url) {
        window.open(url, '_blank');
      }
    });
  });
</script>
</body>
</html>