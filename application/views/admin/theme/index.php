<style>
.theme-preview { border: 1px solid var(--bs-border-color); border-radius: 8px; overflow: hidden; margin-top: 16px; }
.theme-preview-navbar { display: flex; align-items: center; gap: 16px; padding: 10px 16px; background: #111111; color: white; font-size: 13px; }
.theme-preview-logo { font-weight: 700; font-size: 15px; }
.theme-preview-link { opacity: 0.7; }
.theme-preview-link.active { opacity: 1; background: rgba(255,255,255,0.08); padding: 4px 10px; border-radius: 4px; }
.theme-preview-hero { padding: 24px 16px; background: #1a1a1a; color: white; }
.theme-preview-badge { display: inline-block; padding: 2px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; margin-bottom: 8px; }
.theme-preview-title { font-size: 16px; font-weight: 700; margin-bottom: 12px; }
.theme-preview-highlight { background: #2563eb; padding: 0 6px; border-radius: 3px; }
.theme-preview-btn { display: inline-block; padding: 6px 20px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: default; margin-top: 8px; }
.theme-preview-footer { display: flex; align-items: center; padding: 10px 16px; background: #111111; color: rgba(255,255,255,0.6); font-size: 12px; }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Warna Tema</h4>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <?php echo form_open_multipart(''); ?>
                    <input type="hidden" name="mode" id="mode-input" value="easy">

                    <!-- Easy Mode -->
                    <div id="easy-mode">
                        <h6 class="fw-semibold mb-1">Mode Mudah</h6>
                        <p class="text-muted small mb-3">Ganti satu warna accent - semua warna navbar, tombol, footer, dan background akan menyesuaikan otomatis.</p>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Warna Accent</label>
                                <div class="input-group">
                                    <input type="color" name="color_accent" id="color_accent" class="form-control form-control-color" value="<?php echo html_escape(isset($settings['color_accent']) ? $settings['color_accent'] : '#2563eb'); ?>" style="max-width: 60px;">
                                    <input type="text" class="form-control color-hex" value="<?php echo html_escape(isset($settings['color_accent']) ? $settings['color_accent'] : '#2563eb'); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="theme-preview">
                            <div class="theme-preview-navbar" id="preview-navbar">
                                <span class="theme-preview-logo">Teknik Sipil</span>
                                <span class="theme-preview-link active">Beranda</span>
                                <span class="theme-preview-link">Tentang</span>
                                <span class="theme-preview-link">Prodi</span>
                            </div>
                            <div class="theme-preview-hero" id="preview-hero">
                                <div class="theme-preview-badge" id="preview-badge">Premium</div>
                                <div class="theme-preview-title">Fakultas <span class="theme-preview-highlight" id="preview-highlight">Teknik</span> - Teknik Sipil</div>
                                <div class="theme-preview-btn" id="preview-btn">Jelajahi</div>
                            </div>
                            <div class="theme-preview-footer" id="preview-footer">
                                <span>© 2026 Teknik Sipil UCB</span>
                            </div>
                        </div>
                    </div>

                    <!-- Advanced Mode Toggle -->
                    <div class="mt-4">
                        <a href="#" class="text-decoration-none" onclick="toggleAdvanced(); return false;" id="toggle-link">▼ Tampilkan mode lanjutan</a>
                    </div>

                    <!-- Advanced Mode -->
                    <div id="advanced-mode" style="display: none;" class="mt-3">
                        <h6 class="fw-semibold mb-1">Mode Lanjutan</h6>
                        <p class="text-muted small mb-3">Ubah setiap warna secara manual.</p>

                        <div class="row">
                            <?php
                            $color_fields = array(
                                'color_accent' => array('Accent (Biru)', '#2563eb'),
                                'color_accent_hover' => array('Accent Hover', '#1d4ed8'),
                                'color_accent_light' => array('Accent Light', '#60a5fa'),
                                'color_accent_soft' => array('Accent Soft', '#dbeafe'),
                                'color_accent_lime' => array('Accent Red (Merah)', '#dc2626'),
                                'color_accent_pink' => array('Accent Red Light', '#ef4444'),
                                'color_primary' => array('Primary (Navbar, Footer)', '#111111'),
                                'color_surface_dark' => array('Surface Dark (Hero, Section)', '#1a1a1a'),
                                'color_canvas' => array('Canvas (Bg Abu)', '#f5f5f5'),
                                'color_canvas_soft' => array('Canvas Soft (Bg Abu Tua)', '#e5e5e5'),
                                'color_canvas_hover' => array('Canvas Hover', '#d4d4d4'),
                                'color_ink' => array('Teks Utama', '#1f2937'),
                                'color_ink_muted' => array('Teks Redup', '#6b7280'),
                                'color_on_dark' => array('Teks Putih di Dark', '#ffffff'),
                                'color_on_dark_muted' => array('Teks di Atas Dark', 'rgba(255,255,255,0.7)'),
                                'color_hairline_violet' => array('Border Dark', '#374151'),
                                'color_hairline_cloud' => array('Border Light', '#e5e7eb'),
                                'color_wa_bg' => array('WhatsApp Bg', '#25d366'),
                            );
                            foreach ($color_fields as $key => $meta):
                            ?>
                            <div class="col-md-3 mb-3">
                                <label class="form-label small"><?php echo html_escape($meta[0]); ?></label>
                                <div class="input-group input-group-sm">
                                    <?php if (strpos($meta[1], 'rgba') !== false): ?>
                                    <input type="text" name="<?php echo html_escape($key); ?>" class="form-control form-control-sm" value="<?php echo html_escape(isset($settings[$key]) ? $settings[$key] : $meta[1]); ?>" placeholder="<?php echo html_escape($meta[1]); ?>" disabled>
                                    <?php else: ?>
                                    <input type="color" name="<?php echo html_escape($key); ?>" class="form-control form-control-color" value="<?php echo html_escape(isset($settings[$key]) ? $settings[$key] : $meta[1]); ?>" style="max-width: 40px;" disabled>
                                    <input type="text" class="form-control form-control-sm adv-hex" value="<?php echo html_escape(isset($settings[$key]) ? $settings[$key] : $meta[1]); ?>" readonly>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Simpan Tema</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Preview Langsung</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Pilih warna accent di mode mudah untuk melihat pratinjau.</p>
                    <div id="live-preview" class="p-3 rounded" style="background: #1a1a1a; color: white; text-align: center; min-height: 120px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;">
                        <span id="live-badge" style="background: #dbeafe; color: #2563eb; padding: 2px 10px; border-radius: 4px; font-size: 11px; font-weight: 600;">NEW</span>
                        <span id="live-text" style="font-size: 18px; font-weight: 600;">Preview Warna</span>
                        <span id="live-btn" style="background: #2563eb; color: white; padding: 6px 20px; border-radius: 6px; font-size: 13px; font-weight: 600;">Tombol</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleAdvanced() {
    var adv = document.getElementById('advanced-mode');
    var link = document.getElementById('toggle-link');
    var modeInput = document.getElementById('mode-input');
    var inputs = adv.querySelectorAll('input');
    if (adv.style.display === 'none') {
        adv.style.display = 'block';
        link.textContent = '▲ Sembunyikan mode lanjutan';
        modeInput.value = 'advanced';
        inputs.forEach(function(el) { el.removeAttribute('disabled'); });
    } else {
        adv.style.display = 'none';
        modeInput.value = 'easy';
        link.textContent = '▼ Tampilkan mode lanjutan';
        inputs.forEach(function(el) { el.setAttribute('disabled', 'disabled'); });
    }
}

// Live preview update
document.getElementById('color_accent').addEventListener('input', function() {
    var c = this.value;
    document.querySelector('.color-hex').value = c;

    // Calculate derived colors via PHP-side logic (simplified CSS preview)
    var preview = document.getElementById('live-preview');
    var badge = document.getElementById('live-badge');
    var btn = document.getElementById('live-btn');
    var highlight = document.getElementById('preview-highlight');

    preview.style.background = '#1a1a1a';
    badge.style.background = adjustBrightness(c, 35);
    badge.style.color = c;
    btn.style.background = c;
    if (highlight) highlight.style.background = c;

    // Theme preview update
    document.getElementById('preview-navbar').style.background = '#111111';
    document.getElementById('preview-hero').style.background = '#1a1a1a';
    document.getElementById('preview-footer').style.background = '#111111';
    document.getElementById('preview-btn').style.background = c;
    document.getElementById('preview-badge').style.background = adjustBrightness(c, 35);
    document.getElementById('preview-badge').style.color = c;
});

function adjustBrightness(hex, percent) {
    hex = hex.replace('#', '');
    if (hex.length === 3) hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
    var r = parseInt(hex.substr(0,2), 16);
    var g = parseInt(hex.substr(2,2), 16);
    var b = parseInt(hex.substr(4,2), 16);

    if (percent >= 0) {
        r = Math.round(r + (255 - r) * percent / 100);
        g = Math.round(g + (255 - g) * percent / 100);
        b = Math.round(b + (255 - b) * percent / 100);
    } else {
        var f = (100 + percent) / 100;
        r = Math.round(r * f);
        g = Math.round(g * f);
        b = Math.round(b * f);
    }

    r = Math.max(0, Math.min(255, r));
    g = Math.max(0, Math.min(255, g));
    b = Math.max(0, Math.min(255, b));

    return '#' + [r,g,b].map(function(x){ return ('0'+x.toString(16)).slice(-2); }).join('');
}

// Sync advanced color pickers
document.querySelectorAll('#advanced-mode input[type="color"]').forEach(function(p) {
    p.addEventListener('input', function() {
        var t = this.closest('.input-group').querySelector('.adv-hex');
        if (t) t.value = this.value;
    });
});
</script>
