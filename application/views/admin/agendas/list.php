<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Agenda</h4>
        <a href="<?php echo base_url('admin/agendas/create'); ?>" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Tambah Agenda</a>
    </div>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-datatable">
                <thead><tr><th>#</th><th>Judul</th><th>Lokasi</th><th>Tanggal</th><th>Bahasa</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php $i=1; foreach ($agendas as $a): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><strong><?php echo html_escape($a['title']); ?></strong></td>
                        <td><?php echo html_escape($a['location'] ?: '-'); ?></td>
                        <td>
                            <?php echo $a['start_date'] ? date('d/m/Y H:i', strtotime($a['start_date'])) : '-'; ?>
                            <?php echo $a['end_date'] ? ' - ' . date('d/m/Y H:i', strtotime($a['end_date'])) : ''; ?>
                        </td>
                        <td>
                            <?php if (!empty($a['lang_list'])): $langs = explode(',', $a['lang_list']); foreach ($langs as $l): ?>
                                <span class="badge bg-label-<?php echo $l === 'id' ? 'primary' : ($l === 'en' ? 'info' : ($l === 'de' ? 'success' : ($l === 'ja' ? 'warning' : 'secondary'))); ?> me-1"><?php echo strtoupper($l); ?></span>
                            <?php endforeach; endif; ?>
                        </td>
                        <td><span class="badge bg-label-<?php echo $a['is_active'] ? 'success' : 'secondary'; ?>"><?php echo $a['is_active'] ? 'Aktif' : 'Nonaktif'; ?></span></td>
                        <td>
                            <a href="<?php echo base_url('admin/agendas/edit/' . html_escape($a['id'])); ?>" class="btn btn-sm btn-icon btn-outline-secondary"><i class="bx bx-edit-alt"></i></a>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete" data-url="<?php echo base_url('admin/agendas/delete/' . html_escape($a['id'])); ?>" data-message="Hapus agenda?"><i class="bx bx-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
