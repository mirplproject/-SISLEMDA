<div class="container-fluid p-4">
    <h2 class="mb-4">Dashboard Dosen - <?php echo isset($user_name) ? htmlspecialchars($user_name) : 'Pengguna'; ?></h2>

    <div class="row g-3">
        <!-- Card Overview -->
        <div class="col-md-4 mb-3">
            <div class="card bg-light text-dark h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Total Surat LK</h5>
                    <p class="card-text display-4 text-center"><?php echo $total_surat; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Surat Pending</h5>
                    <p class="card-text display-4 text-center"><?php echo count($surat_pending); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Surat Disetujui</h5>
                    <p class="card-text display-4 text-center"><?php echo count($surat_approved); ?></p>
                </div>
            </div>
        </div>

        <!-- Form LK Button -->
        <div class="col-12 mb-3">
            <a href="<?php echo site_url('surat/create'); ?>" class="btn btn-success btn-lg w-100 w-md-auto">
                <i class="bi bi-journal-plus"></i> Buat Surat LK Baru
            </a>
        </div>

        <!-- History Surat -->
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Riwayat Surat LK
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
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($surat_history as $surat): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($surat->judul_surat); ?></td>
                                    <td><?php echo htmlspecialchars($surat->status); ?></td>
                                    <td><?php echo htmlspecialchars($surat->created_at); ?></td>
                                    <td>
                                        <?php if ($surat->status == 'draft'): ?>
                                            <a href="<?php echo site_url('surat/submit/' . $surat->id); ?>" class="btn btn-primary btn-sm">Ajukan</a>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($surat->keterangan); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card { border: none; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
    .card-title { font-size: 1.1rem; }
    .display-4 { font-size: 2rem; font-weight: 600; }
    .w-md-auto { width: auto; }
    @media (max-width: 767px) {
        .col-md-4 { flex: 0 0 100%; max-width: 100%; }
        .btn-lg { width: 100%; }
        .table { font-size: 0.9rem; }
    }
</style>