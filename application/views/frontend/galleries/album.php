<div class="page-header">
  <div class="container">
    <h1><?= html_escape($album['title']) ?></h1>
    <?php if ($album['description']): ?><p><?= html_escape(strip_tags(preg_replace('/<br\s*\/?>/i', "\n", $album['description']))) ?></p><?php endif; ?>
  </div>
</div>

<section class="section section-light">
  <div class="container">
    <a href="<?= base_url('galeri') ?>" class="back-link">&larr; <?= lang('back') ?> <?= lang('to_gallery') ?></a>

    <?php if (isset($images) && count($images) > 0): ?>
    <div class="masonry">
      <?php foreach ($images as $img): ?>
      <div data-lightbox="<?= base_url('uploads/' . $img['image']) ?>">
        <img src="<?= base_url('uploads/' . $img['image']) ?>" alt="<?= html_escape($img['caption'] ?: lang('photos')) ?>">
        <div class="overlay"><span>🔍</span></div>
        <?php if ($img['caption']): ?>
        <div style="padding: 8px 12px; font-size: 13px; color: var(--color-ink-muted);"><?= html_escape($img['caption']) ?></div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state"><p><?= lang('no_photos') ?></p></div>
    <?php endif; ?>
  </div>
</section>
