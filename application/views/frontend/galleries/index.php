<div class="page-header">
  <div class="container">
    <h1><?= lang('gallery') ?></h1>
    <p><?= html_escape(isset($settings['subtitle_galeri']) && $settings['subtitle_galeri'] ? $settings['subtitle_galeri'] : lang('gallery_subtitle')) ?></p>
  </div>
</div>

<section class="section section-light">
  <div class="container">
    <form method="get" action="<?= base_url('galeri') ?>" class="search-form">
      <input type="text" name="q" class="search-input" placeholder="<?= lang('search') ?> <?= strtolower(lang('gallery')) ?>..." value="<?= html_escape(isset($search) ? $search : '') ?>">
      <button type="submit" class="btn btn-primary btn-sm"><?= lang('search') ?></button>
      <?php if (isset($search) && $search): ?>
      <a href="<?= base_url('galeri') ?>" class="btn btn-outline btn-sm"><?= lang('reset') ?></a>
      <?php endif; ?>
    </form>

    <?php if (isset($albums) && count($albums) > 0): ?>
    <div class="card-grid">
      <?php foreach ($albums as $a): ?>
      <a href="<?= base_url('galeri/' . $a['id']) ?>" class="album-card" style="text-decoration: none; color: inherit;">
        <div class="album-card-image">
          <?php if ($a['cover']): ?>
          <img src="<?= base_url('uploads/' . $a['cover']['image']) ?>" alt="<?= html_escape($a['title']) ?>">
          <?php else: ?>
          <div style="width:100%;height:100%;background:var(--color-accent-soft);display:flex;align-items:center;justify-content:center;font-size:48px;color:var(--color-accent);">📷</div>
          <?php endif; ?>
        </div>
        <div class="album-card-body">
          <h3><?= html_escape($a['title']) ?></h3>
          <div class="count"><?= html_escape($a['image_count']) ?> <?= lang('photos') ?></div>
          <?php if ($a['description']): ?><p style="font-size: 13px; color: var(--color-ink-muted); margin-top: 4px;"><?= html_escape(character_limiter(strip_tags(preg_replace('/<br\s*\/?>/i', "\n", $a['description'])), 80)) ?></p><?php endif; ?>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?= isset($pagination_links) ? $pagination_links : '' ?>
    <?php else: ?>
    <div class="empty-state"><p><?= lang('no_gallery') ?></p></div>
    <?php endif; ?>
  </div>
</section>
