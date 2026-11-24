<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Riwayat Sinkronisasi</h4>
        <a href="<?php echo base_url('admin/lecturers'); ?>" class="btn btn-outline-secondary"><i class="bx bx-arrow-back me-1"></i> Kembali ke Dosen</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Riwayat Sinkronisasi SEVIMA</h5>
            <small class="text-muted">100 entri terakhir (terbaru di atas)</small>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr><th>Waktu</th><th>Type</th><th>Status</th><th>Total</th><th>Baru</th><th>Update</th><th>Nonaktif</th><th>Mhs Aktif</th><th>Gagal</th><th>Keterangan</th></tr>
                </thead>
                <tbody>
                    <?php if (empty($sync_logs)): ?>
                    <tr><td colspan="10" class="text-center text-muted py-3">Belum ada riwayat sinkronisasi.</td></tr>
                    <?php else: foreach ($sync_logs as $log): ?>
                    <tr>
                        <td><?php echo date('d M Y H:i', strtotime($log['started_at'])); ?></td>
                        <td><span class="badge bg-label-<?php echo $log['sync_type'] === 'cron' ? 'primary' : 'info'; ?>"><?php echo $log['sync_type'] === 'cron' ? 'Cron' : 'Manual'; ?></span></td>
                        <td><span class="badge bg-label-<?php echo $log['status'] === 'success' ? 'success' : ($log['status'] === 'failed' ? 'danger' : ($log['status'] === 'partial' ? 'warning' : 'info')); ?>"><?php echo $log['status'] === 'success' ? 'Berhasil' : ($log['status'] === 'failed' ? 'Gagal' : ($log['status'] === 'partial' ? 'Sebagian' : ($log['status'] === 'stale' ? 'Macet' : 'Berjalan'))); ?></span></td>
                        <td><?php echo (int) $log['total_data']; ?></td>
                        <td><?php echo (int) $log['inserted']; ?></td>
                        <td><?php echo (int) $log['updated']; ?></td>
                        <td><?php echo (int) $log['deactivated']; ?></td>
                        <td><?php echo (int) $log['students_count']; ?></td>
                        <td><?php echo (int) $log['failed']; ?></td>
                        <td class="text-muted" style="max-width: 280px;"><?php echo html_escape($log['error_message'] ?: '-'); ?></td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>