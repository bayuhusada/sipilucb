<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">FAQ</h4>
        <a href="<?= site_url('admin/faqs/create') ?>" class="btn btn-primary">+ Tambah FAQ</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-datatable">
                    <thead>
                        <tr><th>Urutan</th><th>Pertanyaan</th><th>Bahasa</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php if ($faqs): ?>
                            <?php foreach ($faqs as $f): ?>
                            <tr>
                                <td><?php echo html_escape($f['sort_order']); ?></td>
                                <td><?php echo html_escape($f['question']); ?></td>
                                <td>
                                    <?php if (!empty($f['lang_list'])): $langs = explode(',', $f['lang_list']); foreach ($langs as $l): ?>
                                        <span class="badge bg-label-<?php echo $l === 'id' ? 'primary' : ($l === 'en' ? 'info' : ($l === 'de' ? 'success' : ($l === 'ja' ? 'warning' : 'secondary'))); ?> me-1"><?php echo strtoupper($l); ?></span>
                                    <?php endforeach; endif; ?>
                                </td>
                                <td><?php echo $f['is_active'] ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>'; ?></td>
                                <td>
                                    <a href="<?php echo site_url('admin/faqs/edit/' . html_escape($f['id'])); ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger btn-delete" data-url="<?php echo site_url('admin/faqs/delete/' . html_escape($f['id'])); ?>" data-message="Hapus FAQ ini?">Hapus</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
