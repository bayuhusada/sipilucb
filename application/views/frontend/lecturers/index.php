<div class="page-header">
  <div class="container">
    <h1><?= lang('lecturers') ?></h1>
    <p><?= html_escape(isset($settings['subtitle_dosen']) && $settings['subtitle_dosen'] ? $settings['subtitle_dosen'] : lang('lecturers_subtitle')) ?></p>
  </div>
</div>

<section class="section section-light">
  <div class="container">
    <form method="get" action="<?= base_url('dosen') ?>" class="search-form">
      <input type="text" name="q" class="search-input" placeholder="<?= lang('search') ?> <?= strtolower(lang('lecturers')) ?>..." value="<?= html_escape(isset($search) ? $search : '') ?>">
      <button type="submit" class="btn btn-primary btn-sm"><?= lang('search') ?></button>
      <?php if (isset($search) && $search): ?>
      <a href="<?= base_url('dosen') ?>" class="btn btn-outline btn-sm"><?= lang('reset') ?></a>
      <?php endif; ?>
    </form>

    <?php if (isset($lecturers) && count($lecturers) > 0): ?>
    <div class="card-grid-4">
      <?php foreach ($lecturers as $l): ?>
      <a href="<?= base_url('dosen/' . $l['slug']) ?>" class="dosen-card" style="text-decoration: none; color: inherit;">
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
    <?= isset($pagination_links) ? $pagination_links : '' ?>
    <?php else: ?>
    <div class="empty-state"><p><?= lang('no_lecturers') ?></p></div>
    <?php endif; ?>
  </div>
</section>
