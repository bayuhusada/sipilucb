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
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/sosmed'); ?>">Sosial Media</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?php echo base_url('admin/settings/footer'); ?>">Footer</a></li>
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

            <p class="text-muted mb-4">Teks yang muncul di bagian bawah website.</p>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Copyright <small class="text-muted">- tahun &amp; hak cipta</small></label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <input type="text" name="footer_copyright_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['footer_copyright_' . $l]) ? $settings['footer_copyright_' . $l] : ''); ?>" placeholder="© 2026 Teknik Sipil - Universitas Citra Bangsa" />
                    <?php else: ?>
                    <div class="input-group">
                    <input type="text" name="footer_copyright_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['footer_copyright_' . $l]) ? $settings['footer_copyright_' . $l] : ''); ?>" placeholder="© 2026 Teknik Sipil - Universitas Citra Bangsa" />
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="footer_copyright" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Credit <small class="text-muted">- teks pengelola website</small></label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <input type="text" name="footer_credit_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['footer_credit_' . $l]) ? $settings['footer_credit_' . $l] : ''); ?>" placeholder="Dikelola oleh Tim Teknik Sipil" />
                    <?php else: ?>
                    <div class="input-group">
                    <input type="text" name="footer_credit_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['footer_credit_' . $l]) ? $settings['footer_credit_' . $l] : ''); ?>" placeholder="Dikelola oleh Tim Teknik Sipil" />
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="footer_credit" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Pengaturan</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>