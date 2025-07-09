<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Dashboard User</h2>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Selamat Datang, <?php echo htmlspecialchars($user_name); ?>!</h6>
            </div>
            <div class="card-body">
                <p>Selamat datang di dashboard user. Berikut adalah ringkasan aktivitas Anda dan informasi penting lainnya:</p>
                
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="<?php echo site_url('user/riwayat_pengajuan'); ?>" class="card border-left-primary shadow h-100 py-2 text-decoration-none text-dark">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Pengajuan
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($total_pengajuan); ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="<?php echo site_url('user/status_pengajuan'); ?>" class="card border-left-success shadow h-100 py-2 text-decoration-none text-dark">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Disposisi Masuk
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($total_disposisi_masuk); ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-inbox fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <?php if ($show_laporan_card): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="<?php echo site_url('user/laporan'); ?>" class="card border-left-info shadow h-100 py-2 text-decoration-none text-dark">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Total Laporan Pengajuan
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($total_laporan_pengajuan); ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>

                    <?php if ($show_arsip_card): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="<?php echo site_url('user/arsip'); ?>" class="card border-left-warning shadow h-100 py-2 text-decoration-none text-dark">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Total Arsip Sistem
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($total_arsip); ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-archive fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pengajuan Terbaru Anda</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="latestPengajuanTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No. Surat</th>
                                        <th>Perihal</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($latest_pengajuan_dashboard)): ?>
                                        <?php $no_dash = 1; ?>
                                        <?php foreach ($latest_pengajuan_dashboard as $data_dash): ?>
                                            <tr>
                                                <td><?php echo $no_dash++; ?></td>
                                                <td><?php echo htmlspecialchars($data_dash['no_surat']); ?></td>
                                                <td><?php echo htmlspecialchars($data_dash['perihal']); ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($data_dash['tanggal_pengajuan'])); ?></td>
                                                <td>
                                                    <?php
                                                        // Menggunakan helper function untuk warna badge status
                                                        $status_color_dash = get_status_badge_color($data_dash['status_pengajuan']);
                                                    ?>
                                                    <span class="badge rounded-pill text-bg-<?php echo $status_color_dash; ?>">
                                                        <?php echo htmlspecialchars(ucfirst($data_dash['status_pengajuan'])); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data pengajuan terbaru.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>