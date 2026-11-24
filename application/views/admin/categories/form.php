<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Edit Kategori</h4>

    <?php echo form_open(''); ?>
        <?php echo lang_tabs(); ?>

        <?php
        $langs = ['id', 'en', 'cn', 'de', 'ja'];
        foreach ($langs as $i => $lang):
            $t = isset($translations[$lang]) ? $translations[$lang] : null;
        ?>
        <?php echo lang_tab_pane($lang, $i === 0); ?>
            <div class="mb-3">
                <label class="form-label">Nama Kategori <?php echo strtoupper($lang); ?> <?php echo $lang === 'id' ? '<span class="text-danger">*</span>' : ''; ?></label>
                <div class="input-group">
                    <input type="text" name="name_<?php echo $lang; ?>" class="form-control" value="<?php echo set_value('name_' . $lang, $t ? $t['name'] : ''); ?>" />
                    <?php if ($lang !== 'id' && isset($row)): ?>
                    <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="categories" data-field="name" data-target="<?php echo $lang; ?>">↻</button>
                    <?php endif; ?>
                </div>
            </div>
        <?php echo lang_tab_end(); ?>
        <?php endforeach; ?>
        <?php echo lang_tabs_end(); ?>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?php echo base_url('admin/categories'); ?>" class="btn btn-outline-secondary">Batal</a>
    <?php echo form_close(); ?>
</div>
