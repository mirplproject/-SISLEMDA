<div class="container-fluid p-4">
    <h2 class="mb-4">Status Surat</h2>
    <div class="card">
        <div class="card-header bg-primary text-white">
            Daftar Status Surat
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Surat</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($surat_status as $surat): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($surat->judul_surat); ?></td>
                            <td>
                                <span class="badge <?php echo $surat->status == 'draft' ? 'bg-warning' : ($surat->status == 'pending' ? 'bg-info' : ($surat->status == 'approved' ? 'bg-success' : 'bg-secondary')); ?>">
                                    <?php echo htmlspecialchars($surat->status); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($surat->created_at); ?></td>
                            <td>
                                <a href="<?php echo site_url('surat/detail/' . $surat->id); ?>" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>