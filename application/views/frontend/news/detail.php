<div class="page-header">
  <div class="container">
    <h1><?= html_escape($news['title']) ?></h1>
    <div class="meta" style="margin-top: 8px; display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
      <?php if ($news['category_name']): ?><span style="color: var(--color-accent-light, #60a5fa);"><?= html_escape($news['category_name']) ?></span><?php endif; ?>
      <?php if (isset($news['author_name']) && $news['author_name']): ?><span><?= lang('by') ?>: <?= html_escape($news['author_name']) ?></span><?php endif; ?>
      <span><?= $news['published_at'] ? date('d M Y', strtotime($news['published_at'])) : '' ?></span>
      <span><?= $news['view_count'] ? html_escape($news['view_count']) . ' ' . lang('viewed') : '' ?></span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container" style="max-width: 800px;">
    <a href="<?= base_url('berita') ?>" class="back-link">&larr; <?= lang('back') ?> <?= lang('to_news') ?></a>

    <?php if ($news['thumbnail']): ?>
    <div class="news-detail-thumb">
      <img src="<?= base_url('uploads/' . $news['thumbnail']) ?>" alt="<?= html_escape($news['title']) ?>">
    </div>
    <?php endif; ?>

    <div class="news-detail-body">
      <?= nl2br(html_escape(strip_tags($news['content']))) ?>
    </div>

    <?php if (isset($news['source_url']) && $news['source_url']): 
      $source_url = $news['source_url'];
      $host = parse_url($source_url, PHP_URL_HOST);
    ?>
    <div class="share-section">
      <?php if (preg_match('/instagram\.com\/(p|reel|tv)\//', $source_url)): ?>
        <blockquote class="instagram-media" data-instgrm-permalink="<?= html_escape($source_url) ?>" data-instgrm-version="14" style="background:#FFF;border:0;border-radius:3px;box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15);margin:1px;max-width:540px;min-width:326px;padding:0;width:calc(100% - 2px);"></blockquote>
        <script async defer src="//www.instagram.com/embed.js"></script>
      <?php elseif (preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)/', $source_url)): ?>
        <?php
          $yt_id = '';
          if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $source_url, $m)) $yt_id = $m[1];
          elseif (preg_match('/youtu\.be\/([^?]+)/', $source_url, $m)) $yt_id = $m[1];
        ?>
        <?php if ($yt_id): ?>
        <div class="video-embed-wrap" style="margin-bottom:0;">
          <iframe src="https://www.youtube.com/embed/<?= html_escape($yt_id) ?>" allowfullscreen></iframe>
        </div>
        <?php endif; ?>
      <?php else: ?>
        <div><span style="font-weight: 600;"><?= lang('source') ?>:</span> <a href="<?= html_escape($source_url) ?>" target="_blank" rel="noopener"><?= htmlspecialchars($host ?: $source_url) ?></a></div>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="share-section">
      <div class="share-section-label"><?= lang('share') ?></div>
      <div class="share-bar">
        <a href="https://facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" rel="noopener" class="share-btn">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          Facebook
        </a>
        <a href="https://twitter.com/intent/tweet?text=<?= urlencode($news['title']) ?>&url=<?= urlencode(current_url()) ?>" target="_blank" rel="noopener" class="share-btn">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          X
        </a>
        <a href="https://wa.me/?text=<?= urlencode($news['title'] . ' - ' . current_url()) ?>" target="_blank" rel="noopener" class="share-btn">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp
        </a>
        <a href="https://t.me/share/url?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($news['title']) ?>" target="_blank" rel="noopener" class="share-btn">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
          Telegram
        </a>
        <button class="share-btn" onclick="copyShareLink(this)" aria-label="<?= lang('copy_link') ?>">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7.24 2h5.27a2 2 0 011.15.38l.09.07 5.45 5.45a2 2 0 01.46.7l.05.14.04.17v5.27a2 2 0 01-1.85 2H7.24a2 2 0 01-2-1.85V4a2 2 0 011.85-2H12.5 7.24zm0 1.5a.5.5 0 00-.5.45v10.2a.5.5 0 00.5.5h9.6a.5.5 0 00.5-.5v-5.3L13 3.64l-.06-.04-.14-.1H7.24z"/><path d="M2.5 7.24v12.56a1.7 1.7 0 001.7 1.7h8.56a1.7 1.7 0 001.7-1.7v-.5a.75.75 0 00-1.5 0v.5a.2.2 0 01-.2.2H4.2a.2.2 0 01-.2-.2V7.24a.2.2 0 01.2-.2h.5a.75.75 0 000-1.5h-.5a1.7 1.7 0 00-1.7 1.7z"/></svg>
          <?= lang('copy_link') ?>
        </button>
      </div>
    </div>
  </div>
</section>

<?php if (isset($recent) && count($recent) > 0): ?>
<section class="section section-dark">
  <div class="container">
    <div class="section-header">
      <h2><?= lang('latest_news') ?></h2>
    </div>
    <div class="card-grid">
      <?php foreach ($recent as $r): ?>
      <a href="<?= base_url('berita/' . $r['slug']) ?>" class="card-dark" style="text-decoration: none; display: block;">
        <?php if ($r['thumbnail']): ?>
        <div style="aspect-ratio: 16/10; overflow: hidden; border-radius: 8px; margin-bottom: 12px;">
          <img src="<?= base_url('uploads/' . $r['thumbnail']) ?>" alt="<?= html_escape($r['title']) ?>" style="width:100%;height:100%;object-fit:cover;">
        </div>
        <?php endif; ?>
        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 8px; color: var(--color-on-dark, #fff);"><?= html_escape($r['title']) ?></h4>
        <p style="font-size: 14px; color: var(--color-on-dark-muted, rgba(255,255,255,0.7));"><?= character_limiter(strip_tags($r['content']), 100) ?></p>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
