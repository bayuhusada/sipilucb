<div class="page-header">
  <div class="container">
    <h1><?= html_escape($lecturer['front_title'] ? $lecturer['front_title'] . ' ' : '') ?><?= html_escape($lecturer['name']) ?><?= $lecturer['back_title'] ? ', ' . html_escape($lecturer['back_title']) : '' ?></h1>
    <p><?= html_escape($lecturer['position']) ?></p>
  </div>
</div>

<section class="section">
  <div class="container">
    <a href="<?= base_url('dosen') ?>" class="back-link">&larr; <?= lang('back') ?> <?= lang('to_lecturers') ?></a>

    <div class="lecturer-detail">
      <div>
        <div class="lecturer-detail-photo">
          <img src="<?= html_escape($lecturer['photo'] ? base_url('uploads/' . $lecturer['photo']) : base_url('assets/frontend/img/avatar-placeholder.svg')) ?>" alt="<?= html_escape($lecturer['name']) ?>">
        </div>
        <?php if ($lecturer['cv_file']): ?>
        <a href="<?= base_url('uploads/' . $lecturer['cv_file']) ?>" target="_blank" class="btn btn-outline btn-sm" style="margin-top: 16px; width: 100%; justify-content: center;"><?= lang('download_cv') ?></a>
        <?php endif; ?>
      </div>

      <div class="lecturer-detail-info">
        <h2><?= html_escape($lecturer['front_title'] ? $lecturer['front_title'] . ' ' : '') ?><?= html_escape($lecturer['name']) ?><?= $lecturer['back_title'] ? ', ' . html_escape($lecturer['back_title']) : '' ?></h2>
        <div class="position"><?= html_escape($lecturer['position']) ?></div>

        <div class="info-grid">
          <div class="info-grid-item">
            <div class="label">NIDN</div>
            <div class="value"><?= html_escape($lecturer['nidn'] ?: '-') ?></div>
          </div>
          <div class="info-grid-item">
            <div class="label"><?= lang('subject_area') ?></div>
            <div class="value"><?= html_escape($lecturer['expertise'] ?: '-') ?></div>
          </div>
          <div class="info-grid-item">
            <div class="label"><?= lang('email') ?></div>
            <div class="value"><?= html_escape($lecturer['email'] ?: '-') ?></div>
          </div>
          <div class="info-grid-item">
            <div class="label"><?= lang('phone') ?></div>
            <div class="value"><?= html_escape($lecturer['phone'] ?: '-') ?></div>
          </div>
        </div>

        <?php if ($lecturer['sinta_id'] || $lecturer['scopus_id'] || $lecturer['orcid'] || $lecturer['google_scholar']): ?>
        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px;">
          <?php if ($lecturer['google_scholar']): ?><a href="<?= html_escape($lecturer['google_scholar']) ?>" target="_blank" class="btn btn-sm btn-outline">Google Scholar</a><?php endif; ?>
          <?php if ($lecturer['sinta_id']): ?><a href="https://sinta.kemdikbud.go.id/authors/?id=<?= html_escape($lecturer['sinta_id']) ?>" target="_blank" class="btn btn-sm btn-outline">SINTA</a><?php endif; ?>
          <?php if ($lecturer['scopus_id']): ?><a href="https://www.scopus.com/authid/detail.uri?authorId=<?= html_escape($lecturer['scopus_id']) ?>" target="_blank" class="btn btn-sm btn-outline">Scopus</a><?php endif; ?>
          <?php if ($lecturer['orcid']): ?><a href="https://orcid.org/<?= html_escape($lecturer['orcid']) ?>" target="_blank" class="btn btn-sm btn-outline">ORCID</a><?php endif; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="lecturer-detail-sections">
      <?php if ($lecturer['education_history']): ?>
      <section>
        <h3><?= lang('education') ?></h3>
        <p><?= nl2br(html_escape(strip_tags($lecturer['education_history']))) ?></p>
      </section>
      <?php endif; ?>

      <?php if ($lecturer['publications']): ?>
      <section>
        <h3><?= lang('publications') ?></h3>
        <p><?= nl2br(html_escape(strip_tags($lecturer['publications']))) ?></p>
      </section>
      <?php endif; ?>

      <?php if ($lecturer['research']): ?>
      <section>
        <h3><?= lang('research') ?></h3>
        <p><?= nl2br(html_escape(strip_tags($lecturer['research']))) ?></p>
      </section>
      <?php endif; ?>

      <?php if ($lecturer['community_service']): ?>
      <section>
        <h3><?= lang('community_service') ?></h3>
        <p><?= nl2br(html_escape(strip_tags($lecturer['community_service']))) ?></p>
      </section>
      <?php endif; ?>
    </div>
  </div>
</section>
