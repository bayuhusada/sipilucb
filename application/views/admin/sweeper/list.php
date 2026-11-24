<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-2">Pembersih File Yatim</h4>
    <p class="text-muted mb-4">
        File di <code>uploads/</code> yang tidak lagi direferensikan oleh database (hasil upload yang gagal tersimpan / dibatalkan). Menghapusnya mengosongkan penyimpanan tanpa memengaruhi konten.
    </p>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row mb-3">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="badge bg-success bg-glow me-3 p-2"><i class="bx bx-check-double"></i></div>
                    <div>
                        <div class="fw-bold fs-4"><?php echo number_format(count($referenced)); ?></div>
                        <div class="text-muted small">File terpakai</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="badge bg-warning me-3 p-2"><i class="bx bx-file-blank"></i></div>
                    <div>
                        <div class="fw-bold fs-4"><?php echo number_format($total_orphans); ?></div>
                        <div class="text-muted small">File yatim</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="badge bg-danger me-3 p-2"><i class="bx bx-hard-drive"></i></div>
                    <div>
                        <div class="fw-bold fs-4"><?php echo number_format($total_bytes / 1048576, 2); ?> MB</div>
                        <div class="text-muted small">Bisa dibebaskan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar File Yatim</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <?php if (empty($orphans)): ?>
            <div class="card-body">
                <div class="alert alert-success mb-0">Tidak ada file yatim. Penyimpanan bersih.</div>
            </div>
            <?php else: ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>File</th>
                        <th class="text-end">Ukuran</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; foreach ($orphans as $o): $i++; ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><code><?php echo html_escape($o['file']); ?></code></td>
                        <td class="text-end"><?php echo number_format($o['size'] / 1024, 1); ?> KB</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="card-body border-top">
                <?php echo form_open('admin/sweeper', array('onsubmit' => "return confirm('Hapus " . $total_orphans . " file yatim (" . number_format($total_bytes / 1048576, 2) . " MB)? Proses tidak bisa dibatalkan.')")); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="bx bx-trash me-1"></i>Hapus <?php echo $total_orphans; ?> file yatim (<?php echo number_format($total_bytes / 1048576, 2); ?> MB)
                    </button>
                <?php echo form_close(); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>