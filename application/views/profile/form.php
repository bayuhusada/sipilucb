<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Profil Saya</h4>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo html_escape($error); ?></div>
    <?php endif; ?>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <div class="card">
        <div class="card-body">
            <?php echo form_open(); ?>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" value="<?php echo set_value('username', $row['username']); ?>" required />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?php echo set_value('email', $row['email']); ?>" required />
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control" minlength="6" placeholder="Min. 6 karakter" />
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" value="<?php echo html_escape(ucfirst(str_replace('_', ' ', $row['role']))); ?>" disabled />
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
