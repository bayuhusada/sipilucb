<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Banner Slider</h4>
        <a href="<?= site_url('admin/banners/create') ?>" class="btn btn-primary">+ Tambah Banner</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-datatable">
                    <thead>
                        <tr>
                            <th>Urutan</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Bahasa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($banners): ?>
                            <?php foreach ($banners as $b): ?>
                            <tr>
                                <td><?php echo html_escape($b['sort_order']); ?></td>
                                <td><img src="<?php echo base_url('uploads/' . html_escape($b['image'])); ?>" height="50" /></td>
                                <td><?php echo html_escape($b['title']); ?></td>
                                <td>
                                    <?php if (!empty($b['lang_list'])): $langs = explode(',', $b['lang_list']); foreach ($langs as $l): ?>
                                        <span class="badge bg-label-<?php echo $l === 'id' ? 'primary' : ($l === 'en' ? 'info' : ($l === 'de' ? 'success' : ($l === 'ja' ? 'warning' : 'secondary'))); ?> me-1"><?php echo strtoupper($l); ?></span>
                                    <?php endforeach; endif; ?>
                                </td>
                                <td><?php echo $b['is_active'] ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>'; ?></td>
                                <td>
                                    <a href="<?php echo site_url('admin/banners/edit/' . html_escape($b['id'])); ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger btn-delete" data-url="<?php echo site_url('admin/banners/delete/' . html_escape($b['id'])); ?>" data-message="Hapus banner ini?">Hapus</button>
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
