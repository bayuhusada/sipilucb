<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Pengaturan Website</h4>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <ul class="nav nav-pills mb-4">
        <li class="nav-item"><a class="nav-link active" href="<?php echo base_url('admin/settings/umum'); ?>">Informasi Umum</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/hero'); ?>">Hero</a></li>
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

            <p class="text-muted mb-4">Informasi dasar tentang website Program Studi Teknik Sipil.</p>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Website <small class="text-muted">- tampil di navbar &amp; tab browser</small></label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <input type="text" name="site_name_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['site_name_' . $l]) ? $settings['site_name_' . $l] : ''); ?>" />
                    <?php else: ?>
                    <div class="input-group">
                    <input type="text" name="site_name_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['site_name_' . $l]) ? $settings['site_name_' . $l] : ''); ?>" />
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="site_name" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Deskripsi Website <small class="text-muted">- untuk SEO &amp; meta tag</small></label>
                    <?php echo lang_tabs(); ?>
                    <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                    <?php echo lang_tab_pane($l, $i === 0); ?>
                    <?php if ($l === 'id'): ?>
                    <textarea name="site_description_<?php echo $l; ?>" class="form-control" rows="2"><?php echo html_escape(isset($settings['site_description_' . $l]) ? $settings['site_description_' . $l] : ''); ?></textarea>
                    <?php else: ?>
                    <div class="input-group">
                        <textarea name="site_description_<?php echo $l; ?>" class="form-control" rows="2"><?php echo html_escape(isset($settings['site_description_' . $l]) ? $settings['site_description_' . $l] : ''); ?></textarea>
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="site_description" data-target="<?php echo $l; ?>">🤖</button>
                    </div>
                    <?php endif; ?>
                    <?php echo lang_tab_end(); ?>
                    <?php endforeach; ?>
                    <?php echo lang_tabs_end(); ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Logo Website</label>
                    <input type="file" name="site_logo" class="form-control" accept="image/*" />
                    <small class="text-muted">Format: PNG / JPG. Maks 2 MB.</small>
                    <?php if (isset($settings['site_logo']) && $settings['site_logo']): ?>
                        <div class="mt-2"><img src="<?php echo base_url('uploads/' . html_escape($settings['site_logo'])); ?>" height="40" /></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Favicon <small class="text-muted">- ikon di tab browser</small></label>
                    <input type="file" name="site_favicon" class="form-control" accept="image/*" />
                    <small class="text-muted">Format: ICO / PNG, ukuran 32x32 px.</small>
                    <?php if (isset($settings['site_favicon']) && $settings['site_favicon']): ?>
                        <div class="mt-2"><img src="<?php echo base_url('uploads/' . html_escape($settings['site_favicon'])); ?>" height="32" /></div>
                    <?php endif; ?>
                </div>
            </div>

            <h6 class="fw-semibold mt-4 mb-3">Kontak Program Studi</h6>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="site_email" class="form-control" value="<?php echo html_escape(isset($settings['site_email']) ? $settings['site_email'] : ''); ?>" placeholder="tekniksipil@ucb.ac.id" />
                </div>
                <div class="col-md-4">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="site_phone" class="form-control" value="<?php echo html_escape(isset($settings['site_phone']) ? $settings['site_phone'] : ''); ?>" placeholder="(+62) 361 234567" />
                </div>
                <div class="col-md-4">
                    <label class="form-label">WhatsApp <small class="text-muted">- nomer dengan kode negara, tanpa +</small></label>
                    <input type="text" name="site_whatsapp" class="form-control" value="<?php echo html_escape(isset($settings['site_whatsapp']) ? $settings['site_whatsapp'] : ''); ?>" placeholder="628123456789" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Alamat Kampus</label>
                    <textarea name="site_address" class="form-control" rows="2"><?php echo html_escape(isset($settings['site_address']) ? $settings['site_address'] : ''); ?></textarea>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Pengaturan</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>