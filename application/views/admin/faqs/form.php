<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><?php echo isset($row) ? 'Edit' : 'Tambah'; ?> FAQ</h4>

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
                        <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="question_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('question_' . $prefix, $t ? $t['question'] : ''); ?>" />
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="faqs" data-field="question" data-target="<?php echo $prefix; ?>">↻</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jawaban <span class="text-danger">*</span></label>
                        <textarea name="answer_<?php echo $prefix; ?>" class="form-control editor-rich" rows="4"><?php echo set_value('answer_' . $prefix, $t ? $t['answer'] : ''); ?></textarea>
                        <?php if ($prefix !== 'id' && isset($row)): ?>
                        <div class="text-end mt-1"><button type="button" class="btn btn-sm btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="faqs" data-field="answer" data-target="<?php echo $prefix; ?>">↻ Regenerate</button></div>
                        <?php endif; ?>
                    </div>
                <?php echo lang_tab_end(); ?>
                <?php endforeach; ?>
                <?php echo lang_tabs_end(); ?>

                <div class="mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="sort_order" class="form-control" value="<?php echo html_escape(isset($row['sort_order']) ? $row['sort_order'] : '0'); ?>" />
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" <?php echo set_checkbox('is_active', '1', !isset($row) || $row['is_active']); ?> />
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo site_url('admin/faqs'); ?>" class="btn btn-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
