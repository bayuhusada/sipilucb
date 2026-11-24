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
        <li class="nav-item"><a class="nav-link active" href="<?php echo base_url('admin/settings/kontak'); ?>">Kontak</a></li>
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

            <p class="text-muted mb-4">Label-label pada form kontak dan informasi kontak yang tampil di halaman Kontak.</p>
            <h6 class="fw-semibold mb-3">Label Form Kontak</h6>
            <div class="row mb-3">
                <div class="col-md-4"><label class="form-label">Nama</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="contact_label_name_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_name_' . $l]) ? $settings['contact_label_name_' . $l] : ''); ?>" /><?php else: ?><div class="input-group"><input type="text" name="contact_label_name_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_name_' . $l]) ? $settings['contact_label_name_' . $l] : ''); ?>" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="contact_label_name" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                <div class="col-md-4"><label class="form-label">Email</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="contact_label_email_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_email_' . $l]) ? $settings['contact_label_email_' . $l] : ''); ?>" /><?php else: ?><div class="input-group"><input type="text" name="contact_label_email_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_email_' . $l]) ? $settings['contact_label_email_' . $l] : ''); ?>" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="contact_label_email" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                <div class="col-md-4"><label class="form-label">Subjek</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="contact_label_subject_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_subject_' . $l]) ? $settings['contact_label_subject_' . $l] : ''); ?>" /><?php else: ?><div class="input-group"><input type="text" name="contact_label_subject_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_subject_' . $l]) ? $settings['contact_label_subject_' . $l] : ''); ?>" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="contact_label_subject" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label class="form-label">Pesan</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="contact_label_message_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_message_' . $l]) ? $settings['contact_label_message_' . $l] : ''); ?>" /><?php else: ?><div class="input-group"><input type="text" name="contact_label_message_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_message_' . $l]) ? $settings['contact_label_message_' . $l] : ''); ?>" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="contact_label_message" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                <div class="col-md-4"><label class="form-label">Tombol Kirim</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="contact_label_submit_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_submit_' . $l]) ? $settings['contact_label_submit_' . $l] : ''); ?>" /><?php else: ?><div class="input-group"><input type="text" name="contact_label_submit_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_submit_' . $l]) ? $settings['contact_label_submit_' . $l] : ''); ?>" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="contact_label_submit" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
            </div>

            <h6 class="fw-semibold mb-3 mt-4">Informasi Kontak <small class="text-muted">- tampil di samping form kontak</small></h6>
            <div class="row mb-3">
                <div class="col-md-4"><label class="form-label">Heading</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="contact_info_heading_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_info_heading_' . $l]) ? $settings['contact_info_heading_' . $l] : ''); ?>" /><?php else: ?><div class="input-group"><input type="text" name="contact_info_heading_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_info_heading_' . $l]) ? $settings['contact_info_heading_' . $l] : ''); ?>" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="contact_info_heading" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                <div class="col-md-4"><label class="form-label">Label Alamat</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="contact_address_label_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_address_label_' . $l]) ? $settings['contact_address_label_' . $l] : ''); ?>" /><?php else: ?><div class="input-group"><input type="text" name="contact_address_label_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_address_label_' . $l]) ? $settings['contact_address_label_' . $l] : ''); ?>" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="contact_address_label" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                <div class="col-md-4"><label class="form-label">Label Telepon</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="contact_phone_label_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_phone_label_' . $l]) ? $settings['contact_phone_label_' . $l] : ''); ?>" /><?php else: ?><div class="input-group"><input type="text" name="contact_phone_label_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_phone_label_' . $l]) ? $settings['contact_phone_label_' . $l] : ''); ?>" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="contact_phone_label" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label class="form-label">Label Email</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="contact_email_label_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_email_label_' . $l]) ? $settings['contact_email_label_' . $l] : ''); ?>" /><?php else: ?><div class="input-group"><input type="text" name="contact_email_label_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_email_label_' . $l]) ? $settings['contact_email_label_' . $l] : ''); ?>" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="contact_email_label" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Google Maps Embed URL</label>
                    <textarea name="contact_map_url" class="form-control" rows="2" placeholder="https://www.google.com/maps/embed?pb=..."><?php echo html_escape(isset($settings['contact_map_url']) ? $settings['contact_map_url'] : ''); ?></textarea>
                    <small class="text-muted">Dapatkan URL embed dari Google Maps -&gt; Bagikan -&gt; Embed.</small>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Pengaturan</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>