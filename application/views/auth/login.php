<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>Login | Teknik Sipil - Universitas Citra Bangsa</title>
    <?php
    $_ci =& get_instance();
    if (!isset($_ci->setting_model)) { $_ci->load->model('setting_model'); }
    $fav = $_ci->setting_model->get('site_favicon');
    if (!$fav) { $fav = $_ci->setting_model->get('site_logo'); }
    $fav_url = $fav ? base_url('uploads/' . html_escape($fav)) : base_url('assets/sneat/assets/img/favicon/favicon.ico');
    $fav_type = ($fav && preg_match('/\.(png|jpe?g|gif|webp)$/i', $fav)) ? 'image/png' : 'image/x-icon';
    ?>
    <link rel="icon" type="<?php echo $fav_type; ?>" href="<?php echo $fav_url; ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('assets/sneat/assets/vendor/fonts/boxicons.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/sneat/assets/vendor/css/core.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/sneat/assets/vendor/css/theme-default.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/sneat/assets/css/demo.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')?>" />
    <script src="<?php echo base_url('assets/sneat/assets/vendor/js/helpers.js')?>"></script>
    <script src="<?php echo base_url('assets/sneat/assets/js/config.js')?>"></script>
    <style>
        body { background: #f5f5f9; }
        .authentication-wrapper { display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card { box-shadow: 0 2px 6px 0 rgba(67,89,113,.12); }
    </style>
</head>
<body>
    <div class="authentication-wrapper">
        <div class="authentication-inner">
            <div class="card" style="width: 28rem;">
                <div class="card-body px-5 py-4">
                    <div class="text-center mb-4">
                        <h4 class="mb-1">Teknik Sipil</h4>
                        <p class="mb-4">Fakultas Teknik</p>
                    </div>

                    <?php echo form_open('auth/login'); ?>
                        <div class="mb-3">
                            <label class="form-label">Username / Email</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan username atau email" required autofocus />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                                <span class="input-group-text cursor-pointer" id="togglePassword">
                                    <i class="bx bx-hide"></i>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100">Masuk</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url('assets/sneat/assets/vendor/libs/jquery/jquery.js')?>"></script>
    <script src="<?php echo base_url('assets/sneat/assets/vendor/libs/popper/popper.js')?>"></script>
    <script src="<?php echo base_url('assets/sneat/assets/vendor/js/bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')?>"></script>
    <script src="<?php echo base_url('assets/sneat/assets/vendor/js/menu.js')?>"></script>
    <script src="<?php echo base_url('assets/sneat/assets/vendor/libs/sweetalert/sweetalert2.all.min.js')?>"></script>
    <script src="<?php echo base_url('assets/sneat/assets/js/main.js')?>"></script>
    <script>
    <?php if ($msg = $this->session->flashdata('error')): ?>
    Swal.fire({
        icon: 'error',
        title: '<?php echo str_replace(array("\\", "'", "\r", "\n"), array("\\\\", "\\'", "", ""), html_escape($msg)); ?>',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    <?php endif; ?>
    </script>
</body>
</html>
