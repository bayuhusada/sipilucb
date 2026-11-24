<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><?php echo isset($row) ? 'Edit File Download' : 'Upload File'; ?></h4>

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
                            <input type="text" name="title_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('title_' . $prefix, $t ? $t['title'] : ''); ?>"  />
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="downloads" data-field="title" data-target="<?php echo $prefix; ?>">↻</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File <?php echo $lang === 'id' && !isset($row) ? '<span class="text-danger">*</span>' : '(kosongkan jika tidak ada)'; ?></label>
                        <input type="file" name="file_path_<?php echo $prefix; ?>" class="form-control" />
                        <?php if ($t && $t['file_path']): ?>
                            <div class="mt-1"><a href="<?php echo base_url('uploads/' . html_escape($t['file_path'])); ?>" target="_blank"><?php echo html_escape($t['file_path']); ?></a></div>
                        <?php elseif ($prefix !== 'id' && isset($translations['id']['file_path'])): ?>
                            <div class="mt-1 text-muted small"><a href="<?php echo base_url('uploads/' . html_escape($translations['id']['file_path'])); ?>" target="_blank"><?php echo html_escape($translations['id']['file_path']); ?></a> (dari Indonesia)</div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description_<?php echo $prefix; ?>" class="form-control editor-rich" rows="3"><?php echo set_value('description_' . $prefix, $t ? $t['description'] : ''); ?></textarea>
                        <?php if ($prefix !== 'id' && isset($row)): ?>
                        <div class="text-end mt-1"><button type="button" class="btn btn-sm btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="downloads" data-field="description" data-target="<?php echo $prefix; ?>">↻ Regenerate</button></div>
                        <?php endif; ?>
                    </div>
                <?php echo lang_tab_end(); ?>
                <?php endforeach; ?>
                <?php echo lang_tabs_end(); ?>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" <?php echo set_checkbox('is_active', '1', !isset($row) || $row['is_active']); ?> />
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo base_url('admin/downloads'); ?>" class="btn btn-outline-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
