<div class="page-header">
  <div class="container">
    <h1><?= lang('news') ?></h1>
    <p><?= html_escape(isset($settings['subtitle_berita']) && $settings['subtitle_berita'] ? $settings['subtitle_berita'] : lang('news_subtitle')) ?></p>
  </div>
</div>

<section class="section section-light">
  <div class="container">
    <?php if (isset($categories) && count($categories) > 0): ?>
    <div class="cat-filters">
      <a href="<?= base_url('berita') ?>" class="btn btn-sm <?= !isset($current_category) ? 'btn-primary' : 'btn-outline' ?>"><?= lang('all') ?></a>
      <?php foreach ($categories as $cat): ?>
      <a href="<?= base_url('berita/kategori/' . $cat['slug']) ?>" class="btn btn-sm <?= (isset($current_category) && $current_category['id'] == $cat['id']) ? 'btn-primary' : 'btn-outline' ?>"><?= html_escape($cat['name']) ?></a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <form action="<?= base_url('search') ?>" method="get" class="search-form">
      <input type="text" name="q" class="search-input" placeholder="<?= lang('search_placeholder') ?>" value="">
      <button type="submit" class="btn btn-primary btn-sm"><?= lang('search') ?></button>
    </form>

    <?php if (isset($news) && count($news) > 0): ?>
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
          <div class="meta">
            <?php if (isset($n['author_name']) && $n['author_name']): ?><?= lang('by') ?> <?= html_escape($n['author_name']) ?> &middot; <?php endif; ?>
            <?= $n['view_count'] ? html_escape($n['view_count']) . ' ' . lang('viewed') : '' ?>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
    <div class="pagination">
      <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
      <a href="?page=<?= $i ?>" class="<?= $i == $pagination['page'] ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="empty-state"><p><?= lang('no_news') ?></p></div>
    <?php endif; ?>
  </div>
</section>
