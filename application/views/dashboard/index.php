<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <h4 class="fw-bold">Dashboard</h4>
            <p>Selamat datang, <strong><?php echo html_escape($user['username']); ?></strong> (<?php echo html_escape(ucfirst(str_replace('_', ' ', $user['role']))); ?>)</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="fw-normal mb-1">User</h6>
                            <h4 class="mb-0"><?php echo $total_users; ?></h4>
                        </div>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-user"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="fw-normal mb-1">Dosen</h6>
                            <h4 class="mb-0"><?php echo $total_dosen; ?></h4>
                        </div>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-chalkboard"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="fw-normal mb-1">Berita</h6>
                            <h4 class="mb-0"><?php echo $total_berita; ?></h4>
                        </div>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-news"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="fw-normal mb-1">Agenda</h6>
                            <h4 class="mb-0"><?php echo $total_agenda; ?></h4>
                        </div>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="fw-normal mb-1">Galeri</h6>
                            <h4 class="mb-0"><?php echo $total_galeri; ?></h4>
                        </div>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-image"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="fw-normal mb-1">Download</h6>
                            <h4 class="mb-0"><?php echo $total_download; ?></h4>
                        </div>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-dark"><i class="bx bx-download"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="fw-normal mb-1">Pengunjung Hari Ini</h6>
                            <h4 class="mb-0"><?php echo number_format($today_visits); ?></h4>
                        </div>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-show"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Berita per Bulan</h5>
                </div>
                <div class="card-body">
                    <div id="chartBerita"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Berita: Draft vs Published</h5>
                </div>
                <div class="card-body">
                    <div id="chartDraft"></div>
                    <div class="text-center mt-3">
                        <span class="badge bg-warning me-2">Draft: <?php echo $berita_draft; ?></span>
                        <span class="badge bg-success">Published: <?php echo $berita_published; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pengunjung (30 Hari Terakhir)</h5>
                </div>
                <div class="card-body">
                    <div id="chartVisits"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Berita Paling Populer</h5>
                    <small>Total pengunjung semua waktu: <strong><?php echo number_format($total_visits); ?></strong></small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr><th>#</th><th>Judul</th><th>Dilihat</th></tr>
                            </thead>
                            <tbody>
                                <?php if (count($top_berita) > 0): $n = 1; ?>
                                <?php foreach ($top_berita as $b): ?>
                                <tr>
                                    <td><?php echo $n++; ?></td>
                                    <td><a href="<?php echo base_url('berita/' . html_escape($b['slug'])); ?>" target="_blank"><?php echo html_escape($b['title']); ?></a></td>
                                    <td><?php echo number_format($b['view_count']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr><td colspan="3" class="text-center">Belum ada berita.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Chart Berita per Bulan
    var beritaData = <?php echo json_encode($berita_per_bulan); ?>;
    new ApexCharts(document.getElementById('chartBerita'), {
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        series: [{ name: 'Berita', data: beritaData.map(function(d) { return d.count; }) }],
        xaxis: { categories: beritaData.map(function(d) { return d.month; }) },
        colors: ['#696cff'],
        plotOptions: { bar: { borderRadius: 4, columnWidth: '60%' } },
        dataLabels: { enabled: false }
    }).render();

    // Chart Draft vs Published
    new ApexCharts(document.getElementById('chartDraft'), {
        chart: { type: 'donut', height: 250 },
        series: [<?php echo $berita_draft; ?>, <?php echo $berita_published; ?>],
        labels: ['Draft', 'Published'],
        colors: ['#ffab00', '#71dd37'],
        legend: { position: 'bottom' },
        dataLabels: { enabled: true, formatter: function(v) { return parseInt(v) + '%'; } }
    }).render();

    // Chart Pengunjung
    var visitData = <?php echo json_encode($daily_visits); ?>;
    new ApexCharts(document.getElementById('chartVisits'), {
        chart: { type: 'area', height: 300, toolbar: { show: false } },
        series: [{ name: 'Pengunjung', data: visitData.map(function(d) { return d.hits; }) }],
        xaxis: { categories: visitData.map(function(d) { return d.date; }), labels: { rotate: -45, show: false } },
        colors: ['#696cff'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.1 } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        tooltip: { x: { show: true } }
    }).render();
});
</script>
