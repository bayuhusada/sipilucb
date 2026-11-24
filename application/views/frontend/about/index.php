<div class="page-header">
  <div class="container">
    <h1><?= lang('about') ?> <?= html_escape(isset($prodi['name']) ? $prodi['name'] : (isset($settings['site_name']) ? $settings['site_name'] : 'Teknik Sipil')) ?></h1>
    <p><?= lang('about_subtitle') ?> <?= html_escape(isset($prodi['name']) ? $prodi['name'] : '') ?></p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="about-layout">
      <?php if (isset($prodi['thumbnail']) && $prodi['thumbnail']): ?>
      <div class="about-image">
        <img src="<?= base_url('uploads/' . $prodi['thumbnail']) ?>" alt="<?= html_escape($prodi['name'] ?? '') ?>">
      </div>
      <?php endif; ?>
      <div class="about-content">
        <h2><?= html_escape($prodi['name'] ?? '') ?></h2>
        <div><?= nl2br(html_escape(strip_tags($prodi['description'] ?? ''))) ?></div>
        <?php if (isset($prodi['accreditation']) && $prodi['accreditation']): ?>
        <p style="margin-top: 16px; font-weight: 600;"><?= lang('accreditation') ?>: <?= html_escape($prodi['accreditation']) ?></p>
        <?php endif; ?>
        <?php if (isset($prodi['graduate_profile']) && $prodi['graduate_profile']): ?>
        <div style="margin-top: 24px;">
          <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px;"><?= lang('graduate_profile') ?></h3>
          <p style="line-height: 1.8;"><?= nl2br(html_escape(strip_tags(preg_replace('/<br\s*\/?>/i', "\n", $prodi['graduate_profile'])))) ?></p>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <?php if (($video_url = youtube_embed_url($prodi['video_url'] ?? '', false))): ?>
    <div class="video-embed-wrap" style="margin-top: 48px;">
      <iframe src="<?= $video_url ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php if (isset($prodi['vision']) && $prodi['vision']): ?>
<section class="section section-dark">
  <div class="container">
    <div class="section-header center">
      <h2 style="color: var(--color-on-dark, #fff);"><?= lang('vision') ?></h2>
    </div>
    <div style="text-align: center; font-size: 18px; line-height: 1.8; max-width: 720px; margin: 0 auto;"><?= nl2br(html_escape(strip_tags(preg_replace('/<br\s*\/?>/i', "\n", $prodi['vision'])))) ?></div>
    <?php if (isset($prodi['mission']) && $prodi['mission']): ?>
    <div style="margin-top: 48px;">
      <h3 style="text-align: center; font-size: 24px; font-weight: 600; margin-bottom: 24px; color: var(--color-on-dark, #fff);"><?= lang('mission') ?></h3>
      <div style="max-width: 720px; margin: 0 auto; line-height: 1.8; font-size: 16px;">
        <?= nl2br(html_escape(strip_tags(preg_replace('/<br\s*\/?>/i', "\n", $prodi['mission'])))) ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<section class="section section-light">
  <div class="container text-center">
    <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 16px;"><?= lang('about') ?> <?= html_escape(isset($settings['university_name']) ? $settings['university_name'] : '') ?></h2>
    <p style="max-width: 640px; margin: 0 auto; line-height: 1.8;"><?= html_escape(isset($settings['university_description']) ? $settings['university_description'] : '') ?></p>
    <?php $uni_url = isset($settings['university_url']) ? $settings['university_url'] : 'https://ucb.ac.id'; ?>
    <?php if ($uni_url): ?>
    <div class="mt-4">
      <a href="<?= html_escape($uni_url) ?>" target="_blank" rel="noopener" class="btn btn-outline"><?= lang('visit_website') ?> <?= html_escape(isset($settings['university_name']) ? $settings['university_name'] : '') ?></a>
    </div>
    <?php endif; ?>
  </div>
</section>
