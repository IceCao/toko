<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $pageTitle ?? 'Title tidak tersedia.'; ?></title>
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap-5.0.2/dist/css/bootstrap.min.css">
    </head>
    <body>
        <?php echo $pageContent ?? 'Konten tidak tersedia.'; ?>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>