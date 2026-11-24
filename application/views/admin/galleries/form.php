<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><?php echo isset($row) ? 'Edit Album' : 'Tambah Album'; ?></h4>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <div class="card">
        <div class="card-body">
            <?php echo form_open_multipart(''); ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <?php echo lang_tabs(); ?>
                        <?php
                        $langs = ['id', 'en', 'cn', 'de', 'ja'];
                        foreach ($langs as $i => $lang):
                            $prefix = $lang;
                            $t = isset($translations[$lang]) ? $translations[$lang] : null;
                        ?>
                        <?php echo lang_tab_pane($lang, $i === 0); ?>
                            <div class="mb-3">
                                <label class="form-label">Judul Album <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="title_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('title_' . $prefix, $t ? $t['title'] : ''); ?>"  />
                                    <?php if ($prefix !== 'id' && isset($row)): ?>
                                    <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="galleries" data-field="title" data-target="<?php echo $prefix; ?>">↻</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description_<?php echo $prefix; ?>" class="form-control editor-rich" rows="3"><?php echo set_value('description_' . $prefix, $t ? $t['description'] : ''); ?></textarea>
                                <?php if ($prefix !== 'id' && isset($row)): ?>
                                <div class="text-end mt-1"><button type="button" class="btn btn-sm btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="galleries" data-field="description" data-target="<?php echo $prefix; ?>">↻ Regenerate</button></div>
                                <?php endif; ?>
                            </div>
                        <?php echo lang_tab_end(); ?>
                        <?php endforeach; ?>
                        <?php echo lang_tabs_end(); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Cover Image</label>
                        <input type="file" name="cover_image" class="form-control" accept="image/*" />
                        <small class="text-muted">Ukuran ideal: 800 x 600 px. Maks 2MB.</small>
                        <?php if (isset($row) && $row['cover_image']): ?>
                            <div class="mt-2"><img src="<?php echo base_url('uploads/' . html_escape($row['cover_image'])); ?>" height="60" /></div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (isset($row)): ?>
                <div class="mb-3">
                    <label class="form-label">Tambah Foto (bisa pilih banyak)</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple />
                </div>

                <?php if (!empty($images)): ?>
                <h6 class="fw-semibold">Foto dalam Album</h6>
                <div class="row mb-3">
                    <?php foreach ($images as $img): ?>
                    <div class="col-md-3 mb-2">
                        <div class="card">
                            <img src="<?php echo base_url('uploads/' . html_escape($img['image'])); ?>" class="card-img-top" style="height:120px;object-fit:cover" />
                            <div class="card-body p-1 text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="<?php echo base_url('admin/galleries/delete_image/' . html_escape($img['id'])); ?>" data-return="<?php echo urlencode(current_url()); ?>" data-message="Hapus foto?"><i class="bx bx-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <?php endif; ?>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" <?php echo set_checkbox('is_active', '1', !isset($row) || $row['is_active']); ?> />
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo base_url('admin/galleries'); ?>" class="btn btn-outline-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
