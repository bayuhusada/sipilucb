<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Pengaturan Website</h4>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <ul class="nav nav-pills mb-4">
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/umum'); ?>">Informasi Umum</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/hero'); ?>">Hero</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/sections'); ?>">Judul Section</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?php echo base_url('admin/settings/stats'); ?>">Statistik</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/kontak'); ?>">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/sosmed'); ?>">Sosial Media</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/footer'); ?>">Footer</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/settings/lainnya'); ?>">Lainnya</a></li>
    </ul>

    <div class="card">
        <div class="card-body">
            <?php echo form_open_multipart(''); ?>

            <?php if (!empty($translatable_fields)): ?>
            <div class="mb-3">
                <button type="button" class="btn btn-info btn-translate-all" data-fields='<?php echo json_encode($translatable_fields); ?>'>
                    🌐 Terjemahkan Semua ke EN, CN, DE &amp; JA
                </button>
                <small class="text-muted ms-2">Menerjemahkan semua field dari Bahasa Indonesia</small>
            </div>
            <?php endif; ?>

            <p class="text-muted mb-4">Angka statistik yang muncul di hero halaman depan. Bisa diganti sesuai data terbaru.</p>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Jumlah Mahasiswa Aktif</label>
                    <input type="number" name="stats_students" class="form-control" value="<?php echo html_escape(isset($settings['stats_students']) ? $settings['stats_students'] : '500') ?>" />
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah Lulusan (Alumni)</label>
                    <input type="number" name="stats_alumni" class="form-control" value="<?php echo html_escape(isset($settings['stats_alumni']) ? $settings['stats_alumni'] : '1200') ?>" />
                </div>
            </div>
 
            <hr />
            <h6 class="fw-semibold mb-3">Label Statistik <small class="text-muted">- teks yang muncul di bawah angka</small></h6>
            <div class="row mb-3">
                <div class="col-md-4"><label class="form-label">Dosen</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="stat_label_dosen_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_dosen_' . $l]) ? $settings['stat_label_dosen_' . $l] : ''); ?>" placeholder="Dosen" /><?php else: ?><div class="input-group"><input type="text" name="stat_label_dosen_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_dosen_' . $l]) ? $settings['stat_label_dosen_' . $l] : ''); ?>" placeholder="Dosen" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="stat_label_dosen" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                <div class="col-md-4"><label class="form-label">Berita</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="stat_label_berita_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_berita_' . $l]) ? $settings['stat_label_berita_' . $l] : ''); ?>" placeholder="Berita &amp; Artikel" /><?php else: ?><div class="input-group"><input type="text" name="stat_label_berita_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_berita_' . $l]) ? $settings['stat_label_berita_' . $l] : ''); ?>" placeholder="Berita &amp; Artikel" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="stat_label_berita" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                <div class="col-md-4"><label class="form-label">Agenda/Kegiatan</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="stat_label_kegiatan_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_kegiatan_' . $l]) ? $settings['stat_label_kegiatan_' . $l] : ''); ?>" placeholder="Kegiatan" /><?php else: ?><div class="input-group"><input type="text" name="stat_label_kegiatan_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_kegiatan_' . $l]) ? $settings['stat_label_kegiatan_' . $l] : ''); ?>" placeholder="Kegiatan" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="stat_label_kegiatan" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label class="form-label">Mahasiswa Aktif</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="stat_label_siswa_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_siswa_' . $l]) ? $settings['stat_label_siswa_' . $l] : ''); ?>" placeholder="Mahasiswa Aktif" /><?php else: ?><div class="input-group"><input type="text" name="stat_label_siswa_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_siswa_' . $l]) ? $settings['stat_label_siswa_' . $l] : ''); ?>" placeholder="Mahasiswa Aktif" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="stat_label_siswa" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                <div class="col-md-4"><label class="form-label">Alumni/Lulusan</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="stat_label_lulusan_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_lulusan_' . $l]) ? $settings['stat_label_lulusan_' . $l] : ''); ?>" placeholder="Lulusan" /><?php else: ?><div class="input-group"><input type="text" name="stat_label_lulusan_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_lulusan_' . $l]) ? $settings['stat_label_lulusan_' . $l] : ''); ?>" placeholder="Lulusan" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="stat_label_lulusan" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label class="form-label">Sekolah Mitra</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="stat_label_sekolah_mitra_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_sekolah_mitra_' . $l]) ? $settings['stat_label_sekolah_mitra_' . $l] : ''); ?>" placeholder="Sekolah Mitra" /><?php else: ?><div class="input-group"><input type="text" name="stat_label_sekolah_mitra_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_sekolah_mitra_' . $l]) ? $settings['stat_label_sekolah_mitra_' . $l] : ''); ?>" placeholder="Sekolah Mitra" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="stat_label_sekolah_mitra" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                <div class="col-md-4"><label class="form-label">Prestasi</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><?php if ($l === 'id'): ?><input type="text" name="stat_label_prestasi_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_prestasi_' . $l]) ? $settings['stat_label_prestasi_' . $l] : ''); ?>" placeholder="Prestasi" /><?php else: ?><div class="input-group"><input type="text" name="stat_label_prestasi_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_prestasi_' . $l]) ? $settings['stat_label_prestasi_' . $l] : ''); ?>" placeholder="Prestasi" /><button type="button" class="btn btn-outline-secondary btn-sm btn-regenerate-setting" data-field="stat_label_prestasi" data-target="<?php echo $l; ?>">🤖</button></div><?php endif; ?><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Pengaturan</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
