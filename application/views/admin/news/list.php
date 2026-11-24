<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Berita</h4>
        <a href="<?php echo base_url('admin/news/create'); ?>" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Tulis Berita</a>
    </div>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-datatable">
                <thead>
                    <tr><th>#</th><th>Judul</th><th>Kategori</th><th>Bahasa</th><th>Status</th><th>Highlight</th><th>Dibuat</th><th>Aksi</th></tr>
                </thead>
                <tbody>
					<?php if (!empty($news)): ?>
                    <?php $i=1; foreach ($news as $n): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><strong><?php echo html_escape($n['title']); ?></strong></td>
                        <td><?php echo html_escape($n['category_name'] ?: '-'); ?></td>
                        <td>
                            <?php if (!empty($n['lang_list'])): $langs = explode(',', $n['lang_list']); foreach ($langs as $l): ?>
                                <span class="badge bg-label-<?php echo $l === 'id' ? 'primary' : ($l === 'en' ? 'info' : ($l === 'de' ? 'success' : ($l === 'ja' ? 'warning' : 'secondary'))); ?> me-1"><?php echo strtoupper($l); ?></span>
                            <?php endforeach; endif; ?>
                        </td>
                        <td>
                            <?php if ($n['is_draft']): ?>
                                <span class="badge bg-label-warning">Draft</span>
                            <?php else: ?>
                                <span class="badge bg-label-success">Published</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $n['is_highlight'] ? '<span class="badge bg-label-info">Featured</span>' : '-'; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($n['created_at'])); ?></td>
                        <td>
                            <?php if ($n['is_draft']): ?>
                            <?php echo form_open('admin/news/publish/' . html_escape($n['id']), array('style' => 'display:inline')); ?><button type="submit" class="btn btn-sm btn-icon btn-outline-success" title="Publish"><i class="bx bx-check"></i></button><?php echo form_close(); ?>
                            <?php endif; ?>
                            <a href="<?php echo base_url('admin/news/edit/' . html_escape($n['id'])); ?>" class="btn btn-sm btn-icon btn-outline-secondary"><i class="bx bx-edit-alt"></i></a>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete" data-url="<?php echo base_url('admin/news/delete/' . html_escape($n['id'])); ?>" data-message="Hapus berita?"><i class="bx bx-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
