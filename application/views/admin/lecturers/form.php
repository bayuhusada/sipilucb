<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><?php echo isset($row) ? 'Edit Dosen' : 'Tambah Dosen'; ?></h4>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <div class="card">
        <div class="card-body">
            <?php echo form_open_multipart(''); ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">NIDN</label>
                        <input type="text" name="nidn" class="form-control" value="<?php echo set_value('nidn', isset($row) ? $row['nidn'] : ''); ?>" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="sort_order" class="form-control" value="<?php echo set_value('sort_order', isset($row) ? $row['sort_order'] : '0'); ?>" />
                    </div>
                </div>

                <?php echo lang_tabs(); ?>

                <?php
                $langs = ['id', 'en', 'cn', 'de', 'ja'];
                foreach ($langs as $i => $lang):
                    $prefix = $lang;
                    $t = isset($translations[$lang]) ? $translations[$lang] : null;
                ?>
                <?php echo lang_tab_pane($lang, $i === 0); ?>
                    <div class="mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="name_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('name_' . $prefix, $t ? $t['name'] : ''); ?>"  />
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="lecturers" data-field="name" data-target="<?php echo $prefix; ?>">↻</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Gelar Depan</label>
                            <div class="input-group">
                                <input type="text" name="front_title_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('front_title_' . $prefix, $t ? $t['front_title'] : ''); ?>" />
                                <?php if ($prefix !== 'id' && isset($row)): ?>
                                <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="lecturers" data-field="front_title" data-target="<?php echo $prefix; ?>">↻</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gelar Belakang</label>
                            <div class="input-group">
                                <input type="text" name="back_title_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('back_title_' . $prefix, $t ? $t['back_title'] : ''); ?>" />
                                <?php if ($prefix !== 'id' && isset($row)): ?>
                                <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="lecturers" data-field="back_title" data-target="<?php echo $prefix; ?>">↻</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <div class="input-group">
                            <input type="text" name="position_<?php echo $prefix; ?>" class="form-control" value="<?php echo set_value('position_' . $prefix, $t ? $t['position'] : ''); ?>" />
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <button type="button" class="btn btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="lecturers" data-field="position" data-target="<?php echo $prefix; ?>">↻</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bidang Keahlian</label>
                        <textarea name="expertise_<?php echo $prefix; ?>" class="form-control" rows="2"><?php echo set_value('expertise_' . $prefix, $t ? $t['expertise'] : ''); ?></textarea>
                        <?php if ($prefix !== 'id' && isset($row)): ?>
                        <div class="text-end mt-1"><button type="button" class="btn btn-sm btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="lecturers" data-field="expertise" data-target="<?php echo $prefix; ?>">↻ Regenerate</button></div>
                        <?php endif; ?>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Riwayat Pendidikan</label>
                            <textarea name="education_history_<?php echo $prefix; ?>" class="form-control editor-rich" rows="4"><?php echo set_value('education_history_' . $prefix, $t ? $t['education_history'] : ''); ?></textarea>
                            <?php if ($prefix !== 'id' && isset($row)): ?>
                            <div class="text-end mt-1"><button type="button" class="btn btn-sm btn-outline-secondary btn-regenerate" data-id="<?php echo $row['id']; ?>" data-type="lecturers" data-field="education_history" data-target="<?php echo $prefix; ?>">↻ Regenerate</button></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Publikasi</label>
                            <textarea name="publications_<?php echo $prefix; ?>" class="form-control editor-rich" rows="4"><?php echo set_value('publications_' . $prefix, $t ? $t['publications'] : ''); ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Penelitian</label>
                            <textarea name="research_<?php echo $prefix; ?>" class="form-control editor-rich" rows="4"><?php echo set_value('research_' . $prefix, $t ? $t['research'] : ''); ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pengabdian</label>
                            <textarea name="community_service_<?php echo $prefix; ?>" class="form-control editor-rich" rows="4"><?php echo set_value('community_service_' . $prefix, $t ? $t['community_service'] : ''); ?></textarea>
                        </div>
                    </div>
                <?php echo lang_tab_end(); ?>
                <?php endforeach; ?>
                <?php echo lang_tabs_end(); ?>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Foto</label>
                        <input type="file" name="photo" class="form-control" accept="image/*" />
                        <?php if (isset($row) && $row['photo']): ?>
                            <div class="mt-2"><img src="<?php echo base_url('uploads/' . html_escape($row['photo'])); ?>" height="60" /></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">CV (PDF)</label>
                        <input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx" />
                        <?php if (isset($row) && $row['cv_file']): ?>
                            <div class="mt-2"><a href="<?php echo base_url('uploads/' . html_escape($row['cv_file'])); ?>" target="_blank">Lihat CV</a></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo set_value('email', isset($row) ? $row['email'] : ''); ?>" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo set_value('phone', isset($row) ? $row['phone'] : ''); ?>" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Google Scholar</label>
                        <input type="text" name="google_scholar" class="form-control" value="<?php echo set_value('google_scholar', isset($row) ? $row['google_scholar'] : ''); ?>" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">SINTA ID</label>
                        <input type="text" name="sinta_id" class="form-control" value="<?php echo set_value('sinta_id', isset($row) ? $row['sinta_id'] : ''); ?>" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Scopus ID</label>
                        <input type="text" name="scopus_id" class="form-control" value="<?php echo set_value('scopus_id', isset($row) ? $row['scopus_id'] : ''); ?>" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">ORCID</label>
                        <input type="text" name="orcid" class="form-control" value="<?php echo set_value('orcid', isset($row) ? $row['orcid'] : ''); ?>" />
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Social Media (satu per baris: platform|url)</label>
                    <textarea name="social_media" class="form-control" rows="2" placeholder="instagram|https://instagram.com/username&#10;linkedin|https://linkedin.com/in/username"><?php echo set_value('social_media', isset($row) ? $row['social_media'] : ''); ?></textarea>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" <?php echo set_checkbox('is_active', '1', !isset($row) || $row['is_active']); ?> />
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo base_url('admin/lecturers'); ?>" class="btn btn-outline-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
