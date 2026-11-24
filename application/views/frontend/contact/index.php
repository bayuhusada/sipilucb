<div class="page-header">
  <div class="container">
    <h1><?= lang('contact') ?></h1>
    <p><?= html_escape(isset($settings['subtitle_kontak']) && $settings['subtitle_kontak'] ? $settings['subtitle_kontak'] : lang('contact_subtitle')) ?></p>
  </div>
</div>

<section class="section section-light">
  <div class="container">
    <div class="contact-info-grid">
      <div class="contact-info-item">
        <span class="icon">📍</span>
        <h4><?= html_escape(isset($settings['contact_address_label']) && $settings['contact_address_label'] ? $settings['contact_address_label'] : lang('address')) ?></h4>
        <p><?= isset($settings['site_address']) ? nl2br(html_escape($settings['site_address'])) : 'Jl. Manafe No. 17, Kel. Kayu Putih, Kec. Oebobo, Kota Kupang, NTT 85228' ?></p>
      </div>

      <div class="contact-info-item">
        <span class="icon">📞</span>
        <h4><?= html_escape(isset($settings['contact_phone_label']) && $settings['contact_phone_label'] ? $settings['contact_phone_label'] : lang('phone')) ?></h4>
        <p><?= html_escape(isset($settings['site_phone']) ? $settings['site_phone'] : '(0380) 833395') ?></p>
      </div>

      <div class="contact-info-item">
        <span class="icon">✉️</span>
        <h4><?= html_escape(isset($settings['contact_email_label']) && $settings['contact_email_label'] ? $settings['contact_email_label'] : lang('email')) ?></h4>
        <p><?= html_escape(isset($settings['site_email']) ? $settings['site_email'] : 'info@ucb.ac.id') ?></p>
      </div>

      <?php if (isset($settings['site_whatsapp']) && $settings['site_whatsapp']): ?>
      <div class="contact-info-item">
        <span class="icon">💬</span>
        <h4><?= lang('whatsapp') ?></h4>
        <p><a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['site_whatsapp']) ?>"><?= html_escape($settings['site_whatsapp']) ?></a></p>
      </div>
      <?php endif; ?>
    </div>

    <?php if (isset($settings['contact_map_url']) && $settings['contact_map_url']): ?>
    <div style="margin-top: 32px; border-radius: 12px; overflow: hidden;">
      <iframe src="<?= html_escape($settings['contact_map_url']) ?>" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
    <?php endif; ?>
  </div>
</section>
