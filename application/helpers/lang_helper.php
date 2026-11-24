<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('lang'))
{
    function lang($line)
    {
        $result = get_instance()->lang->line($line);
        return $result !== false ? $result : $line;
    }
}

if (!function_exists('current_lang'))
{
    function current_lang()
    {
        return get_instance()->config->item('current_lang') ?: 'id';
    }
}

if (!function_exists('uri_path'))
{
    function uri_path()
    {
        return get_instance()->config->item('uri_path') ?: '';
    }
}

if (!function_exists('lang_tabs'))
{
    function lang_tabs()
    {
        static $counter = 0;
        $counter++;
        $uid = 'langset-' . $counter;
        $GLOBALS['_lang_tab_uid'] = $uid;
        return '
        <ul class="nav nav-tabs mb-3" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-id-' . $uid . '" data-bs-toggle="tab" data-bs-target="#lang-id-' . $uid . '" type="button" role="tab"><span class="badge bg-primary me-1">ID</span> Indonesia</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-en-' . $uid . '" data-bs-toggle="tab" data-bs-target="#lang-en-' . $uid . '" type="button" role="tab"><span class="badge bg-info me-1">EN</span> English</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-cn-' . $uid . '" data-bs-toggle="tab" data-bs-target="#lang-cn-' . $uid . '" type="button" role="tab"><span class="badge bg-secondary me-1">CN</span> 中文</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-de-' . $uid . '" data-bs-toggle="tab" data-bs-target="#lang-de-' . $uid . '" type="button" role="tab"><span class="badge bg-success me-1">DE</span> Deutsch</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-ja-' . $uid . '" data-bs-toggle="tab" data-bs-target="#lang-ja-' . $uid . '" type="button" role="tab"><span class="badge bg-warning me-1">JA</span> 日本語</button>
          </li>
        </ul>
        <div class="tab-content">';
    }
}

if (!function_exists('lang_tab_pane'))
{
    function lang_tab_pane($lang, $active = false)
    {
        $uid = isset($GLOBALS['_lang_tab_uid']) ? $GLOBALS['_lang_tab_uid'] : '0';
        $flags = array('id' => '🇮🇩', 'en' => '🇬🇧', 'cn' => '🇨🇳', 'de' => '🇩🇪', 'ja' => '🇯🇵');
        $label = array('id' => 'Indonesia', 'en' => 'English', 'cn' => '中文', 'de' => 'Deutsch', 'ja' => '日本語');
        $f = isset($flags[$lang]) ? $flags[$lang] : '';
        $a = $active ? ' show active' : '';
        return '<div class="tab-pane fade' . $a . '" id="lang-' . $lang . '-' . $uid . '" role="tabpanel">
          <div class="mb-2 text-muted small">' . $f . ' ' . (isset($label[$lang]) ? $label[$lang] : strtoupper($lang)) . '</div>';
    }
}

if (!function_exists('lang_tab_end'))
{
    function lang_tab_end()
    {
        return '</div>';
    }
}

if (!function_exists('lang_tabs_end'))
{
    function lang_tabs_end()
    {
        return '</div>';
    }
}

if (!function_exists('feature_icon_svg'))
{
    function feature_icon_svg($name)
    {
        $icons = array(
            'book' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
            'home' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
            'monitor' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
            'book-open' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
            'search' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>',
            'users' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'star' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
            'heart' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
            'globe' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
            'briefcase' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>',
            'award' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>',
            'message' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
            'pen' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>',
            'clock' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
            'graduation' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>',
            'lightbulb' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6"/><path d="M10 22h4"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"/></svg>',
            'target' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
        );
        return isset($icons[$name]) ? $icons[$name] : $icons['book'];
    }
}

if (!function_exists('safe_html'))
{
    function safe_html($str)
    {
        if (empty($str) || !is_string($str)) return '';
        $CI =& get_instance();
        return $CI->security->xss_clean($str);
    }
}

if (!function_exists('feature_icon_options'))
{
    function feature_icon_options($selected = 'book')
    {
        $labels = array(
            'book' => 'Buku',
            'home' => 'Rumah',
            'monitor' => 'Monitor',
            'book-open' => 'Buku Terbuka',
            'search' => 'Cari',
            'users' => 'Pengguna',
            'star' => 'Bintang',
            'heart' => 'Hati',
            'globe' => 'Global',
            'briefcase' => 'Koper',
            'award' => 'Penghargaan',
            'message' => 'Pesan',
            'pen' => 'Pena',
            'clock' => 'Jam',
            'graduation' => 'Wisuda',
            'lightbulb' => 'Lampu',
            'target' => 'Target',
        );
        $html = '';
        foreach ($labels as $key => $label) {
            $sel = $key === $selected ? 'selected' : '';
            $html .= '<option value="' . $key . '" ' . $sel . ' data-icon="' . htmlspecialchars(feature_icon_svg($key)) . '">' . $label . '</option>';
        }
        return $html;
    }
}
