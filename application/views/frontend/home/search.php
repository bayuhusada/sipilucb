<div class="page-header">
  <div class="container">
    <h1><?= lang('search_results_for') ?>: <?= html_escape($query) ?></h1>
    <p><?= html_escape(count($news)) ?> <?= lang('results_found') ?></p>
  </div>
</div>

<section class="section section-light">
  <div class="container">
    <form action="<?= base_url('search') ?>" method="get" class="search-form">
      <input type="text" name="q" class="search-input" placeholder="<?= lang('search_placeholder') ?>" value="<?= html_escape($query) ?>">
      <button type="submit" class="btn btn-primary btn-sm"><?= lang('search') ?></button>
    </form>

    <?php if (count($news) > 0): ?>
    <div class="news-list">
      <?php foreach ($news as $n): ?>
      <a href="<?= base_url('berita/' . $n['slug']) ?>" class="news-item" style="text-decoration: none; color: inherit;">
        <?php if ($n['thumbnail']): ?>
        <div class="news-item-thumb">
          <img src="<?= base_url('uploads/' . $n['thumbnail']) ?>" alt="<?= html_escape($n['title']) ?>">
        </div>
        <?php endif; ?>
        <div class="news-item-body">
          <?php if ($n['category_name']): ?><span class="tag"><?= html_escape($n['category_name']) ?></span><?php endif; ?>
          <div class="meta"><?= $n['published_at'] ? date('d M Y', strtotime($n['published_at'])) : '' ?></div>
          <h3><?= html_escape($n['title']) ?></h3>
          <p class="excerpt"><?= character_limiter(strip_tags($n['content']), 200) ?></p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state">
      <p><?= lang('no_results') ?> "<strong><?= html_escape($query) ?></strong>".</p>
    </div>
    <?php endif; ?>
  </div>
</section>
