<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Galeri</h4>
        <a href="<?php echo base_url('admin/galleries/create'); ?>" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Tambah Album</a>
    </div>

    <div class="row">
        <?php foreach ($galleries as $g): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img class="card-img-top" src="<?php echo $g['cover_image'] ? base_url('uploads/' . html_escape($g['cover_image'])) : 'https://via.placeholder.com/400x250?text=No+Image'; ?>" alt="<?php echo html_escape($g['title']); ?>" style="height:180px;object-fit:cover" />
                <div class="card-body">
                    <h6 class="card-title"><?php echo html_escape($g['title']); ?></h6>
                    <div class="mb-2">
                        <?php if (!empty($g['lang_list'])): $langs = explode(',', $g['lang_list']); foreach ($langs as $l): ?>
                            <span class="badge bg-label-<?php echo $l === 'id' ? 'primary' : ($l === 'en' ? 'info' : ($l === 'de' ? 'success' : ($l === 'ja' ? 'warning' : 'secondary'))); ?> me-1"><?php echo strtoupper($l); ?></span>
                        <?php endforeach; endif; ?>
                    </div>
                    <p class="card-text small text-muted"><?php echo $g['description'] ? substr($g['description'], 0, 100) : ''; ?></p>
                    <div class="d-flex justify-content-between">
                        <span class="badge bg-label-<?php echo $g['is_active'] ? 'success' : 'secondary'; ?>"><?php echo $g['is_active'] ? 'Aktif' : 'Nonaktif'; ?></span>
                        <div>
                            <a href="<?php echo base_url('admin/galleries/edit/' . html_escape($g['id'])); ?>" class="btn btn-sm btn-icon btn-outline-secondary"><i class="bx bx-edit-alt"></i></a>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete" data-url="<?php echo base_url('admin/galleries/delete/' . html_escape($g['id'])); ?>" data-message="Hapus album?"><i class="bx bx-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($galleries)): ?>
        <div class="col-12 text-center py-5">Belum ada album.</div>
        <?php endif; ?>
    </div>
</div>
