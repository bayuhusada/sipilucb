<section class="hero hero-slider blueprint-grid" id="heroSlider">
  <?php if (isset($banners) && count($banners) > 0): ?>
    <?php $i = 0; foreach ($banners as $b): ?>
    <div class="hero-slide <?= $i === 0 ? 'active' : '' ?>" style="background-image: url('<?= base_url('uploads/' . $b['image']) ?>');">
      <div class="container">
        <div class="hero-content">
          <span class="tech-label">TS &mdash; <?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?> / <?= count($banners) ?></span>
          <?php if ($b['title']): ?><h1><?= html_escape($b['title']) ?></h1><?php endif; ?>
          <?php if ($b['subtitle']): ?><p><?= html_escape($b['subtitle']) ?></p><?php endif; ?>
          <?php if ($b['link']): ?>
          <a href="<?= base_url($b['link']) ?>" class="btn btn-light"><?= lang('read_more') ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php $i++; endforeach; ?>
    <div class="slider-dots">
      <?php for ($j = 0; $j < count($banners); $j++): ?>
      <button class="slider-dot <?= $j === 0 ? 'active' : '' ?>" data-slide="<?= $j ?>"></button>
      <?php endfor; ?>
    </div>
    <div class="zdog-stage" aria-hidden="true"></div>
  <?php else: ?>
  <div class="hero-static">
    <div class="container">
      <div class="hero-content">
        <span class="tech-label">TS &mdash; 01</span>
        <h1><?= html_escape(isset($settings['hero_title']) && $settings['hero_title'] ? $settings['hero_title'] : lang('hero_default_title')) ?></h1>
        <p><?= html_escape(isset($settings['hero_subtitle']) && $settings['hero_subtitle'] ? $settings['hero_subtitle'] : lang('hero_default_desc')) ?></p>
        <a href="<?= isset($settings['hero_cta_link']) && $settings['hero_cta_link'] ? base_url($settings['hero_cta_link']) : base_url('tentang') ?>" class="btn btn-light"><?= html_escape(isset($settings['hero_cta_text']) && $settings['hero_cta_text'] ? $settings['hero_cta_text'] : lang('about_us')) ?></a>
      </div>
    </div>
    <div class="zdog-stage" aria-hidden="true"></div>
  </div>
  <?php endif; ?>
</section>

<?php if (isset($stats)): ?>
<section class="section blueprint-grid">
  <div class="container">
    <div class="section-header">
      <span class="tech-label">TS &mdash; DATA</span>
      <h2><?= html_escape(isset($settings['site_name']) ? $settings['site_name'] : 'Teknik Sipil UCB') ?> dalam Angka</h2>
    </div>
    <div class="stats-grid">
      <div class="stat-item reg-mark reveal">
        <div class="stat-value" data-target="<?= html_escape($stats['total_lecturers']) ?>">0</div>
        <div class="stat-label"><?= html_escape(isset($settings['stat_label_dosen']) && $settings['stat_label_dosen'] ? $settings['stat_label_dosen'] : lang('stat_dosen')) ?></div>
      </div>
      <div class="stat-item reg-mark reveal">
        <div class="stat-value" data-target="<?= html_escape($stats['total_students']) ?>">0</div>
        <div class="stat-label"><?= html_escape(isset($settings['stat_label_siswa']) && $settings['stat_label_siswa'] ? $settings['stat_label_siswa'] : lang('stat_siswa')) ?></div>
      </div>
      <div class="stat-item reg-mark reveal">
        <div class="stat-value" data-target="<?= html_escape($stats['total_alumni']) ?>">0</div>
        <div class="stat-label"><?= html_escape(isset($settings['stat_label_lulusan']) && $settings['stat_label_lulusan'] ? $settings['stat_label_lulusan'] : lang('stat_lulusan')) ?></div>
      </div>
      <div class="stat-item reg-mark reveal">
        <div class="stat-value" data-target="<?= html_escape($stats['total_berita']) ?>">0</div>
        <div class="stat-label"><?= html_escape(isset($settings['stat_label_berita']) && $settings['stat_label_berita'] ? $settings['stat_label_berita'] : lang('stat_berita')) ?></div>
      </div>
      <div class="stat-item reg-mark reveal">
        <div class="stat-value" data-target="<?= html_escape($stats['total_agenda']) ?>">0</div>
        <div class="stat-label"><?= html_escape(isset($settings['stat_label_kegiatan']) && $settings['stat_label_kegiatan'] ? $settings['stat_label_kegiatan'] : lang('stat_kegiatan')) ?></div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($about_prodi) && $about_prodi && !empty($about_prodi['name'])): ?>
<section class="section blueprint-grid">
  <div class="container">
    <div class="about-layout">
      <div class="about-image reg-mark reveal">
        <?php if (isset($about_prodi['thumbnail']) && $about_prodi['thumbnail']): ?>
        <img src="<?= base_url('uploads/' . $about_prodi['thumbnail']) ?>" alt="<?= html_escape($about_prodi['name']) ?>">
        <?php endif; ?>
      </div>
      <div class="about-content reveal">
        <span class="tech-label">TS &mdash; 02 / PRODI</span>
        <h2><?= html_escape($about_prodi['name']) ?></h2>
        <?php if (!empty($about_prodi['accreditation'])): ?>
        <span class="tag" style="display:inline-block;padding:4px 12px;margin-bottom:14px;background:rgba(4,16,92,0.08);color:#04105c;font-family:var(--font-mono,'JetBrains Mono',monospace);font-size:11px;letter-spacing:.06em;text-transform:uppercase;"><?= lang('accreditation') ?>: <?= html_escape($about_prodi['accreditation']) ?></span>
        <?php endif; ?>
        <p><?= character_limiter(strip_tags($about_prodi['description'] ?? ''), 320) ?></p>
        <a href="<?= isset($settings['about_cta_link']) && $settings['about_cta_link'] ? base_url($settings['about_cta_link']) : base_url('tentang') ?>" class="btn btn-primary"><?= html_escape(isset($settings['about_cta_text']) && $settings['about_cta_text'] ? $settings['about_cta_text'] : lang('read_more')) ?></a>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- FEATURED PROGRAMS -->
<section class="section section-light blueprint-grid">
  <div class="container">
    <div class="section-header">
      <span class="tech-label">TS &mdash; 03 / FOKUS</span>
      <h2><?= html_escape(isset($settings['section_featured_title']) && $settings['section_featured_title'] ? $settings['section_featured_title'] : lang('featured_programs')) ?></h2>
      <p><?= html_escape(isset($settings['section_featured_subtitle']) && $settings['section_featured_subtitle'] ? $settings['section_featured_subtitle'] : lang('featured_subtitle')) ?></p>
    </div>
    <div class="feature-grid">
      <?php for ($fi = 1; $fi <= 6; $fi++): ?>
      <?php $ficon = isset($settings['feature_' . $fi . '_icon']) && $settings['feature_' . $fi . '_icon'] ? $settings['feature_' . $fi . '_icon'] : ''; ?>
      <div class="feature-card reveal">
        <div class="feature-icon"><?= feature_icon_svg($ficon ?: 'book') ?></div>
        <h3><?= html_escape(isset($settings['feature_' . $fi . '_title']) && $settings['feature_' . $fi . '_title'] ? $settings['feature_' . $fi . '_title'] : lang('feature_' . $fi . '_title')) ?></h3>
        <p><?= html_escape(isset($settings['feature_' . $fi . '_desc']) && $settings['feature_' . $fi . '_desc'] ? $settings['feature_' . $fi . '_desc'] : lang('feature_' . $fi . '_desc')) ?></p>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- VISION & MISSION -->
<?php if (isset($about_prodi) && $about_prodi && (!empty($about_prodi['vision']) || !empty($about_prodi['mission']))): ?>
<section class="section blueprint-grid">
  <div class="container">
    <div class="section-header">
      <span class="tech-label">TS &mdash; 04 / VISI MISI</span>
      <h2><?= html_escape(isset($settings['section_vm_title']) && $settings['section_vm_title'] ? $settings['section_vm_title'] : lang('vision') . ' & ' . lang('mission')) ?></h2>
      <p><?= html_escape(isset($settings['section_vm_subtitle']) && $settings['section_vm_subtitle'] ? $settings['section_vm_subtitle'] : '') ?></p>
    </div>
    <div class="vm-grid">
      <div class="vm-card reg-mark reveal">
        <h3><?= lang('vision') ?></h3>
        <p><?= nl2br(html_escape(preg_replace('/<br\s*\/?>/i', "\n", $about_prodi['vision']))) ?></p>
      </div>
      <div class="vm-card reg-mark reveal">
        <h3><?= lang('mission') ?></h3>
        <?php
        $mission_clean = preg_replace('/<br\s*\/?>/i', "\n", $about_prodi['mission']);
        $mission_lines = array_filter(array_map('trim', explode("\n", $mission_clean)));
        if (count($mission_lines) > 1): ?>
        <ul>
          <?php foreach ($mission_lines as $line): ?>
          <?php if (!empty($line)): ?><li><?= html_escape($line) ?></li><?php endif; ?>
          <?php endforeach; ?>
        </ul>
        <?php else: ?>
        <p><?= nl2br(html_escape(preg_replace('/<br\s*\/?>/i', "\n", $about_prodi['mission']))) ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- LECTURERS -->
<?php if (isset($lecturers) && count($lecturers) > 0): ?>
<section class="section blueprint-grid">
  <div class="container">
    <div class="section-header">
      <span class="tech-label">TS &mdash; 05 / TIM</span>
      <h2><?= html_escape(isset($settings['section_dosen_title']) && $settings['section_dosen_title'] ? $settings['section_dosen_title'] : lang('lecturers')) ?></h2>
      <p><?= html_escape(isset($settings['section_dosen_subtitle']) && $settings['section_dosen_subtitle'] ? $settings['section_dosen_subtitle'] : lang('lecturers_subtitle')) ?></p>
    </div>
    <div class="card-grid-4">
      <?php foreach ($lecturers as $l): ?>
      <a href="<?= base_url('dosen/' . $l['slug']) ?>" class="dosen-card reveal" style="text-decoration: none; color: inherit;">
        <div class="dosen-card-photo">
          <img src="<?= html_escape($l['photo'] ? base_url('uploads/' . $l['photo']) : base_url('assets/frontend/img/avatar-placeholder.svg')) ?>" alt="<?= html_escape($l['name']) ?>">
        </div>
        <div class="dosen-card-body">
          <?php if ($l['front_title']): ?><span class="front-title"><?= html_escape($l['front_title']) ?></span><?php endif; ?>
          <h3><?= html_escape($l['name']) ?><?= $l['back_title'] ? ', ' . html_escape($l['back_title']) : '' ?></h3>
          <div class="position"><?= html_escape($l['position']) ?></div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a href="<?= isset($settings['dosen_view_all_link']) && $settings['dosen_view_all_link'] ? base_url($settings['dosen_view_all_link']) : base_url('dosen') ?>" class="btn btn-outline"><?= lang('view_all') ?> <?= lang('lecturers') ?></a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- AGENDA -->
<?php if (isset($agendas) && count($agendas) > 0): ?>
<section class="section section-light blueprint-grid">
  <div class="container">
    <div class="section-header">
      <span class="tech-label">TS &mdash; 06 / JADWAL</span>
      <h2><?= html_escape(isset($settings['section_agenda_title']) && $settings['section_agenda_title'] ? $settings['section_agenda_title'] : lang('upcoming_agenda')) ?></h2>
      <p><?= html_escape(isset($settings['section_agenda_subtitle']) && $settings['section_agenda_subtitle'] ? $settings['section_agenda_subtitle'] : lang('agenda_subtitle')) ?></p>
    </div>
    <div class="agenda-list">
      <?php foreach ($agendas as $a): ?>
      <div class="agenda-item reveal">
        <div class="agenda-date">
          <span class="day"><?= date('d', strtotime($a['start_date'])) ?></span>
          <span class="month"><?= date('M', strtotime($a['start_date'])) ?></span>
        </div>
        <div class="agenda-info">
          <h4><?= html_escape($a['title']) ?></h4>
          <p><?= character_limiter(strip_tags($a['description']), 150) ?></p>
        </div>
        <?php if ($a['location']): ?><div class="agenda-location"><?= html_escape($a['location']) ?></div><?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a href="<?= isset($settings['agenda_view_all_link']) && $settings['agenda_view_all_link'] ? base_url($settings['agenda_view_all_link']) : base_url('agenda') ?>" class="btn btn-light"><?= html_escape(isset($settings['agenda_view_all_text']) && $settings['agenda_view_all_text'] ? $settings['agenda_view_all_text'] : lang('view_all_agenda')) ?></a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- GALLERY -->
<?php if (isset($galleries) && count($galleries) > 0): ?>
<section class="section blueprint-grid">
  <div class="container">
    <div class="section-header">
      <span class="tech-label">TS &mdash; 07 / DOKUMENTASI</span>
      <h2><?= html_escape(isset($settings['section_gallery_title']) && $settings['section_gallery_title'] ? $settings['section_gallery_title'] : lang('gallery')) ?></h2>
      <p><?= html_escape(isset($settings['section_gallery_subtitle']) && $settings['section_gallery_subtitle'] ? $settings['section_gallery_subtitle'] : lang('gallery_subtitle')) ?></p>
    </div>
    <div class="gallery-grid">
      <?php foreach ($galleries as $g): ?>
      <a href="<?= base_url('galeri/' . $g['id']) ?>" class="gallery-item reveal">
        <?php if (!empty($g['cover'])): ?>
        <img src="<?= base_url('uploads/' . $g['cover']['image']) ?>" alt="<?= html_escape($g['title']) ?>">
        <?php else: ?>
        <div style="width:100%;height:100%;background:var(--color-accent-soft,#e7ecff);display:flex;align-items:center;justify-content:center;color:var(--color-accent,#04105c);font-size:40px;">&#128247;</div>
        <?php endif; ?>
        <div class="overlay"><span>&#128269;</span></div>
      </a>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a href="<?= isset($settings['gallery_view_all_link']) && $settings['gallery_view_all_link'] ? base_url($settings['gallery_view_all_link']) : base_url('galeri') ?>" class="btn btn-outline"><?= html_escape(isset($settings['gallery_view_all_text']) && $settings['gallery_view_all_text'] ? $settings['gallery_view_all_text'] : lang('view_all_gallery')) ?></a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- NEWS -->
<?php if (isset($news) && count($news) > 0): ?>
<section class="section section-light blueprint-grid">
  <div class="container">
    <div class="section-header">
      <span class="tech-label">TS &mdash; 08 / BERITA</span>
      <h2><?= html_escape(isset($settings['section_news_title']) && $settings['section_news_title'] ? $settings['section_news_title'] : lang('latest_news')) ?></h2>
      <p><?= html_escape(isset($settings['section_news_subtitle']) && $settings['section_news_subtitle'] ? $settings['section_news_subtitle'] : lang('news_subtitle')) ?></p>
    </div>
    <div class="news-card-grid">
      <?php foreach ($news as $n): ?>
      <div class="news-card reveal">
        <?php if ($n['thumbnail']): ?>
        <div class="news-card-thumb">
          <img src="<?= base_url('uploads/' . $n['thumbnail']) ?>" alt="<?= html_escape($n['title']) ?>">
        </div>
        <?php endif; ?>
        <div class="news-card-body">
          <?php if ($n['category_name']): ?><span class="tag"><?= html_escape($n['category_name']) ?></span><?php endif; ?>
          <h3><a href="<?= base_url('berita/' . $n['slug']) ?>"><?= html_escape($n['title']) ?></a></h3>
          <p class="excerpt"><?= character_limiter(strip_tags($n['content']), 120) ?></p>
          <?php if (isset($n['author_name']) && $n['author_name']): ?><div class="meta"><?= lang('by') ?> <?= html_escape($n['author_name']) ?></div><?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a href="<?= isset($settings['news_view_all_link']) && $settings['news_view_all_link'] ? base_url($settings['news_view_all_link']) : base_url('berita') ?>" class="btn btn-light"><?= html_escape(isset($settings['news_view_all_text']) && $settings['news_view_all_text'] ? $settings['news_view_all_text'] : lang('view_all_news')) ?></a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- FAQ -->
<?php if (isset($faqs) && count($faqs) > 0): ?>
<section class="section blueprint-grid">
  <div class="container">
    <div class="section-header">
      <span class="tech-label">TS &mdash; 09 / FAQ</span>
      <h2><?= html_escape(isset($settings['section_faq_title']) && $settings['section_faq_title'] ? $settings['section_faq_title'] : lang('faq')) ?></h2>
      <p><?= html_escape(isset($settings['section_faq_subtitle']) && $settings['section_faq_subtitle'] ? $settings['section_faq_subtitle'] : lang('faq') . ' ' . lang('about') . ' ' . lang('faculty')) ?></p>
    </div>
    <div class="faq-list">
      <?php foreach ($faqs as $f): ?>
      <div class="faq-item reveal">
        <button class="faq-question"><?= html_escape($f['question']) ?> <span class="icon">+</span></button>
        <div class="faq-answer"><?= nl2br(html_escape(strip_tags($f['answer']))) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="cta-band blueprint-grid">
  <div class="container">
    <span class="tech-label" style="color:rgba(255,255,255,0.7);">TS &mdash; 10 / PMB</span>
    <h2><?= html_escape(isset($settings['cta_band_title']) && $settings['cta_band_title'] ? $settings['cta_band_title'] : lang('cta_title')) ?></h2>
    <p><?= html_escape(isset($settings['cta_band_text']) && $settings['cta_band_text'] ? $settings['cta_band_text'] : lang('cta_text')) ?></p>
    <?php $cta_link = isset($settings['cta_band_button_link']) && $settings['cta_band_button_link'] ? $settings['cta_band_button_link'] : 'kontak'; ?>
    <a href="<?= base_url($cta_link) ?>" class="btn btn-light"><?= html_escape(isset($settings['cta_band_button_text']) && $settings['cta_band_button_text'] ? $settings['cta_band_button_text'] : lang('contact_us_now')) ?></a>
  </div>
</section>
