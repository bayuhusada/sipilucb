<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Fakultas</h4>
        <a href="<?php echo base_url('admin/faculties/create'); ?>" class="btn btn-primary">Tambah Fakultas</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($faculties) > 0): ?>
                        <?php foreach ($faculties as $i => $f): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo html_escape($f['name']); ?></td>
                            <td><?php echo html_escape($f['created_at']); ?></td>
                            <td>
                                <a href="<?php echo base_url('admin/faculties/edit/' . html_escape($f['id'])); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="<?php echo base_url('admin/faculties/delete/' . html_escape($f['id'])); ?>" data-message="Hapus fakultas ini?">Hapus</button>
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
