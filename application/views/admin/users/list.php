<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Manajemen Users</h4>
        <a href="<?php echo base_url('admin/users/create'); ?>" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah User
        </a>
    </div>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Terakhir Login</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($users as $u): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><strong><?php echo html_escape($u['username']); ?></strong></td>
                        <td><?php echo html_escape($u['email']); ?></td>
                        <td><span class="badge bg-label-<?php echo $u['role'] == 'superadmin' ? 'danger' : ($u['role'] == 'admin' ? 'primary' : 'info'); ?>"><?php echo html_escape(ucfirst(str_replace('_', ' ', $u['role']))); ?></span></td>
                        <td><span class="badge bg-label-<?php echo $u['is_active'] ? 'success' : 'secondary'; ?>"><?php echo $u['is_active'] ? 'Aktif' : 'Nonaktif'; ?></span></td>
                        <td><?php echo $u['last_login'] ? date('d/m/Y H:i', strtotime($u['last_login'])) : '-'; ?></td>
                        <td>
                            <a href="<?php echo base_url('admin/users/edit/' . html_escape($u['id'])); ?>" class="btn btn-sm btn-icon btn-outline-secondary">
                                <i class="bx bx-edit-alt"></i>
                            </a>
<button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete" data-url="<?php echo base_url('admin/users/delete/' . html_escape($u['id'])); ?>" data-message="Hapus user <?php echo str_replace(array("\\", "'"), array("\\\\", "\\'"), html_escape($u['username'])); ?>?"><i class="bx bx-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
