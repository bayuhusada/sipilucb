<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Dosen</h4>
        <a href="<?php echo base_url('admin/lecturers/create'); ?>" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Tambah Dosen</a>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h5 class="mb-1">Sinkronisasi Data</h5>
                <small class="text-muted">Data dosen dari SEVIMA (hanya prodi <?php echo html_escape($this->config->item('homebase_name', 'sevima')); ?>)</small>
            </div>
            <?php echo form_open('admin/lecturers/sync_now', array('class' => 'd-inline', 'id' => 'sync-form')); ?>
                <button type="submit" id="sync-btn" class="btn btn-success"><i class="bx bx-sync me-1"></i> Sinkronkan Sekarang</button>
            <?php echo form_close(); ?>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <small class="text-muted">Terakhir Sync</small>
                    <div class="fw-semibold"><?php echo $sync_log ? date('d M Y H:i', strtotime($sync_log['finished_at'])) : 'Belum pernah'; ?></div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Status</small>
                    <div>
                        <?php if (!$sync_log): ?>
                            <span class="badge bg-label-secondary">Belum Ada</span>
                        <?php else: ?>
                            <span class="badge bg-label-<?php echo $sync_log['status'] === 'success' ? 'success' : ($sync_log['status'] === 'failed' ? 'danger' : ($sync_log['status'] === 'partial' ? 'warning' : 'info')); ?>">
                                <?php echo $sync_log['status'] === 'success' ? 'Berhasil' : ($sync_log['status'] === 'failed' ? 'Gagal' : ($sync_log['status'] === 'partial' ? 'Sebagian' : 'Berjalan')); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Total Dosen</small>
                    <div class="fw-semibold"><?php echo count($lecturers); ?></div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Mahasiswa Aktif (SEVIMA)</small>
                    <div class="fw-semibold"><?php echo $sync_log ? (int) $sync_log['students_count'] : '-'; ?></div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Hasil Terakhir</small>
                    <div class="fw-semibold"><?php echo $sync_log ? ('Baru ' . $sync_log['inserted'] . ' / Update ' . $sync_log['updated'] . ' / Gagal ' . $sync_log['failed']) : '-'; ?></div>
                </div>
            </div>
            <div class="mt-3 d-none" id="sync-progress">
                <div class="alert alert-info d-flex align-items-center gap-2 py-2 mb-0">
                    <span class="spinner-border spinner-border-sm text-info" role="status" aria-hidden="true"></span>
                    <div>
                        <strong>Sinkronisasi sedang berjalan...</strong>
                        <div class="small text-muted">Proses dapat memakan waktu beberapa menit (dosen + scan mahasiswa + akreditasi). Tombol dinonaktifkan agar tidak diklik berulang. Halaman akan dimuat ulang setelah selesai.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <h5 class="mb-0">Riwayat Sinkronisasi</h5>
            <?php if (!empty($sync_logs)): ?>
            <a href="<?php echo base_url('admin/lecturers/sync_logs'); ?>" class="btn btn-sm btn-outline-primary"><i class="bx bx-history me-1"></i> Lihat Semua</a>
            <?php endif; ?>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr><th>Waktu</th><th>Type</th><th>Status</th><th>Total</th><th>Baru</th><th>Update</th><th>Nonaktif</th><th>Mhs Aktif</th><th>Gagal</th></tr>
                </thead>
                <tbody>
                    <?php if (empty($sync_logs)): ?>
                    <tr><td colspan="9" class="text-center text-muted py-3">Belum ada riwayat sinkronisasi.</td></tr>
                    <?php else: foreach ($sync_logs as $log): ?>
                    <tr>
                        <td><?php echo date('d M Y H:i', strtotime($log['started_at'])); ?></td>
                        <td><span class="badge bg-label-<?php echo $log['sync_type'] === 'cron' ? 'primary' : 'info'; ?>"><?php echo $log['sync_type'] === 'cron' ? 'Cron' : 'Manual'; ?></span></td>
                        <td><span class="badge bg-label-<?php echo $log['status'] === 'success' ? 'success' : ($log['status'] === 'failed' ? 'danger' : ($log['status'] === 'partial' ? 'warning' : 'info')); ?>"><?php echo $log['status'] === 'success' ? 'Berhasil' : ($log['status'] === 'failed' ? 'Gagal' : ($log['status'] === 'partial' ? 'Sebagian' : 'Berjalan')); ?></span></td>
                        <td><?php echo (int) $log['total_data']; ?></td>
                        <td><?php echo (int) $log['inserted']; ?></td>
                        <td><?php echo (int) $log['updated']; ?></td>
                        <td><?php echo (int) $log['deactivated']; ?></td>
                        <td><?php echo (int) $log['students_count']; ?></td>
                        <td><?php echo (int) $log['failed']; ?></td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-datatable">
                <thead>
                    <tr><th>#</th><th>Nama</th><th>NIDN</th><th>Bahasa</th><th>Jabatan</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach ($lecturers as $l): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><strong><?php echo html_escape($l['name']); ?></strong></td>
                        <td><?php echo html_escape($l['nidn'] ?: '-'); ?></td>
                        <td>
                            <?php if (!empty($l['lang_list'])): $langs = explode(',', $l['lang_list']); foreach ($langs as $lng): ?>
                                <span class="badge bg-label-<?php echo $lng === 'id' ? 'primary' : ($lng === 'en' ? 'info' : ($lng === 'de' ? 'success' : ($lng === 'ja' ? 'warning' : 'secondary'))); ?> me-1"><?php echo strtoupper($lng); ?></span>
                            <?php endforeach; endif; ?>
                        </td>
                        <td><?php echo html_escape($l['position'] ?: '-'); ?></td>
                        <td><span class="badge bg-label-<?php echo $l['is_active'] ? 'success' : 'secondary'; ?>"><?php echo $l['is_active'] ? 'Aktif' : 'Nonaktif'; ?></span></td>
                        <td>
                            <a href="<?php echo base_url('admin/lecturers/edit/' . html_escape($l['id'])); ?>" class="btn btn-sm btn-icon btn-outline-secondary"><i class="bx bx-edit-alt"></i></a>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete" data-url="<?php echo base_url('admin/lecturers/delete/' . html_escape($l['id'])); ?>" data-message="Hapus dosen <?php echo str_replace(array("\\", "'"), array("\\\\", "\\'"), html_escape($l['name'])); ?>?"><i class="bx bx-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
(function () {
    var form = document.getElementById('sync-form');
    if (!form) return;

    form.addEventListener('submit', function () {
        var btn = document.getElementById('sync-btn');
        var progress = document.getElementById('sync-progress');
        if (!btn || btn.disabled) return;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyinkronkan...';
        if (progress) progress.classList.remove('d-none');
    });
})();
</script>
