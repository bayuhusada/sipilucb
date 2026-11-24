<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Program Unggulan</h4>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <?php echo form_open(''); ?>

            <p class="text-muted">6 program unggulan yang ditampilkan di halaman depan. Masing-masing punya judul dan deskripsi singkat dalam 5 bahasa.</p>

            <div class="mb-3">
                <button type="button" class="btn btn-info btn-translate-all" data-fields='["feature_1_title","feature_1_desc","feature_2_title","feature_2_desc","feature_3_title","feature_3_desc","feature_4_title","feature_4_desc","feature_5_title","feature_5_desc","feature_6_title","feature_6_desc"]'>
                    🌐 Terjemahkan Semua ke EN, CN, DE &amp; JA
                </button>
                <small class="text-muted ms-2">Menerjemahkan semua field dari Bahasa Indonesia</small>
            </div>

            <?php for ($i = 1; $i <= 6; $i++): ?>
            <div class="border rounded p-3 mb-3">
                <h6 class="fw-semibold mb-1">Item <?php echo $i; ?></h6>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="form-label">Icon</label>
                        <select name="feature_<?php echo $i; ?>_icon" class="form-select feature-icon-select" onchange="var s=this;var p=s.parentElement.nextElementSibling;if(p)p.innerHTML=s.options[s.selectedIndex].getAttribute('data-icon')||''">
                            <?php echo feature_icon_options(isset($settings['feature_' . $i . '_icon']) ? $settings['feature_' . $i . '_icon'] : ''); ?>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-center pt-3 icon-preview"><?php echo feature_icon_svg(isset($settings['feature_' . $i . '_icon']) && $settings['feature_' . $i . '_icon'] ? $settings['feature_' . $i . '_icon'] : 'book'); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Judul</label>
                        <?php echo lang_tabs(); ?>
                        <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $li => $l): ?>
                        <?php echo lang_tab_pane($l, $li === 0); ?>
                        <?php if ($l === 'id'): ?>
                        <input type="text" name="feature_<?php echo $i; ?>_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['feature_' . $i . '_title_' . $l]) ? $settings['feature_' . $i . '_title_' . $l] : ''); ?>" />
                        <?php else: ?>
                        <div class="input-group">
                        <input type="text" name="feature_<?php echo $i; ?>_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['feature_' . $i . '_title_' . $l]) ? $settings['feature_' . $i . '_title_' . $l] : ''); ?>" />
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="feature_<?php echo $i; ?>_title" data-target="<?php echo $l; ?>">🤖</button>
                        </div>
                        <?php endif; ?>
                        <?php echo lang_tab_end(); ?>
                        <?php endforeach; ?>
                        <?php echo lang_tabs_end(); ?>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Deskripsi</label>
                        <?php echo lang_tabs(); ?>
                        <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $li => $l): ?>
                        <?php echo lang_tab_pane($l, $li === 0); ?>
                        <?php if ($l === 'id'): ?>
                        <textarea name="feature_<?php echo $i; ?>_desc_<?php echo $l; ?>" class="form-control" rows="2"><?php echo html_escape(isset($settings['feature_' . $i . '_desc_' . $l]) ? $settings['feature_' . $i . '_desc_' . $l] : ''); ?></textarea>
                        <?php else: ?>
                        <div class="input-group">
                        <textarea name="feature_<?php echo $i; ?>_desc_<?php echo $l; ?>" class="form-control" rows="2"><?php echo html_escape(isset($settings['feature_' . $i . '_desc_' . $l]) ? $settings['feature_' . $i . '_desc_' . $l] : ''); ?></textarea>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="feature_<?php echo $i; ?>_desc" data-target="<?php echo $l; ?>">🤖</button>
                        </div>
                        <?php endif; ?>
                        <?php echo lang_tab_end(); ?>
                        <?php endforeach; ?>
                        <?php echo lang_tabs_end(); ?>
                    </div>
                </div>
            </div>
            <?php endfor; ?>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan</button>
                <a href="<?php echo base_url('admin/settings'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>