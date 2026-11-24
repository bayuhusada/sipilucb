<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Auto Translate</h4>

    <div class="alert alert-info">
        <i class="bx bx-info-circle me-1"></i>
        Generate terjemahan EN / CN / DE / JA untuk semua konten yang sudah ada. Proses terjadi per tabel, satu per satu.
    </div>

    <div id="translate-result"></div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tipe Konten</th>
                            <th class="text-center">Total (ID)</th>
                            <th class="text-center">EN</th>
                            <th class="text-center">CN</th>
                            <th class="text-center">DE</th>
                            <th class="text-center">JA</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats as $s): ?>
                        <tr>
                            <td><strong><?php echo $s['label']; ?></strong></td>
                            <td class="text-center"><?php echo $s['total']; ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?php echo $s['missing_en'] > 0 ? 'warning' : 'success'; ?>">
                                    <?php echo $s['missing_en']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-<?php echo $s['missing_cn'] > 0 ? 'warning' : 'success'; ?>">
                                    <?php echo $s['missing_cn']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-<?php echo $s['missing_de'] > 0 ? 'warning' : 'success'; ?>">
                                    <?php echo $s['missing_de']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-<?php echo $s['missing_ja'] > 0 ? 'warning' : 'success'; ?>">
                                    <?php echo $s['missing_ja']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-generate-lang" data-table="<?php echo $s['table']; ?>" data-target="en" <?php echo $s['missing_en'] == 0 ? 'disabled' : ''; ?>>
                                        EN
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-info btn-generate-lang" data-table="<?php echo $s['table']; ?>" data-target="cn" <?php echo $s['missing_cn'] == 0 ? 'disabled' : ''; ?>>
                                        CN
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-generate-lang" data-table="<?php echo $s['table']; ?>" data-target="de" <?php echo $s['missing_de'] == 0 ? 'disabled' : ''; ?>>
                                        DE
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-dark btn-generate-lang" data-table="<?php echo $s['table']; ?>" data-target="ja" <?php echo $s['missing_ja'] == 0 ? 'disabled' : ''; ?>>
                                        JA
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
var csrfCookieName = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';

function getCsrfToken() {
    var match = document.cookie.match(new RegExp('(?:^|;\\s*)' + csrfCookieName + '\\s*=\\s*([^;]+)'));
    return match ? match[1] : '';
}

$(document).ready(function() {
    $(document).on('click', '.btn-generate-lang', function() {
        var btn = $(this);
        var table = btn.data('table');
        var target = btn.data('target');
        var label = target === 'en' ? 'English' : (target === 'cn' ? '中文' : (target === 'de' ? 'Deutsch' : '日本語'));

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Generating...');

        var postData = { table: table, target: target };
        postData[csrfTokenName] = getCsrfToken();

        $.ajax({
            url: '<?php echo base_url("admin/translate/generate_all"); ?>',
            method: 'POST',
            data: postData,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'done') {
                    $('#translate-result').html(
                        '<div class="alert alert-success alert-dismissible">' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '<i class="bx bx-check-circle me-1"></i> ' + res.message +
                        '</div>'
                    );
                    btn.text('Generate ' + label).prop('disabled', false);
                } else {
                    $('#translate-result').html(
                        '<div class="alert alert-danger alert-dismissible">' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '<i class="bx bx-x-circle me-1"></i> ' + (res.message || 'Gagal') +
                        '</div>'
                    );
                    btn.text('Generate ' + label).prop('disabled', false);
                }
            },
            error: function() {
                $('#translate-result').html(
                    '<div class="alert alert-danger alert-dismissible">' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                    '<i class="bx bx-x-circle me-1"></i> Gagal terhubung ke server' +
                    '</div>'
                );
                btn.text('Generate ' + label).prop('disabled', false);
            }
        });
    });
});
</script>
