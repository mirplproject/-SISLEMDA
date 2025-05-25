<div class="container-fluid p-4">
    <h2 class="mb-4">Detail Surat</h2>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Informasi Surat
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Judul Surat:</strong> <?php echo htmlspecialchars($surat->judul_surat); ?></p>
                    <p><strong>Pengirim:</strong> <?php echo htmlspecialchars($surat->pengirim); ?></p>
                    <p><strong>Tanggal Dibuat:</strong> <?php echo htmlspecialchars($surat->created_at); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong> 
                        <span class="badge <?php echo $surat->status == 'draft' ? 'bg-warning' : ($surat->status == 'pending' ? 'bg-info' : ($surat->status == 'approved' ? 'bg-success' : 'bg-secondary')); ?>">
                            <?php echo htmlspecialchars($surat->status); ?>
                        </span>
                    </p>
                    <p><strong>Keterangan:</strong> <?php echo nl2br(htmlspecialchars($surat->keterangan)); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Riwayat Aksi
        </div>
        <div class="card-body">
            <?php if ($history): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Pelaku</th>
                            <th>Aksi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($history as $item): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($item->created_at); ?></td>
                                <td><?php echo htmlspecialchars($item->pelaku); ?></td>
                                <td><?php echo htmlspecialchars($item->action); ?></td>
                                <td><?php echo htmlspecialchars($item->keterangan); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Belum ada riwayat aksi untuk surat ini.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            Status Tracking
        </div>
        <div class="card-body">
            <?php if ($tracking): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($tracking as $track): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($track->created_at); ?></td>
                                <td><?php echo htmlspecialchars($track->role_name); ?></td>
                                <td>
                                    <span class="badge <?php echo $track->status == 'pending' ? 'bg-info' : ($track->status == 'approved' ? 'bg-success' : 'bg-secondary'); ?>">
                                        <?php echo htmlspecialchars($track->status); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Belum ada status tracking untuk surat ini.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-4">
        <a href="<?php echo site_url('surat/status'); ?>" class="btn btn-secondary">Kembali</a>
    </div>
</div>