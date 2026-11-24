<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Kategori Berita</h4>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <?php echo form_open(''); ?>
                        <?php echo lang_tabs(); ?>
                        <?php
                        $langs = ['id', 'en', 'cn', 'de', 'ja'];
                        foreach ($langs as $i => $lang):
                        ?>
                        <?php echo lang_tab_pane($lang, $i === 0); ?>
                            <div class="mb-3">
                                <label class="form-label">Nama Kategori <?php echo strtoupper($lang); ?> <?php echo $lang === 'id' ? '<span class="text-danger">*</span>' : ''; ?></label>
                                <input type="text" name="name_<?php echo $lang; ?>" class="form-control"  />
                            </div>
                        <?php echo lang_tab_end(); ?>
                        <?php endforeach; ?>
                        <?php echo lang_tabs_end(); ?>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover table-datatable">
                        <thead><tr><th>#</th><th>Nama</th><th>Slug</th><th>Bahasa</th><th>Aksi</th></tr></thead>
                        <tbody>
                            <?php $i=1; foreach ($categories as $c): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><strong><?php echo html_escape($c['name']); ?></strong></td>
                                <td><?php echo html_escape($c['slug']); ?></td>
                                <td>
                                    <?php if (!empty($c['lang_list'])): $langs = explode(',', $c['lang_list']); foreach ($langs as $l): ?>
                                        <span class="badge bg-label-<?php echo $l === 'id' ? 'primary' : ($l === 'en' ? 'info' : ($l === 'de' ? 'success' : ($l === 'ja' ? 'warning' : 'secondary'))); ?> me-1"><?php echo strtoupper($l); ?></span>
                                    <?php endforeach; endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('admin/categories/edit/' . html_escape($c['id'])); ?>" class="btn btn-sm btn-icon btn-outline-primary"><i class="bx bx-edit-alt"></i></a>
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete" data-url="<?php echo base_url('admin/categories/delete/' . html_escape($c['id'])); ?>" data-message="Hapus kategori?"><i class="bx bx-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
