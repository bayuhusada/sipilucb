<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="deleteModalMessage">
                Yakin ingin menghapus?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <?php echo form_open('', array('id' => 'form-delete')); ?>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $(document).off('click', '.btn-delete').on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        var message = $(this).data('message') || 'Yakin ingin menghapus?';
        var returnUrl = $(this).data('return') || '';
        $('#deleteModalMessage').text(message);
        var form = $('#form-delete');
        form.attr('action', url);
        form.find('input[name="return_url"]').remove();
        if (returnUrl) {
            form.append('<input type="hidden" name="return_url" value="' + returnUrl + '">');
        }
        $('#deleteModal').modal('show');
    });
});
</script>