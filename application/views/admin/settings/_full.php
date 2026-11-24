<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Pengaturan Website</h4>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <?php echo form_open_multipart(''); ?>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#tab-umum">
                        <i class="bx bx-info-circle me-1"></i>Informasi Umum
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab-hero">
                        <i class="bx bx-slideshow me-1"></i>Hero (Beranda)
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab-sections">
                        <i class="bx bx-layer me-1"></i>Judul Section
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab-stats">
                        <i class="bx bx-bar-chart-alt-2 me-1"></i>Statistik
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab-kontak">
                        <i class="bx bx-envelope me-1"></i>Kontak
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab-sosmed">
                        <i class="bx bx-share-alt me-1"></i>Sosial Media
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab-footer">
                        <i class="bx bx-edit-alt me-1"></i>Footer
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab-lainnya">
                        <i class="bx bx-dots-horizontal-rounded me-1"></i>Lainnya
                    </button>
                </li>
            </ul>

            <div class="tab-content">

                <!-- ============ TAB 1: INFORMASI UMUM ============ -->
                <div class="tab-pane fade show active" id="tab-umum">
                    <p class="text-muted mb-4">Informasi dasar tentang website Program Studi Teknik Sipil.</p>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Website <small class="text-muted">— tampil di navbar & tab browser</small></label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <input type="text" name="site_name_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['site_name_' . $l]) ? $settings['site_name_' . $l] : ''); ?>" />
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Deskripsi Website <small class="text-muted">— untuk SEO & meta tag</small></label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <textarea name="site_description_<?php echo $l; ?>" class="form-control" rows="2"><?php echo html_escape(isset($settings['site_description_' . $l]) ? $settings['site_description_' . $l] : ''); ?></textarea>
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Logo Website</label>
                            <input type="file" name="site_logo" class="form-control" accept="image/*" />
                            <small class="text-muted">Format: PNG / JPG. Maks 2 MB.</small>
                            <?php if (isset($settings['site_logo']) && $settings['site_logo']): ?>
                                <div class="mt-2"><img src="<?php echo base_url('uploads/' . html_escape($settings['site_logo'])); ?>" height="40" /></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Favicon <small class="text-muted">— ikon di tab browser</small></label>
                            <input type="file" name="site_favicon" class="form-control" accept="image/*" />
                            <small class="text-muted">Format: ICO / PNG, ukuran 32x32 px.</small>
                            <?php if (isset($settings['site_favicon']) && $settings['site_favicon']): ?>
                                <div class="mt-2"><img src="<?php echo base_url('uploads/' . html_escape($settings['site_favicon'])); ?>" height="32" /></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h6 class="fw-semibold mt-4 mb-3">Kontak Program Studi</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="site_email" class="form-control" value="<?php echo html_escape(isset($settings['site_email']) ? $settings['site_email'] : ''); ?>" placeholder="tekniksipil@ucb.ac.id" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="site_phone" class="form-control" value="<?php echo html_escape(isset($settings['site_phone']) ? $settings['site_phone'] : ''); ?>" placeholder="(+62) 361 234567" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">WhatsApp <small class="text-muted">— nomer dengan kode negara, tanpa +</small></label>
                            <input type="text" name="site_whatsapp" class="form-control" value="<?php echo html_escape(isset($settings['site_whatsapp']) ? $settings['site_whatsapp'] : ''); ?>" placeholder="628123456789" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Alamat Kampus</label>
                            <textarea name="site_address" class="form-control" rows="2"><?php echo html_escape(isset($settings['site_address']) ? $settings['site_address'] : ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- ============ TAB 2: HERO / BERANDA ============ -->
                <div class="tab-pane fade" id="tab-hero">
                    <p class="text-muted mb-4">Hero adalah banner besar di halaman depan website. Atur teks dan tombol yang muncul di sini.</p>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Label kecil (Eyebrow) <small class="text-muted">— teks kecil di atas judul</small></label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <input type="text" name="hero_eyebrow_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_eyebrow_' . $l]) ? $settings['hero_eyebrow_' . $l] : ''); ?>" />
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Judul Hero</label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <input type="text" name="hero_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_title_' . $l]) ? $settings['hero_title_' . $l] : ''); ?>" />
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Subtitle <small class="text-muted">— teks deskripsi di bawah judul</small></label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <textarea name="hero_subtitle_<?php echo $l; ?>" class="form-control" rows="2"><?php echo html_escape(isset($settings['hero_subtitle_' . $l]) ? $settings['hero_subtitle_' . $l] : ''); ?></textarea>
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                    </div>
                    <hr />
                    <h6 class="fw-semibold mb-3">Tombol di Hero</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Teks Tombol CTA Utama <small class="text-muted">— tombol pertama / solid</small></label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <input type="text" name="hero_cta_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_cta_text_' . $l]) ? $settings['hero_cta_text_' . $l] : ''); ?>" placeholder="Jelajahi Prodi" />
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Link Tombol <small class="text-muted">— tujuan saat diklik (contoh: tentang, berita)</small></label>
                            <input type="text" name="hero_cta_link" class="form-control" value="<?php echo html_escape(isset($settings['hero_cta_link']) ? $settings['hero_cta_link'] : ''); ?>" placeholder="tentang" />
                            <small class="text-muted">Kosongkan untuk langsung ke halaman Tentang.</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Teks Tombol Kedua <small class="text-muted">— tombol outline/ghost</small></label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <input type="text" name="hero_secondary_cta_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['hero_secondary_cta_text_' . $l]) ? $settings['hero_secondary_cta_text_' . $l] : ''); ?>" placeholder="Tentang Kami" />
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Link Tombol Kedua</label>
                            <input type="text" name="hero_secondary_cta_link" class="form-control" value="<?php echo html_escape(isset($settings['hero_secondary_cta_link']) ? $settings['hero_secondary_cta_link'] : ''); ?>" placeholder="tentang" />
                        </div>
                    </div>
                </div>

                <!-- ============ TAB 3: JUDUL SECTION ============ -->
                <div class="tab-pane fade" id="tab-sections">
                    <p class="text-muted mb-4">Setiap bagian di halaman depan punya label, judul, dan deskripsi singkat. Sesuaikan lewat sini.</p>

                    <h6 class="fw-semibold mb-3">Tentang Kami — di halaman depan</h6>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Eyebrow (label kecil)</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="about_eyebrow_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['about_eyebrow_' . $l]) ? $settings['about_eyebrow_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Teks Tombol</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="about_cta_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['about_cta_text_' . $l]) ? $settings['about_cta_text_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Link Tombol</label><input type="text" name="about_cta_link" class="form-control" value="<?php echo html_escape(isset($settings['about_cta_link']) ? $settings['about_cta_link'] : ''); ?>" /></div>
                    </div>

                    <h6 class="fw-semibold mb-3 mt-4">Berita</h6>
                    <div class="row mb-2">
                        <div class="col-md-4"><label class="form-label">Eyebrow</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_news_eyebrow_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_news_eyebrow_' . $l]) ? $settings['section_news_eyebrow_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Title</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_news_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_news_title_' . $l]) ? $settings['section_news_title_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Subtitle</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_news_subtitle_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_news_subtitle_' . $l]) ? $settings['section_news_subtitle_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Tombol "Lihat Semua"</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="news_view_all_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['news_view_all_text_' . $l]) ? $settings['news_view_all_text_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Link Tombol</label><input type="text" name="news_view_all_link" class="form-control" value="<?php echo html_escape(isset($settings['news_view_all_link']) ? $settings['news_view_all_link'] : ''); ?>" /></div>
                    </div>

                    <h6 class="fw-semibold mb-3 mt-4">Agenda</h6>
                    <div class="row mb-2">
                        <div class="col-md-4"><label class="form-label">Eyebrow</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_agenda_eyebrow_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_agenda_eyebrow_' . $l]) ? $settings['section_agenda_eyebrow_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Title</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_agenda_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_agenda_title_' . $l]) ? $settings['section_agenda_title_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Subtitle</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_agenda_subtitle_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_agenda_subtitle_' . $l]) ? $settings['section_agenda_subtitle_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Tombol "Lihat Semua"</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="agenda_view_all_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['agenda_view_all_text_' . $l]) ? $settings['agenda_view_all_text_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Link</label><input type="text" name="agenda_view_all_link" class="form-control" value="<?php echo html_escape(isset($settings['agenda_view_all_link']) ? $settings['agenda_view_all_link'] : ''); ?>" /></div>
                    </div>

                    <h6 class="fw-semibold mb-3 mt-4">Galeri</h6>
                    <div class="row mb-2">
                        <div class="col-md-4"><label class="form-label">Eyebrow</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_gallery_eyebrow_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_gallery_eyebrow_' . $l]) ? $settings['section_gallery_eyebrow_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Title</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_gallery_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_gallery_title_' . $l]) ? $settings['section_gallery_title_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Subtitle</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_gallery_subtitle_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_gallery_subtitle_' . $l]) ? $settings['section_gallery_subtitle_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Tombol "Lihat Semua"</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="gallery_view_all_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['gallery_view_all_text_' . $l]) ? $settings['gallery_view_all_text_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Link</label><input type="text" name="gallery_view_all_link" class="form-control" value="<?php echo html_escape(isset($settings['gallery_view_all_link']) ? $settings['gallery_view_all_link'] : ''); ?>" /></div>
                    </div>

                    <h6 class="fw-semibold mb-3 mt-4">FAQ</h6>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Eyebrow</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_faq_eyebrow_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_faq_eyebrow_' . $l]) ? $settings['section_faq_eyebrow_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Title</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_faq_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_faq_title_' . $l]) ? $settings['section_faq_title_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Subtitle</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="section_faq_subtitle_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['section_faq_subtitle_' . $l]) ? $settings['section_faq_subtitle_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>

                    <h6 class="fw-semibold mb-3 mt-4">Subtitle Halaman</h6>
                    <p class="text-muted small">Teks kecil di bawah judul setiap halaman.</p>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Dosen</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="subtitle_dosen_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['subtitle_dosen_' . $l]) ? $settings['subtitle_dosen_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Berita</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="subtitle_berita_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['subtitle_berita_' . $l]) ? $settings['subtitle_berita_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Agenda</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="subtitle_agenda_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['subtitle_agenda_' . $l]) ? $settings['subtitle_agenda_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Galeri</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="subtitle_galeri_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['subtitle_galeri_' . $l]) ? $settings['subtitle_galeri_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Download</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="subtitle_download_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['subtitle_download_' . $l]) ? $settings['subtitle_download_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Kontak</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="subtitle_kontak_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['subtitle_kontak_' . $l]) ? $settings['subtitle_kontak_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>
                </div>

                <!-- ============ TAB 4: STATISTIK ============ -->
                <div class="tab-pane fade" id="tab-stats">
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
                    <h6 class="fw-semibold mb-3">Label Statistik <small class="text-muted">— teks yang muncul di bawah angka</small></h6>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Dosen</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="stat_label_dosen_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_dosen_' . $l]) ? $settings['stat_label_dosen_' . $l] : ''); ?>" placeholder="Dosen" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Berita</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="stat_label_berita_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_berita_' . $l]) ? $settings['stat_label_berita_' . $l] : ''); ?>" placeholder="Berita & Artikel" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Agenda/Kegiatan</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="stat_label_kegiatan_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_kegiatan_' . $l]) ? $settings['stat_label_kegiatan_' . $l] : ''); ?>" placeholder="Kegiatan" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Mahasiswa Aktif</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="stat_label_siswa_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_siswa_' . $l]) ? $settings['stat_label_siswa_' . $l] : ''); ?>" placeholder="Mahasiswa Aktif" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Alumni/Lulusan</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="stat_label_lulusan_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['stat_label_lulusan_' . $l]) ? $settings['stat_label_lulusan_' . $l] : ''); ?>" placeholder="Lulusan" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>
                </div>

                <!-- ============ TAB 5: KONTAK ============ -->
                <div class="tab-pane fade" id="tab-kontak">
                    <p class="text-muted mb-4">Label-label pada form kontak dan informasi kontak yang tampil di halaman Kontak.</p>
                    <h6 class="fw-semibold mb-3">Label Form Kontak</h6>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Nama</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="contact_label_name_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_name_' . $l]) ? $settings['contact_label_name_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Email</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="contact_label_email_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_email_' . $l]) ? $settings['contact_label_email_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Subjek</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="contact_label_subject_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_subject_' . $l]) ? $settings['contact_label_subject_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Pesan</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="contact_label_message_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_message_' . $l]) ? $settings['contact_label_message_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Tombol Kirim</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="contact_label_submit_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_label_submit_' . $l]) ? $settings['contact_label_submit_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>

                    <h6 class="fw-semibold mb-3 mt-4">Informasi Kontak <small class="text-muted">— tampil di samping form kontak</small></h6>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Heading</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="contact_info_heading_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_info_heading_' . $l]) ? $settings['contact_info_heading_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Label Alamat</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="contact_address_label_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_address_label_' . $l]) ? $settings['contact_address_label_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                        <div class="col-md-4"><label class="form-label">Label Telepon</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="contact_phone_label_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_phone_label_' . $l]) ? $settings['contact_phone_label_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label class="form-label">Label Email</label><?php echo lang_tabs(); ?><?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?><?php echo lang_tab_pane($l, $i === 0); ?><input type="text" name="contact_email_label_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['contact_email_label_' . $l]) ? $settings['contact_email_label_' . $l] : ''); ?>" /><?php echo lang_tab_end(); ?><?php endforeach; ?><?php echo lang_tabs_end(); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Google Maps Embed URL</label>
                            <textarea name="contact_map_url" class="form-control" rows="2" placeholder="https://www.google.com/maps/embed?pb=..."><?php echo html_escape(isset($settings['contact_map_url']) ? $settings['contact_map_url'] : ''); ?></textarea>
                            <small class="text-muted">Dapatkan URL embed dari Google Maps -> Bagikan -> Embed.</small>
                        </div>
                    </div>
                </div>

                <!-- ============ TAB 6: SOSIAL MEDIA ============ -->
                <div class="tab-pane fade" id="tab-sosmed">
                    <p class="text-muted mb-4">Link sosial media yang muncul di footer. Kosongkan jika tidak punya.</p>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label"><i class="bx bxl-facebook me-1"></i> Facebook</label>
                            <input type="text" name="social_facebook" class="form-control" value="<?php echo html_escape(isset($settings['social_facebook']) ? $settings['social_facebook'] : ''); ?>" placeholder="https://facebook.com/..." />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><i class="bx bxl-instagram me-1"></i> Instagram</label>
                            <input type="text" name="social_instagram" class="form-control" value="<?php echo html_escape(isset($settings['social_instagram']) ? $settings['social_instagram'] : ''); ?>" placeholder="https://instagram.com/..." />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><i class="bx bxl-youtube me-1"></i> YouTube</label>
                            <input type="text" name="social_youtube" class="form-control" value="<?php echo html_escape(isset($settings['social_youtube']) ? $settings['social_youtube'] : ''); ?>" placeholder="https://youtube.com/..." />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label"><i class="bx bxl-twitter me-1"></i> Twitter / X</label>
                            <input type="text" name="social_twitter" class="form-control" value="<?php echo html_escape(isset($settings['social_twitter']) ? $settings['social_twitter'] : ''); ?>" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><i class="bx bxl-tiktok me-1"></i> TikTok</label>
                            <input type="text" name="social_tiktok" class="form-control" value="<?php echo html_escape(isset($settings['social_tiktok']) ? $settings['social_tiktok'] : ''); ?>" />
                        </div>
                    </div>
                </div>

                <!-- ============ TAB 7: FOOTER ============ -->
                <div class="tab-pane fade" id="tab-footer">
                    <p class="text-muted mb-4">Teks yang muncul di bagian bawah website.</p>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Copyright <small class="text-muted">— tahun & hak cipta</small></label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <input type="text" name="footer_copyright_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['footer_copyright_' . $l]) ? $settings['footer_copyright_' . $l] : ''); ?>" placeholder="© 2026 Teknik Sipil — Universitas Citra Bangsa" />
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Credit <small class="text-muted">— teks pengelola website</small></label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <input type="text" name="footer_credit_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['footer_credit_' . $l]) ? $settings['footer_credit_' . $l] : ''); ?>" placeholder="Dikelola oleh Tim Teknik Sipil" />
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                    </div>
                </div>

                <!-- ============ TAB 8: LAINNYA ============ -->
                <div class="tab-pane fade" id="tab-lainnya">
                    <h6 class="fw-semibold mb-3">CTA Band (Halaman Depan)</h6>
                    <p class="text-muted small">Banner ajakan di bagian bawah halaman depan, sebelum footer.</p>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Judul</label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <input type="text" name="cta_band_title_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['cta_band_title_' . $l]) ? $settings['cta_band_title_' . $l] : ''); ?>" />
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Teks Deskripsi</label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <textarea name="cta_band_text_<?php echo $l; ?>" class="form-control" rows="2"><?php echo html_escape(isset($settings['cta_band_text_' . $l]) ? $settings['cta_band_text_' . $l] : ''); ?></textarea>
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Teks Tombol</label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <input type="text" name="cta_band_button_text_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['cta_band_button_text_' . $l]) ? $settings['cta_band_button_text_' . $l] : ''); ?>" />
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Link Tombol <small class="text-muted">— halaman tujuan (contoh: kontak)</small></label>
                            <input type="text" name="cta_band_button_link" class="form-control" value="<?php echo html_escape(isset($settings['cta_band_button_link']) ? $settings['cta_band_button_link'] : ''); ?>" placeholder="kontak" />
                        </div>
                    </div>

                    <hr />
                    <h6 class="fw-semibold mb-3">Universitas</h6>
                    <p class="text-muted small">Informasi tentang Universitas Citra Bangsa, tampil di halaman Tentang.</p>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Universitas</label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <input type="text" name="university_name_<?php echo $l; ?>" class="form-control" value="<?php echo html_escape(isset($settings['university_name_' . $l]) ? $settings['university_name_' . $l] : ''); ?>" />
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">URL Website Universitas</label>
                            <input type="text" name="university_url" class="form-control" value="<?php echo html_escape(isset($settings['university_url']) ? $settings['university_url'] : ''); ?>" placeholder="https://ucb.ac.id" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Deskripsi Universitas</label>
                            <?php echo lang_tabs(); ?>
                            <?php foreach (['id', 'en', 'cn', 'de', 'ja'] as $i => $l): ?>
                            <?php echo lang_tab_pane($l, $i === 0); ?>
                            <textarea name="university_description_<?php echo $l; ?>" class="form-control" rows="3"><?php echo html_escape(isset($settings['university_description_' . $l]) ? $settings['university_description_' . $l] : ''); ?></textarea>
                            <?php echo lang_tab_end(); ?>
                            <?php endforeach; ?>
                            <?php echo lang_tabs_end(); ?>
                        </div>
                    </div>

                    <hr />
                    <h6 class="fw-semibold mb-3">Auto-Translate</h6>
                    <p class="text-muted small">Konfigurasi untuk menerjemahkan konten ID → EN/CN secara otomatis. Pilih provider dan masukkan API Key yang sesuai.</p>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label">API Key</label>
                            <input type="text" name="translator_api_key" class="form-control" value="<?php echo html_escape($settings['translator_api_key'] ?? ''); ?>" />
                        </div>
                        <div class="col-md-4 d-flex align-items-end pb-3">
                            <button type="button" class="btn btn-outline-secondary btn-test-translator">
                                <i class="bx bx-link me-1"></i>Test Koneksi
                            </button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Provider</label>
                            <select name="translator_provider" class="form-select">
                                <option value="google" <?php echo (($settings['translator_provider'] ?? 'google') === 'google') ? 'selected' : ''; ?>>Google Translate</option>
                                <option value="gemini" <?php echo (($settings['translator_provider'] ?? '') === 'gemini') ? 'selected' : ''; ?>>Google Gemini</option>
                                <option value="openrouter" <?php echo (($settings['translator_provider'] ?? '') === 'openrouter') ? 'selected' : ''; ?>>OpenRouter</option>
                            </select>
                            <small class="text-muted">
                                Google Translate: <a href="https://console.cloud.google.com/apis/credentials" target="_blank">Cloud Console</a> (gratis 500K char/bulan)<br />
                                Google Gemini: <a href="https://aistudio.google.com/apikey" target="_blank">aistudio.google.com</a> (gratis 60 req/menit)<br />
                                OpenRouter: <a href="https://openrouter.ai/keys" target="_blank">openrouter.ai/keys</a> (mulai ~$0.15/1M token)
                            </small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Model <small class="text-muted">— khusus Gemini / OpenRouter</small></label>
                            <input type="text" name="translator_model" class="form-control" value="<?php echo html_escape($settings['translator_model'] ?? 'gemini-2.0-flash'); ?>" placeholder="gemini-2.0-flash" />
                            <small class="text-muted">Gemini: <code>gemini-2.0-flash</code>. OpenRouter: <code>gpt-4o-mini</code>, <code>claude-3-haiku</code>, dll.</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estimasi Pemakaian Token</label>
                            <div class="form-control-plaintext fw-semibold">
                                <?php
                                $remaining = (int)($settings['translator_quota_remaining'] ?? 500000);
                                $used = 500000 - $remaining;
                                $pct = $remaining > 0 ? round(($used / 500000) * 100) : 100;
                                ?>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span><?php echo number_format($remaining); ?></span>
                                    <small class="text-muted">token tersisa</small>
                                </div>
                                <div class="progress" style="height:6px;">
                                    <div class="progress-bar bg-<?php echo $pct > 80 ? 'danger' : ($pct > 50 ? 'warning' : 'success'); ?>" style="width:<?php echo $pct; ?>%"></div>
                                </div>
                                <small class="text-muted">dari ±500.000 token/bulan (reset otomatis)</small>
                            </div>
                        </div>
                    </div>

                    <hr />
                    <h6 class="fw-semibold mb-3">Generate Massal</h6>
                    <p class="text-muted small">Terjemahkan semua konten yang belum memiliki terjemahan EN, CN, DE &amp; JA secara otomatis.</p>
                    <div class="d-flex gap-2 mb-3">
                        <a href="<?php echo base_url('admin/translate'); ?>" class="btn btn-primary">
                            <i class="bx bx-globe me-1"></i>Generate Semua Terjemahan
                        </a>
                    </div>

                    <hr />
                    <h6 class="fw-semibold mb-3">Mode Website</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="maintenance_mode" class="form-check-input" value="1" id="mm" <?php echo (($settings['maintenance_mode'] ?? '0') === '1') ? 'checked' : '' ?> />
                                <label class="form-check-label" for="mm">Aktifkan Mode Maintenance</label>
                                <small class="d-block text-muted">Jika diaktifkan, pengunjung akan melihat halaman "dalam perbaikan". Admin tetap bisa login.</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Pengaturan</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
