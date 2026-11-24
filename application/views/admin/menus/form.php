<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><?php echo isset($row) ? 'Edit Menu' : 'Tambah Menu'; ?></h4>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <div class="card">
        <div class="card-body">
            <?php echo form_open(''); ?>
                <?php echo lang_tabs(); ?>

                <?php
                $langs = ['id', 'en', 'cn', 'de', 'ja'];
                foreach ($langs as $i => $lang):
                    $prefix = $lang;
                    $t = isset($translations[$lang]) ? $translations[$lang] : null;
                ?>
                <?php echo lang_tab_pane($lang, $i === 0); ?>
                    <div class="mb-3">
                        <label class="form-label">Label <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="label_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('label_' . $prefix, $t ? $t['label'] : ''); ?>" />
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="menus" data-field="label" data-target="<?php echo $prefix; ?>">🤖</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php echo lang_tab_end(); ?>
                <?php endforeach; ?>
                <?php echo lang_tabs_end(); ?>

                <div class="mb-3">
                    <label class="form-label">URL</label>
                    <input type="text" name="url" class="form-control" value="<?php echo set_value('url', isset($row) ? $row['url'] : '/'); ?>" placeholder="/ atau program-studi atau https://..." />
                    <div class="form-text">Isi dengan path (contoh: <code>program-studi</code>) atau URL lengkap untuk link eksternal.</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="sort_order" class="form-control" value="<?php echo set_value('sort_order', isset($row) ? $row['sort_order'] : ($next_order ?? 1)); ?>" />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Posisi</label>
                        <select name="location" class="form-select">
                            <option value="both" <?php echo set_select('location', 'both', !isset($row) || $row['location'] == 'both'); ?>>Header & Footer</option>
                            <option value="header" <?php echo set_select('location', 'header', isset($row) && $row['location'] == 'header'); ?>>Header Saja</option>
                            <option value="footer" <?php echo set_select('location', 'footer', isset($row) && $row['location'] == 'footer'); ?>>Footer Saja</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Target</label>
                        <select name="target" class="form-select">
                            <option value="_self" <?php echo set_select('target', '_self', !isset($row) || $row['target'] == '_self'); ?>>Tab Sama</option>
                            <option value="_blank" <?php echo set_select('target', '_blank', isset($row) && $row['target'] == '_blank'); ?>>Tab Baru</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" <?php echo set_checkbox('is_active', '1', !isset($row) || $row['is_active']); ?> />
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo base_url('admin/menus'); ?>" class="btn btn-outline-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
