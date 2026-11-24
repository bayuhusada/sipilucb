<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Download</h4>
        <a href="<?php echo base_url('admin/downloads/create'); ?>" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Upload File</a>
    </div>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-datatable">
                <thead><tr><th>#</th><th>Judul</th><th>Bahasa</th><th>Tipe File</th><th>Ukuran</th><th>Download</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php $i=1; foreach ($downloads as $d): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><strong><?php echo html_escape($d['title']); ?></strong></td>
                        <td>
                            <?php if (!empty($d['lang_list'])): $langs = explode(',', $d['lang_list']); $file_map = []; if (!empty($d['lang_files'])) { foreach (explode('|', $d['lang_files']) as $pair) { $parts = explode(':', $pair, 2); $file_map[$parts[0]] = $parts[1] ?? ''; } } foreach ($langs as $l): $has_file = !empty($file_map[$l]); ?>
                                <span class="badge bg-label-<?php echo $l === 'id' ? 'primary' : ($l === 'en' ? 'info' : ($l === 'de' ? 'success' : ($l === 'ja' ? 'warning' : 'secondary'))); ?> me-1"><?php echo strtoupper($l); ?><?php echo $has_file ? ' <i class="bx bx-file"></i>' : ''; ?></span>
                            <?php endforeach; endif; ?>
                        </td>
                        <td><?php echo html_escape(strtoupper($d['file_type'])); ?></td>
                        <td><?php echo $d['file_size'] ? round($d['file_size'] / 1024, 1) . ' KB' : '-'; ?></td>
                        <td><?php echo $d['download_count']; ?></td>
                        <td><span class="badge bg-label-<?php echo $d['is_active'] ? 'success' : 'secondary'; ?>"><?php echo $d['is_active'] ? 'Aktif' : 'Nonaktif'; ?></span></td>
                        <td>
                            <a href="<?php echo base_url('admin/downloads/edit/' . html_escape($d['id'])); ?>" class="btn btn-sm btn-icon btn-outline-secondary"><i class="bx bx-edit-alt"></i></a>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete" data-url="<?php echo base_url('admin/downloads/delete/' . html_escape($d['id'])); ?>" data-message="Hapus file?"><i class="bx bx-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
