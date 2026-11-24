<div class="page-header">
  <div class="container">
    <h1><?= lang('faq') ?></h1>
    <p><?= html_escape(isset($settings['section_faq_subtitle']) && $settings['section_faq_subtitle'] ? $settings['section_faq_subtitle'] : lang('faq') . ' ' . lang('about') . ' Teknik Sipil') ?></p>
  </div>
</div>

<section class="section">
  <div class="container" style="max-width: 720px;">
    <?php if (isset($faqs) && count($faqs) > 0): ?>
    <div class="faq-list">
      <?php foreach ($faqs as $f): ?>
      <div class="faq-item">
        <button class="faq-question"><?= html_escape($f['question']) ?> <span class="icon">+</span></button>
        <div class="faq-answer"><?= nl2br(html_escape(strip_tags($f['answer']))) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state"><p><?= lang('no_data') ?></p></div>
    <?php endif; ?>
  </div>
</section>
