<div class="page-header">
  <div class="container">
    <h1><?= lang('agenda') ?></h1>
    <p><?= html_escape(isset($settings['subtitle_agenda']) && $settings['subtitle_agenda'] ? $settings['subtitle_agenda'] : lang('agenda_subtitle')) ?></p>
  </div>
</div>

<section class="section section-light">
  <div class="container" style="max-width: 800px;">
    <?php if (isset($agendas) && count($agendas) > 0): ?>
    <div class="agenda-list">
      <?php foreach ($agendas as $a): ?>
      <div class="agenda-item">
        <div class="agenda-date">
          <span class="day"><?= date('d', strtotime($a['start_date'])) ?></span>
          <span class="month"><?= date('M', strtotime($a['start_date'])) ?></span>
        </div>
        <div class="agenda-info">
          <h4><?= html_escape($a['title']) ?></h4>
          <p><?= character_limiter(strip_tags($a['description']), 200) ?></p>
          <?php if ($a['start_date'] != $a['end_date']): ?>
          <div style="font-size: 13px; color: var(--color-ink-muted, #6b7280); margin-top: 4px;"><?= date('d M Y', strtotime($a['start_date'])) ?> - <?= date('d M Y', strtotime($a['end_date'])) ?></div>
          <?php endif; ?>
        </div>
        <?php if ($a['location']): ?><div class="agenda-location">📍 <?= html_escape($a['location']) ?></div><?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state"><p><?= lang('no_agenda') ?></p></div>
    <?php endif; ?>
    <?= isset($pagination_links) ? $pagination_links : '' ?>
  </div>
</section>
