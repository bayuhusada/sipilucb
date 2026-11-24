<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Edit Fakultas</h4>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <div class="card">
        <div class="card-body">
            <?php echo form_open(); ?>
                <div class="mb-3">
                    <label class="form-label">Nama Fakultas <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="<?php echo set_value('name', isset($faculty) ? $faculty['name'] : ''); ?>" required />
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
