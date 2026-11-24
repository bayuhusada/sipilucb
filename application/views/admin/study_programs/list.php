<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Program Studi</h4>
    </div>

    <?php if (!empty($programs)): $p = $programs[0]; ?>
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-datatable">
                <thead>
                    <tr><th>#</th><th>Nama</th><th>Akreditasi</th><th>Bahasa</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><strong><?php echo html_escape($p['name']); ?></strong></td>
                        <td><?php echo html_escape($p['accreditation'] ?: '-'); ?></td>
                        <td>
                            <?php if (!empty($p['lang_list'])): $langs = explode(',', $p['lang_list']); foreach ($langs as $l): ?>
                                <span class="badge bg-label-<?php echo $l === 'id' ? 'primary' : ($l === 'en' ? 'info' : ($l === 'de' ? 'success' : ($l === 'ja' ? 'warning' : 'secondary'))); ?> me-1"><?php echo strtoupper($l); ?></span>
                            <?php endforeach; endif; ?>
                        </td>
                        <td><span class="badge bg-label-<?php echo $p['is_active'] ? 'success' : 'secondary'; ?>"><?php echo $p['is_active'] ? 'Aktif' : 'Nonaktif'; ?></span></td>
                        <td>
                            <a href="<?php echo base_url('admin/study_programs/edit/' . html_escape($p['id'])); ?>" class="btn btn-sm btn-icon btn-outline-secondary"><i class="bx bx-edit-alt"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-info">Belum ada data program studi.</div>
    <?php endif; ?>
</div>
