<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Menu Navigasi</h4>
        <a href="<?php echo base_url('admin/menus/create'); ?>" class="btn btn-primary">Tambah Menu</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-datatable">
                    <thead>
                        <tr>
                            <th>Urutan</th>
                            <th>Label</th>
                            <th>URL</th>
                            <th>Posisi</th>
                            <th>Target</th>
                            <th>Bahasa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($menus) > 0): ?>
                        <?php foreach ($menus as $m): ?>
                        <tr>
                            <td><?php echo html_escape($m['sort_order']); ?></td>
                            <td><?php echo html_escape($m['label']); ?></td>
                            <td><code><?php echo html_escape($m['url']); ?></code></td>
                            <td><?php echo html_escape($m['location']); ?></td>
                            <td><?php echo $m['target'] === '_blank' ? 'Tab Baru' : 'Sama'; ?></td>
                            <td>
                                <?php if (!empty($m['lang_list'])): $langs = explode(',', $m['lang_list']); foreach ($langs as $l): ?>
                                    <span class="badge bg-label-<?php echo $l === 'id' ? 'primary' : ($l === 'en' ? 'info' : ($l === 'de' ? 'success' : ($l === 'ja' ? 'warning' : 'secondary'))); ?> me-1"><?php echo strtoupper($l); ?></span>
                                <?php endforeach; endif; ?>
                            </td>
                            <td><?php echo $m['is_active'] ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>'; ?></td>
                            <td>
                                <a href="<?php echo base_url('admin/menus/edit/' . html_escape($m['id'])); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="<?php echo base_url('admin/menus/delete/' . html_escape($m['id'])); ?>" data-message="Hapus menu ini?">Hapus</button>
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
