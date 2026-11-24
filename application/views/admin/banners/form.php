<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><?php echo isset($row) ? 'Edit' : 'Tambah'; ?> Banner</h4>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <div class="card">
        <div class="card-body">
            <?php echo form_open_multipart(''); ?>

                <?php echo lang_tabs(); ?>

                <?php
                $langs = ['id', 'en', 'cn', 'de', 'ja'];
                foreach ($langs as $i => $lang):
                    $prefix = $lang;
                    $t = isset($translations[$lang]) ? $translations[$lang] : null;
                ?>
                <?php echo lang_tab_pane($lang, $i === 0); ?>
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="title_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('title_' . $prefix, $t ? $t['title'] : ''); ?>" />
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="banners" data-field="title" data-target="<?php echo $prefix; ?>">↻</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subtitle</label>
                        <div class="input-group">
                            <input type="text" name="subtitle_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('subtitle_' . $prefix, $t ? $t['subtitle'] : ''); ?>" />
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="banners" data-field="subtitle" data-target="<?php echo $prefix; ?>">↻</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php echo lang_tab_end(); ?>
                <?php endforeach; ?>
                <?php echo lang_tabs_end(); ?>

                <div class="mb-3">
                    <label class="form-label">Link (opsional)</label>
                    <input type="text" name="link" class="form-control" value="<?php echo html_escape(isset($row['link']) ? $row['link'] : ''); ?>" placeholder="program-studi" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control" accept="image/*" <?php echo !isset($row) ? 'required' : ''; ?> />
                    <small class="text-muted">Ukuran ideal: 1200 x 600 px (landscape). Maks 4MB. Format: jpg, jpeg, png, webp.</small>
                    <?php if (isset($row['image']) && $row['image']): ?>
                        <div class="mt-2"><img src="<?php echo base_url('uploads/' . html_escape($row['image'])); ?>" height="100" /></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="sort_order" class="form-control" value="<?php echo html_escape(isset($row['sort_order']) ? $row['sort_order'] : '0'); ?>" />
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" <?php echo set_checkbox('is_active', '1', !isset($row) || $row['is_active']); ?> />
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo site_url('admin/banners'); ?>" class="btn btn-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
