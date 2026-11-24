<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Profil Program Studi</h4>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <div class="card">
        <div class="card-body">
            <?php echo form_open_multipart(''); ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Akreditasi</label>
                        <input type="text" name="accreditation" class="form-control" value="<?php echo set_value('accreditation', isset($row) ? $row['accreditation'] : ''); ?>" placeholder="Unggul / A / B" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*" />
                        <?php if (isset($row) && $row['thumbnail']): ?>
                            <div class="mt-2"><img src="<?php echo base_url('uploads/' . $row['thumbnail']); ?>" height="60" /></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Video YouTube (opsional)</label>
                        <input type="url" name="video_url" class="form-control" value="<?php echo set_value('video_url', isset($row) ? ($row['video_url'] ?? '') : ''); ?>" placeholder="https://www.youtube.com/watch?v=..." />
                    </div>
                </div>

                <?php echo lang_tabs(); ?>

                <?php
                $langs = ['id', 'en', 'cn', 'de', 'ja'];
                foreach ($langs as $i => $lang):
                    $prefix = $lang;
                    $t = isset($translations[$lang]) ? $translations[$lang] : null;
                ?>
                <?php echo lang_tab_pane($lang, $i === 0); ?>
                    <div class="mb-3">
                        <label class="form-label">Nama Program Studi <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="name_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('name_' . $prefix, $t ? $t['name'] : ''); ?>"  />
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="study_programs" data-field="name" data-target="<?php echo $prefix; ?>">↻</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description_<?php echo $prefix; ?>" class="form-control editor-rich" rows="3"><?php echo set_value('description_' . $prefix, $t ? $t['description'] : ''); ?></textarea>
                        <?php if ($prefix !== 'id' && isset($row)): ?>
                        <div class="text-end mt-1"><button type="button" class="btn btn-sm btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="study_programs" data-field="description" data-target="<?php echo $prefix; ?>">↻ Regenerate</button></div>
                        <?php endif; ?>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Visi</label>
                            <textarea name="vision_<?php echo $prefix; ?>" class="form-control editor-rich" rows="4"><?php echo set_value('vision_' . $prefix, $t ? $t['vision'] : ''); ?></textarea>
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <div class="text-end mt-1"><button type="button" class="btn btn-sm btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="study_programs" data-field="vision" data-target="<?php echo $prefix; ?>">↻ Regenerate</button></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Misi</label>
                            <textarea name="mission_<?php echo $prefix; ?>" class="form-control editor-rich" rows="4"><?php echo set_value('mission_' . $prefix, $t ? $t['mission'] : ''); ?></textarea>
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <div class="text-end mt-1"><button type="button" class="btn btn-sm btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="study_programs" data-field="mission" data-target="<?php echo $prefix; ?>">↻ Regenerate</button></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Profil Lulusan</label>
                        <textarea name="graduate_profile_<?php echo $prefix; ?>" class="form-control editor-rich" rows="3"><?php echo set_value('graduate_profile_' . $prefix, $t ? $t['graduate_profile'] : ''); ?></textarea>
                        <?php if ($prefix !== 'id' && isset($row)): ?>
                        <div class="text-end mt-1"><button type="button" class="btn btn-sm btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="study_programs" data-field="graduate_profile" data-target="<?php echo $prefix; ?>">↻ Regenerate</button></div>
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
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
