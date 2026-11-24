<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><?php echo isset($row) ? 'Edit User' : 'Tambah User'; ?></h4>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <div class="card">
        <div class="card-body">
            <?php echo form_open(); ?>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" value="<?php echo set_value('username', isset($row) ? $row['username'] : ''); ?>" required />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?php echo set_value('email', isset($row) ? $row['email'] : ''); ?>" required />
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Password <?php echo isset($row) ? '(kosongkan jika tidak diubah)' : ''; ?> <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" <?php echo isset($row) ? '' : 'required'; ?> minlength="8" />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" id="role-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="superadmin" <?php echo set_select('role', 'superadmin', isset($row) && $row['role'] == 'superadmin'); ?>>Super Admin</option>
                            <option value="admin" <?php echo set_select('role', 'admin', isset($row) && $row['role'] == 'admin'); ?>>Admin</option>
                            <option value="admin_berita" <?php echo set_select('role', 'admin_berita', isset($row) && $row['role'] == 'admin_berita'); ?>>Admin Berita</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" <?php echo set_checkbox('is_active', '1', !isset($row) || $row['is_active']); ?> />
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo base_url('admin/users'); ?>" class="btn btn-outline-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

