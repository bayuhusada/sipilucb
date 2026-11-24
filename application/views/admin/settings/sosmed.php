<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Pengaturan Website</h4>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <ul class="nav nav-pills mb-4">
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/umum'); ?>">Informasi Umum</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/hero'); ?>">Hero</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/sections'); ?>">Judul Section</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/stats'); ?>">Statistik</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/kontak'); ?>">Kontak</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?php echo base_url('admin/settings/sosmed'); ?>">Sosial Media</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/footer'); ?>">Footer</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/lainnya'); ?>">Lainnya</a></li>
    </ul>

    <div class="card">
        <div class="card-body">
            <?php echo form_open_multipart(''); ?>

            <?php if (!empty($translatable_fields)): ?>
            <div class="mb-3">
                <button type="button" class="btn btn-info btn-translate-all" data-fields='<?php echo json_encode($translatable_fields); ?>'>
                    🌐 Terjemahkan Semua ke EN, CN, DE &amp; JA
                </button>
                <small class="text-muted ms-2">Menerjemahkan semua field dari Bahasa Indonesia</small>
            </div>
            <?php endif; ?>

            <p class="text-muted mb-4">Link sosial media yang muncul di footer. Kosongkan jika tidak punya.</p>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label"><i class="bx bxl-facebook me-1"></i> Facebook</label>
                    <input type="text" name="social_facebook" class="form-control" value="<?php echo html_escape(isset($settings['social_facebook']) ? $settings['social_facebook'] : ''); ?>" placeholder="https://facebook.com/..." />
                </div>
                <div class="col-md-4">
                    <label class="form-label"><i class="bx bxl-instagram me-1"></i> Instagram</label>
                    <input type="text" name="social_instagram" class="form-control" value="<?php echo html_escape(isset($settings['social_instagram']) ? $settings['social_instagram'] : ''); ?>" placeholder="https://instagram.com/..." />
                </div>
                <div class="col-md-4">
                    <label class="form-label"><i class="bx bxl-youtube me-1"></i> YouTube</label>
                    <input type="text" name="social_youtube" class="form-control" value="<?php echo html_escape(isset($settings['social_youtube']) ? $settings['social_youtube'] : ''); ?>" placeholder="https://youtube.com/..." />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label"><i class="bx bxl-twitter me-1"></i> Twitter / X</label>
                    <input type="text" name="social_twitter" class="form-control" value="<?php echo html_escape(isset($settings['social_twitter']) ? $settings['social_twitter'] : ''); ?>" />
                </div>
                <div class="col-md-4">
                    <label class="form-label"><i class="bx bxl-tiktok me-1"></i> TikTok</label>
                    <input type="text" name="social_tiktok" class="form-control" value="<?php echo html_escape(isset($settings['social_tiktok']) ? $settings['social_tiktok'] : ''); ?>" />
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Pengaturan</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
