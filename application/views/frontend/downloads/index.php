<div class="page-header">
  <div class="container">
    <h1><?= lang('download') ?></h1>
    <p><?= html_escape(isset($settings['subtitle_download']) && $settings['subtitle_download'] ? $settings['subtitle_download'] : lang('download_subtitle')) ?></p>
  </div>
</div>

<section class="section section-light">
  <div class="container" style="max-width: 800px;">
    <form method="get" action="<?= base_url('download') ?>" class="search-form">
      <input type="text" name="q" class="search-input" placeholder="<?= lang('search') ?> <?= strtolower(lang('download')) ?>..." value="<?= html_escape(isset($search) ? $search : '') ?>">
      <button type="submit" class="btn btn-primary btn-sm"><?= lang('search') ?></button>
      <?php if (isset($search) && $search): ?>
      <a href="<?= base_url('download') ?>" class="btn btn-outline btn-sm"><?= lang('reset') ?></a>
      <?php endif; ?>
    </form>

    <?php if (isset($files) && count($files) > 0): ?>
    <div class="download-list">
      <?php foreach ($files as $f):
        $ext = strtolower(pathinfo($f['file_path'], PATHINFO_EXTENSION));
        $icons = array('pdf' => '📄', 'doc' => '📝', 'docx' => '📝', 'xls' => '📊', 'xlsx' => '📊', 'ppt' => '📑', 'pptx' => '📑', 'jpg' => '🖼', 'png' => '🖼');
        $icon = isset($icons[$ext]) ? $icons[$ext] : '📁';
      ?>
      <div class="download-item">
        <div class="download-icon"><?= $icon ?></div>
        <div class="download-info">
          <h4><?= html_escape($f['title']) ?></h4>
          <div class="meta"><?= html_escape(strtoupper($ext)) ?> <?= $f['file_size'] ? '• ' . html_escape(round($f['file_size'] / 1024, 1)) . ' KB' : '' ?> <?= $f['download_count'] ? '• ' . html_escape($f['download_count']) . ' ' . lang('download_count') : '' ?></div>
          <?php if ($f['description']): ?><p style="font-size: 13px; color: var(--color-ink-muted); margin-top: 4px;"><?= html_escape(strip_tags(preg_replace('/<br\s*\/?>/i', "\n", $f['description']))) ?></p><?php endif; ?>
        </div>
        <a href="<?= base_url('uploads/' . $f['file_path']) ?>" target="_blank" class="btn btn-primary btn-sm download-btn" onclick="incrementDownload(<?= html_escape($f['id']) ?>)"><?= lang('download') ?></a>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state"><p><?= lang('no_downloads') ?></p></div>
    <?php endif; ?>
  </div>
</section>

<script>
function incrementDownload(id) {
  fetch('<?= base_url('download/increment/') ?>' + id);
}
</script>
