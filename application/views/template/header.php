<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title><?php echo isset($title) ? html_escape($title) . ' | ' : ''; ?>Teknik Sipil - Universitas Citra Bangsa</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <?php
    $_ci =& get_instance();
    if (!isset($_ci->setting_model)) { $_ci->load->model('setting_model'); }
    $fav = $_ci->setting_model->get('site_favicon');
    if (!$fav) { $fav = $_ci->setting_model->get('site_logo'); }
    $fav_url = $fav ? base_url('uploads/' . html_escape($fav)) : base_url('assets/sneat') . '/assets/img/favicon/favicon.ico';
    $fav_type = ($fav && preg_match('/\.(png|jpe?g|gif|webp)$/i', $fav)) ? 'image/png' : 'image/x-icon';
    ?>
    <link rel="icon" type="<?php echo $fav_type; ?>" href="<?php echo $fav_url; ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?php echo base_url('assets/sneat')?>/assets/vendor/fonts/boxicons.min.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/sneat')?>/assets/vendor/css/core.min.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/sneat')?>/assets/vendor/css/theme-default.min.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/sneat')?>/assets/css/demo.min.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.min.css" />

    <link rel="stylesheet" href="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/apex-charts/apex-charts.min.css" />
		<link rel="stylesheet" href="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/sweetalert/sweetalert2.min.css" />
		<link rel="stylesheet" href="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/data-tables/datatables.min.css" />
	<link rel="stylesheet" href="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/summernote/summernote-lite.min.css" />
		
		


    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?php echo base_url('assets/sneat')?>/assets/vendor/js/helpers.min.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php echo base_url('assets/sneat')?>/assets/js/config.min.js"></script>
    <!-- jQuery (loaded early for inline scripts) -->
    <script src="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/jquery/jquery.min.js"></script>
  </head>

  <body>
