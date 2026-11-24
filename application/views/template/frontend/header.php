<!DOCTYPE html>
<html lang="<?= current_lang() ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= html_escape(isset($meta_description) ? $meta_description : (isset($settings['site_name']) ? $settings['site_name'] : 'Teknik Sipil - Universitas Citra Bangsa')) ?>">
  <meta property="og:site_name" content="<?= html_escape(isset($settings['site_name']) ? $settings['site_name'] : 'Teknik Sipil') ?>">
  <meta property="og:title" content="<?= html_escape(isset($og_title) ? $og_title : (isset($title) ? $title : '')) ?>">
  <meta property="og:description" content="<?= html_escape(isset($meta_description) ? $meta_description : '') ?>">
  <meta property="og:url" content="<?= current_url() ?>">
  <meta property="og:type" content="<?= isset($og_type) ? $og_type : 'website' ?>">
  <?php if (isset($og_image) && $og_image): ?><meta property="og:image" content="<?= html_escape($og_image) ?>"><?php endif; ?>
  <meta name="twitter:card" content="summary_large_image">
  <link rel="alternate" hreflang="id" href="<?= base_url('id/' . uri_path()) ?>">
  <link rel="alternate" hreflang="en" href="<?= base_url('en/' . uri_path()) ?>">
  <link rel="alternate" hreflang="de" href="<?= base_url('de/' . uri_path()) ?>">
  <link rel="alternate" hreflang="ja" href="<?= base_url('ja/' . uri_path()) ?>">
  <link rel="alternate" hreflang="x-default" href="<?= base_url() ?>">
  <title><?= html_escape(isset($title) ? $title . ' | ' : '') ?><?= html_escape(isset($settings['site_name']) ? $settings['site_name'] : 'Teknik Sipil') ?></title>
  <link rel="icon" href="<?= (isset($settings['site_favicon']) && $settings['site_favicon']) ? base_url('uploads/' . html_escape($settings['site_favicon'])) : ((isset($settings['site_logo']) && $settings['site_logo']) ? base_url('uploads/' . html_escape($settings['site_logo'])) : base_url('assets/frontend/img/favicon.ico')) ?>" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/frontend/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/frontend/css/responsive.css') ?>">
<style>:root{
  --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  --font-display: 'Archivo', 'Inter', sans-serif;
  --font-mono: 'JetBrains Mono', 'SFMono-Regular', Consolas, monospace;
<?php
$color_keys = array(
    'color_accent' => '#04105c',
    'color_accent_hover' => '#030a36',
    'color_accent_light' => '#3d5af1',
    'color_accent_soft' => '#e7ecff',
    'color_accent_lime' => '#dc2626',
    'color_accent_pink' => '#ef4444',
    'color_primary' => '#04105c',
    'color_surface_dark' => '#0a1a70',
    'color_canvas' => '#ffffff',
    'color_canvas_soft' => '#f3f5fb',
    'color_canvas_hover' => '#e9edf8',
    'color_ink' => '#0d1636',
    'color_ink_muted' => '#5b6478',
    'color_on_dark' => '#ffffff',
    'color_on_dark_muted' => 'rgba(255,255,255,0.72)',
    'color_hairline_violet' => 'rgba(255,255,255,0.16)',
    'color_hairline_cloud' => '#e2e6ee',
    'color_wa_bg' => '#25d366',
);
foreach ($color_keys as $key => $default):
    $val = isset($settings[$key]) && $settings[$key] ? $settings[$key] : $default;
    echo '  --' . str_replace('_', '-', $key) . ': ' . $val . ";\n";
    // Compute RGB components for accent color (for rgba() usage)
    if ($key === 'color_accent') {
        $hex = ltrim($val, '#');
        if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        echo '  --color-accent-rgb: ' . $r . ', ' . $g . ', ' . $b . ";\n";
    }
endforeach;
?>}</style>
<?php
// Track page view
$this->db->query("INSERT INTO page_hits (hit_date, hits) VALUES (CURDATE(), 1) ON DUPLICATE KEY UPDATE hits = hits + 1");
?>
</head>
<body>

<nav class="nav-bar">
  <div class="nav-inner">
    <a href="<?= base_url() ?>" class="nav-logo">
      <?php if (isset($settings['site_logo']) && $settings['site_logo']): ?>
        <img src="<?= base_url('uploads/' . html_escape($settings['site_logo'])) ?>" alt="<?= html_escape(isset($settings['site_name']) ? $settings['site_name'] : 'Teknik Sipil') ?>">
      <?php endif; ?>
      <span><?= html_escape(isset($settings['site_name']) ? $settings['site_name'] : 'Teknik Sipil') ?></span>
    </a>
    <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">&#9776;</button>
    <ul class="nav-links" id="navLinks">
      <?php
      $nav_menus = $this->menu_model->get_by_location('header', current_lang());
      $nav_menus = array_filter($nav_menus, function($nm) {
          return !in_array(trim($nm['url'], '/'), ['', '#']);
      });
      ?>
      <li><a href="<?= base_url(current_lang()) ?>" class="<?= isset($active_nav) && $active_nav === 'home' ? 'active' : '' ?>"><?= lang('home') ?></a></li>
      <?php
      $current_url = rtrim(current_url(), '/');
      foreach ($nav_menus as $nm):
        $is_ext = strpos($nm['url'], '://') !== false;
        $menu_path = current_lang() . '/' . trim($nm['url'], '/');
        $nm_url = $is_ext ? $nm['url'] : base_url($menu_path);
        $nm_active = $is_ext ? '' : (($current_url === $nm_url) ? ' active' : '');
        $nm_target = $nm['target'] === '_blank' ? ' target="_blank" rel="noopener"' : '';
      ?>
      <li><a href="<?= html_escape($nm_url) ?>" class="<?= html_escape($nm_active) ?>"<?= html_escape($nm_target) ?>><?= html_escape($nm['label']) ?></a></li>
      <?php endforeach; ?>
    </ul>
    <div class="lang-wrap">
      <button class="lang-btn" id="langBtn" onclick="toggleLang(event)">
        <span id="langLabel"><?= strtoupper(current_lang()) ?></span>
        <span class="arrow">&#9662;</span>
      </button>
      <div class="lang-dropdown" id="langDropdown">
        <a href="<?= base_url('id/' . uri_path()) ?>" class="<?= current_lang() === 'id' ? 'active' : '' ?>"><span class="flag">🇮🇩</span> Indonesia</a>
        <a href="<?= base_url('en/' . uri_path()) ?>" class="<?= current_lang() === 'en' ? 'active' : '' ?>"><span class="flag">🇬🇧</span> English</a>
        <a href="<?= base_url('cn/' . uri_path()) ?>" class="<?= current_lang() === 'cn' ? 'active' : '' ?>"><span class="flag">🇨🇳</span> 中文</a>
        <a href="<?= base_url('de/' . uri_path()) ?>" class="<?= current_lang() === 'de' ? 'active' : '' ?>"><span class="flag">🇩🇪</span> Deutsch</a>
        <a href="<?= base_url('ja/' . uri_path()) ?>" class="<?= current_lang() === 'ja' ? 'active' : '' ?>"><span class="flag">🇯🇵</span> 日本語</a>
      </div>
    </div>
  </div>
</nav>

<script>
function toggleLang(e) {
    e.stopPropagation();
    document.getElementById('langDropdown').classList.toggle('show');
    document.getElementById('langBtn').classList.toggle('open');
}
document.addEventListener('click', function() {
    var dd = document.getElementById('langDropdown');
    if (dd) dd.classList.remove('show');
    var btn = document.getElementById('langBtn');
    if (btn) btn.classList.remove('open');
});
</script>
