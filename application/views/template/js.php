
    <style>
    .swal2-container.swal2-top-end {
        padding-top: 60px !important;
        z-index: 999999 !important;
    }
    #translate-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9999999;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    #translate-overlay.show {
        display: flex;
    }
    #translate-overlay .spinner {
        width: 48px; height: 48px;
        border: 4px solid #fff;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    #translate-overlay p {
        color: #fff;
        margin-top: 16px;
        font-size: 16px;
        font-weight: 500;
        text-align: center;
    }
    </style>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/popper/popper.min.js"></script>
    <script src="<?php echo base_url('assets/sneat')?>/assets/vendor/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="<?php echo base_url('assets/sneat')?>/assets/vendor/js/menu.min.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/apex-charts/apexcharts.min.js"></script>
    <script src="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/data-tables/datatables.min.js"></script>
	<script src="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/summernote/summernote-lite.min.js"></script>
	<script src="<?php echo base_url('assets/sneat')?>/assets/vendor/libs/sweetalert/sweetalert2.all.min.js"></script>


    <!-- Main JS -->
    <script src="<?php echo base_url('assets/sneat')?>/assets/js/main.min.js"></script>

    <!-- Page JS -->
    <script src="<?php echo base_url('assets/sneat')?>/assets/js/dashboards-analytics.min.js"></script>

<div id="translate-overlay">
    <div class="spinner"></div>
    <p>⟳ Menyimpan &amp; Menerjemahkan ke English &amp; 中文...</p>
</div>

<script>
	var csrfCookieName = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
	var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';

	function getCsrfToken() {
		var field = $('input[name="' + csrfTokenName + '"]').first().val();
		if (field !== undefined && field !== null && field !== '') return field;
		var match = document.cookie.match(new RegExp('(?:^|;\\s*)' + csrfCookieName + '\\s*=\\s*([^;]+)'));
		return match ? match[1] : '';
	}

	$(document).ready(function() {
		$('form').on('submit', function() {
			if ($(this).find('[name*="_id"]').length) {
				$('#translate-overlay').addClass('show');
			}
		});

		$(document).on('click', '.btn-regenerate', function(e) {
			e.preventDefault();
			var btn = $(this);
			var id = btn.data('id');
			var type = btn.data('type');
			var field = btn.data('field');
			var target = btn.data('target');
			var input = $('[name="' + field + '_' + target + '"]');

			btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

			var postData = { id: id, type: type, field: field, target_lang: target };
			postData[csrfTokenName] = getCsrfToken();

			$.ajax({
				url: '<?php echo base_url("admin/autotranslate/regenerate"); ?>',
				method: 'POST',
				data: postData,
				dataType: 'json',
				success: function(res) {
					if (res.status === 'done') {
						if (input.length) {
							if (input.hasClass('editor-rich')) {
								input.summernote('code', res.result);
							} else {
								input.val(res.result);
							}
						}
						Swal.fire({
							icon: 'success',
							title: '✅ Berhasil diterjemahkan!',
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 2000
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: '❌ ' + (res.message || 'Gagal menerjemahkan'),
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 4000
						});
					}
				},
				error: function() {
					Swal.fire({
						icon: 'error',
						title: '❌ Gagal terhubung ke server',
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000
					});
				},
				complete: function() {
					btn.prop('disabled', false).html('↻ Regenerate');
				}
			});
		});

		$(document).on('click', '.btn-regenerate-setting', function(e) {
			e.preventDefault();
			var btn = $(this);
			var field = btn.data('field');
			var target = btn.data('target');
			var input = $('[name="' + field + '_' + target + '"]');

			btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

			var postData = { field: field, target_lang: target };
			postData[csrfTokenName] = getCsrfToken();

			$.ajax({
				url: '<?php echo base_url("admin/autotranslate/regenerate_setting"); ?>',
				method: 'POST',
				data: postData,
				dataType: 'json',
				success: function(res) {
					if (res.status === 'done') {
						if (input.length) input.val(res.result);
						Swal.fire({
							icon: 'success',
							title: '✅ Berhasil diterjemahkan!',
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 2000
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: '❌ ' + (res.message || 'Gagal menerjemahkan'),
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 4000
						});
					}
				},
				error: function() {
					Swal.fire({
						icon: 'error',
						title: '❌ Gagal terhubung ke server',
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000
					});
				},
				complete: function() {
					btn.prop('disabled', false).html('🤖');
				}
			});
		});

		$(document).on('click', '.btn-translate-all', function(e) {
			e.preventDefault();
			var btn = $(this);
			var fields = btn.data('fields');
			if (!fields || !fields.length) return;

			btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menerjemahkan...');

			var postData = { fields: fields };
			postData[csrfTokenName] = getCsrfToken();

			$.ajax({
				url: '<?php echo base_url("admin/autotranslate/regenerate_all_settings"); ?>',
				method: 'POST',
				data: postData,
				dataType: 'json',
				success: function(res) {
					if (res.results) {
						res.results.forEach(function(item) {
							if (item.en) {
								$('[name="' + item.field + '_en"]').val(item.en);
							}
							if (item.cn) {
								$('[name="' + item.field + '_cn"]').val(item.cn);
							}
							if (item.de) {
								$('[name="' + item.field + '_de"]').val(item.de);
							}
							if (item.ja) {
								$('[name="' + item.field + '_ja"]').val(item.ja);
							}
						});
						var msg = (res.total || fields.length) + ' field berhasil diterjemahkan';
						if (res.errors && res.errors.length) {
							msg += '. ' + res.errors.length + ' gagal: ' + res.errors.join(', ');
						}
						Swal.fire({
							icon: res.status === 'done' ? 'success' : 'warning',
							title: '✅ ' + msg,
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 4000
						});
					}
				},
				error: function() {
					Swal.fire({
						icon: 'error',
						title: '❌ Gagal terhubung ke server',
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000
					});
				},
				complete: function() {
					btn.prop('disabled', false).html('🌐 Terjemahkan Semua ke EN, CN, DE & JA');
				}
			});
		});

		$('.btn-test-translator').click(function(e) {
			e.preventDefault();
			var btn = $(this);
			btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

			var postData = {};
			postData[csrfTokenName] = getCsrfToken();

			$.ajax({
				url: '<?php echo base_url("admin/autotranslate/test"); ?>',
				method: 'POST',
				data: postData,
				dataType: 'json',
				success: function(res) {
					if (res.results && Array.isArray(res.results)) {
						var lines = [];
						res.results.forEach(function(r) {
							var icon = r.status ? '✅' : '❌';
							lines.push(icon + ' ' + r.provider + ': ' + r.message);
						});
						Swal.fire({
							icon: 'info',
							title: 'Hasil Test Koneksi',
							html: lines.join('<br>'),
							toast: false,
							showConfirmButton: true,
							confirmButtonText: 'OK',
							timer: 8000
						});
					} else if (res.status) {
						Swal.fire({
							icon: 'success',
							title: '✅ ' + res.message,
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: '❌ ' + res.message,
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 5000
						});
					}
				},
				error: function() {
					Swal.fire({
						icon: 'error',
						title: '❌ Gagal terhubung ke server',
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000
					});
				},
				complete: function() {
					btn.prop('disabled', false).html('🔗 Test Koneksi');
				}
			});
		});
		
		$('.editor-rich').summernote({
			height: 300,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['table', ['table']],
				['insert', ['link', 'picture', 'video']],
				['view', ['fullscreen', 'codeview', 'help']]
			]
		});

		// Tips editor-rich: alert dengan tombol tutup di bawah tiap editor
		$('.editor-rich').each(function() {
			var $ed = $(this).next('.note-editor');
			if (!$ed.length || $ed.next('.editor-rich-alert').length) return;
			$('<div class="alert alert-primary alert-dismissible fade show editor-rich-alert mb-2" role="alert" style="font-size: .85rem; padding: 8px 14px;">' +
				'<strong>💡 Tips:</strong> Gunakan <b>Shift + Enter</b> untuk baris baru tanpa paragraf, agar tag HTML (&lt;p&gt;) tidak muncul di website. <br>' +
				'<strong>⚠️ Perhatian:</strong> Sebelum menyimpan, pastikan semua bahasa (EN, CN, DE, JA) sudah diterjemahkan. Bila ada yang kosong, gunakan tombol ↻ Regenerate atau 🌐 Terjemahkan Semua jika ada.' +
				'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>').insertAfter($ed);
		});


		<?php if ($msg = $this->session->flashdata('success')): ?>
		Swal.fire({
			icon: 'success',
			title: '<?php echo str_replace(array("\\", "'", "\r", "\n"), array("\\\\", "\\'", "", ""), html_escape($msg)); ?>',
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 4000
		});
		<?php endif; ?>
		<?php if ($msg = $this->session->flashdata('error')): ?>
		Swal.fire({
			icon: 'error',
			title: '<?php echo str_replace(array("\\", "'", "\r", "\n"), array("\\\\", "\\'", "", ""), html_escape($msg)); ?>',
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 4000
		});
		<?php endif; ?>

		$('.table-datatable').DataTable({
			language: {
				lengthMenu: 'Tampilkan _MENU_',
				zeroRecords: 'Tidak ada data ditemukan',
				info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
				infoEmpty: 'Tidak ada data',
				infoFiltered: '(difilter dari _MAX_ total data)',
				search: 'Cari:',
				paginate: {
					first: 'Pertama',
					previous: 'Sebelumnya',
					next: 'Berikutnya',
					last: 'Terakhir'
				}
			}
		});
	});
	</script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
