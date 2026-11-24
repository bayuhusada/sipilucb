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
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/footer'); ?>">Footer</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?php echo base_url('admin/settings/lainnya'); ?>">Lainnya</a></li>
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

            <h6 class="fw-semibold mb-3">CTA Band (Halaman Depan)</h6>
            <p class="text-muted small">Banner ajakan di bagian bawah halaman depan, sebelum footer.</p>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Judul</label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <input type="text" name="cta_band_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['cta_band_title_' . $l]) ? $settings['cta_band_title_' . $l] : ''); ?>" />
                    <?php else: ?>
                    <div class="input-group">
                    <input type="text" name="cta_band_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['cta_band_title_' . $l]) ? $settings['cta_band_title_' . $l] : ''); ?>" />
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="cta_band_title" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Teks Deskripsi</label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <textarea name="cta_band_text_<?php echo $l; ?>" class="form-control" rows="2"><?php echo html_escape(isset($settings['cta_band_text_' . $l]) ? $settings['cta_band_text_' . $l] : ''); ?></textarea>
                    <?php else: ?>
                    <div class="input-group">
                    <textarea name="cta_band_text_<?php echo $l; ?>" class="form-control" rows="2"><?php echo html_escape(isset($settings['cta_band_text_' . $l]) ? $settings['cta_band_text_' . $l] : ''); ?></textarea>
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="cta_band_text" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Teks Tombol</label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <input type="text" name="cta_band_button_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['cta_band_button_text_' . $l]) ? $settings['cta_band_button_text_' . $l] : ''); ?>" />
                    <?php else: ?>
                    <div class="input-group">
                    <input type="text" name="cta_band_button_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['cta_band_button_text_' . $l]) ? $settings['cta_band_button_text_' . $l] : ''); ?>" />
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="cta_band_button_text" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">URL Tombol</label>
                    <input type="text" name="cta_band_button_link" class="form-control" value="<?php echo html_escape(isset($settings['cta_band_button_link']) ? $settings['cta_band_button_link'] : ''); ?>" placeholder="https://pmb.ucb.ac.id" />
                </div>
            </div>

            <h6 class="fw-semibold mb-3">Informasi Universitas</h6>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Universitas</label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <input type="text" name="university_name_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['university_name_' . $l]) ? $settings['university_name_' . $l] : ''); ?>" />
                    <?php else: ?>
                    <div class="input-group">
                    <input type="text" name="university_name_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['university_name_' . $l]) ? $settings['university_name_' . $l] : ''); ?>" />
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="university_name" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Deskripsi Universitas <small class="text-muted">- untuk footer &amp; meta tag</small></label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <textarea name="university_description_<?php echo $l; ?>" class="form-control" rows="3"><?php echo html_escape(isset($settings['university_description_' . $l]) ? $settings['university_description_' . $l] : ''); ?></textarea>
                    <?php else: ?>
                    <div class="input-group">
                    <textarea name="university_description_<?php echo $l; ?>" class="form-control" rows="3"><?php echo html_escape(isset($settings['university_description_' . $l]) ? $settings['university_description_' . $l] : ''); ?></textarea>
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="university_description" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Website Universitas</label>
                    <input type="text" name="university_url" class="form-control" value="<?php echo html_escape(isset($settings['university_url']) ? $settings['university_url'] : ''); ?>" placeholder="https://ucb.ac.id" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-check form-switch">
                        <input type="hidden" name="translator_enabled" value="0" />
                        <input type="checkbox" name="translator_enabled" value="1" class="form-check-input" id="translator_enabled" <?php echo isset($settings['translator_enabled']) && $settings['translator_enabled'] ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="translator_enabled">Aktifkan Translator Otomatis</label>
                        <small class="text-muted d-block">Jika dimatikan, proses auto-translate saat simpan data dilewati. Hanya input manual.</small>
                    </div>
                </div>
            </div>

            <h6 class="fw-semibold mt-4 mb-3">API Translator</h6>
            <p class="text-muted small">Gunakan LibreTranslate server lokal. Pastikan endpoint aktif.</p>
            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label">LibreTranslate Endpoint URL</label>
                    <input type="text" name="translator_endpoint_libre" class="form-control" value="" />
                </div>
                <div class="col-md-4">
                    <label class="form-label">API Key <small class="text-muted">(opsional)</small></label>
                    <input type="password" name="translator_api_key_libre" class="form-control" value="" placeholder="kosongkan jika tanpa auth" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <button type="button" class="btn btn-outline-secondary btn-test-translator">
                        <i class="bx bx-test-tube me-1"></i> Test Koneksi
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-check">
                        <input type="checkbox" name="maintenance_mode" value="1" class="form-check-input" id="maintenance_mode" <?php echo isset($settings['maintenance_mode']) && $settings['maintenance_mode'] ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="maintenance_mode">Mode Maintenance <small class="text-muted">- tampilkan halaman maintenance ke pengunjung</small></label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Pengaturan</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
