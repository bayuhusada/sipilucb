<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><?php echo isset($row) ? 'Edit Berita' : 'Tulis Berita Baru'; ?></h4>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <div class="card">
        <div class="card-body">
            <?php echo form_open_multipart(''); ?>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($categories as $c): ?>
                            <option value="<?php echo $c['id']; ?>" <?php echo set_select('category_id', $c['id'], isset($row) && $row['category_id'] == $c['id']); ?>><?php echo html_escape($c['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*" />
                        <?php if (isset($row) && $row['thumbnail']): ?>
                            <div class="mt-2"><img src="<?php echo base_url('uploads/' . html_escape($row['thumbnail'])); ?>" height="60" /></div>
                        <?php endif; ?>
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
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="title_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('title_' . $prefix, $t ? $t['title'] : ''); ?>"  />
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="news" data-field="title" data-target="<?php echo $prefix; ?>">↻</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konten</label>
                        <textarea name="content_<?php echo $prefix; ?>" class="form-control editor-rich" rows="15"><?php echo set_value('content_' . $prefix, $t ? $t['content'] : ''); ?></textarea>
                        <?php if ($prefix !== 'id' && isset($row)): ?>
                        <div class="text-end mt-1"><button type="button" class="btn btn-sm btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="news" data-field="content" data-target="<?php echo $prefix; ?>">↻ Regenerate Konten</button></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sumber / Link</label>
                        <div class="input-group">
                            <input type="url" name="source_url_<?php echo $prefix; ?>" class="form-control" placeholder="https://instagram.com/p/..." value="<?php echo set_value('source_url_' . $prefix, $t ? $t['source_url'] : ''); ?>" />
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="news" data-field="source_url" data-target="<?php echo $prefix; ?>">↻</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <h6 class="fw-semibold mt-3">SEO</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">SEO Title</label>
                            <div class="input-group">
                                <input type="text" name="seo_title_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('seo_title_' . $prefix, $t ? $t['seo_title'] : ''); ?>" />
                                <?php if ($prefix !== 'id' && isset($row)): ?>
                                <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="news" data-field="seo_title" data-target="<?php echo $prefix; ?>">↻</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SEO Description</label>
                            <div class="input-group">
                                <textarea name="seo_description_<?php echo $prefix; ?>" class="form-control" rows="2"><?php echo set_value('seo_description_' . $prefix, $t ? $t['seo_description'] : ''); ?></textarea>
                                <?php if ($prefix !== 'id' && isset($row)): ?>
                                <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="news" data-field="seo_description" data-target="<?php echo $prefix; ?>">↻</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php echo lang_tab_end(); ?>
                <?php endforeach; ?>
                <?php echo lang_tabs_end(); ?>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_draft" class="form-check-input" value="1" id="is_draft" <?php echo set_checkbox('is_draft', '1', isset($row) && $row['is_draft']); ?> />
                        <label class="form-check-label" for="is_draft">Simpan sebagai Draft</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_highlight" class="form-check-input" value="1" id="is_highlight" <?php echo set_checkbox('is_highlight', '1', isset($row) && $row['is_highlight']); ?> />
                        <label class="form-check-label" for="is_highlight">Highlight</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo base_url('admin/news'); ?>" class="btn btn-outline-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>