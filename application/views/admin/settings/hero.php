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
        <li class="nav-item"><a class="nav-link active" href="<?php echo base_url('admin/settings/hero'); ?>">Hero</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/sections'); ?>">Judul Section</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/stats'); ?>">Statistik</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/kontak'); ?>">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/sosmed'); ?>">Sosial Media</a></li>
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

            <p class="text-muted mb-4">Hero adalah banner besar di halaman depan website. Atur teks dan tombol yang muncul di sini.</p>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Label kecil (Eyebrow) <small class="text-muted">- teks kecil di atas judul</small></label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <input type="text" name="hero_eyebrow_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_eyebrow_' . $l]) ? $settings['hero_eyebrow_' . $l] : ''); ?>" />
                    <?php else: ?>
                    <div class="input-group">
                    <input type="text" name="hero_eyebrow_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_eyebrow_' . $l]) ? $settings['hero_eyebrow_' . $l] : ''); ?>" />
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="hero_eyebrow" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Judul Hero</label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <input type="text" name="hero_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_title_' . $l]) ? $settings['hero_title_' . $l] : ''); ?>" />
                    <?php else: ?>
                    <div class="input-group">
                    <input type="text" name="hero_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_title_' . $l]) ? $settings['hero_title_' . $l] : ''); ?>" />
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="hero_title" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Subtitle <small class="text-muted">- teks deskripsi di bawah judul</small></label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <input type="text" name="hero_subtitle_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_subtitle_' . $l]) ? $settings['hero_subtitle_' . $l] : ''); ?>" placeholder="Program studi pilihan tepat untuk masa depanmu" />
                    <?php else: ?>
                    <div class="input-group">
                    <input type="text" name="hero_subtitle_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_subtitle_' . $l]) ? $settings['hero_subtitle_' . $l] : ''); ?>" placeholder="Program studi pilihan tepat untuk masa depanmu" />
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="hero_subtitle" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Teks Tombol CTA</label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <input type="text" name="hero_cta_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_cta_text_' . $l]) ? $settings['hero_cta_text_' . $l] : ''); ?>" placeholder="Jelajahi Prodi" />
                    <?php else: ?>
                    <div class="input-group">
                    <input type="text" name="hero_cta_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_cta_text_' . $l]) ? $settings['hero_cta_text_' . $l] : ''); ?>" placeholder="Jelajahi Prodi" />
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="hero_cta_text" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">URL Tombol CTA</label>
                    <input type="text" name="hero_cta_link" class="form-control" value="<?php echo html_escape(isset($settings['hero_cta_link']) ? $settings['hero_cta_link'] : ''); ?>" placeholder="https://pmb.ucb.ac.id" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Teks Tombol Sekunder</label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <input type="text" name="hero_secondary_cta_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_secondary_cta_text_' . $l]) ? $settings['hero_secondary_cta_text_' . $l] : ''); ?>" placeholder="Tentang Kami" />
                    <?php else: ?>
                    <div class="input-group">
                    <input type="text" name="hero_secondary_cta_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_secondary_cta_text_' . $l]) ? $settings['hero_secondary_cta_text_' . $l] : ''); ?>" placeholder="Tentang Kami" />
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="hero_secondary_cta_text" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">URL Tombol Sekunder</label>
                    <input type="text" name="hero_secondary_cta_link" class="form-control" value="<?php echo html_escape(isset($settings['hero_secondary_cta_link']) ? $settings['hero_secondary_cta_link'] : ''); ?>" placeholder="https://ucb.ac.id/tentang-kami" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Gambar Background</label>
                    <input type="file" name="hero_background" class="form-control" accept="image/*" />
                    <small class="text-muted">Format: JPG / PNG, resolusi minimal 1920x600 px.</small>
                    <?php if (isset($settings['hero_background']) && $settings['hero_background']): ?>
                    <div class="mt-2"><img src="<?php echo base_url('uploads/' . html_escape($settings['hero_background'])); ?>" class="img-fluid rounded" style="max-height:150px" /></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Pengaturan</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>