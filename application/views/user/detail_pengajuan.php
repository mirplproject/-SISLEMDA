<div class="container mt-4">
    <h4 class="mb-4 fw-bold">Detail Arsip Pengajuan</h4>

    <div class="card shadow-sm rounded-4">
        <div class="card-body">

            <!-- Informasi Pengajuan -->
            <div class="mb-3">
                <strong>No Surat:</strong><br>
                <?= htmlspecialchars($row->no_surat ?? '-') ?>
            </div>

            <div class="mb-3">
                <strong>Nama Pengaju:</strong><br>
                <?= htmlspecialchars($row->nama_user ?? $row->id_user) ?>
            </div>

            <div class="mb-3">
                <strong>Tanggal Pengajuan:</strong><br>
                <?= isset($row->tanggal_pengajuan) ? date('d F Y', strtotime($row->tanggal_pengajuan)) : '-' ?>
            </div>

            <div class="mb-3">
                <strong>Perihal:</strong><br>
                <?= htmlspecialchars($row->perihal ?? '-') ?>
            </div>

            <div class="mb-3">
                <strong>Status Pengajuan:</strong><br>
                <span class="badge bg-<?= ($row->status_pengajuan == 'disetujui') ? 'success' : (($row->status_pengajuan == 'ditolak') ? 'danger' : 'secondary') ?>">
                    <?= ucfirst(htmlspecialchars($row->status_pengajuan ?? 'Belum diproses')) ?>
                </span>
            </div>

            <!-- Lampiran -->
            <div class="mb-3">
                <strong>Lampiran:</strong><br>
                <?php if (!empty($row->lampiran)): ?>
                    <ul class="list-unstyled">
                        <?php foreach ($row->lampiran as $lampiran): ?>
                            <li>
                                <a href="<?= base_url('uploads/' . $lampiran->file) ?>" target="_blank">
                                    <i class="bi bi-paperclip"></i> <?= htmlspecialchars($lampiran->file) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Tidak ada lampiran tersedia.</p>
                <?php endif; ?>
            </div>

            <!-- Riwayat Disposisi -->
            <div class="mb-3 mt-4">
                <strong>Riwayat Disposisi:</strong><br>

                <?php if (!empty($row->disposisi)): ?>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-sm align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Kepada YTH</th>
                                    <th>N/K</th>
                                    <th>Tanggal</th>
                                    <th>Disposisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($row->disposisi as $d): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($d->nama_tujuan ?? '-') ?></td>
                                        <td><?= htmlspecialchars($d->nik ?? '-') ?></td>
                                        <td><?= date('d/m/Y', strtotime($d->tanggal_disposisi)) ?></td>
                                        <td><?= htmlspecialchars($d->catatan) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tombol Unduh Disposisi -->
                    <div class="mt-3 text-end">
                        <a href="<?= site_url('Disposisi/unduh_disposisi/' . $row->id_pengajuan) ?>" class="btn btn-success">
                            <i class="bi bi-download me-1"></i> Unduh Disposisi
                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Tidak ada data disposisi.</p>
                <?php endif; ?>
            </div>

            <!-- Tombol Kembali -->
            <a href="<?= site_url('user/riwayat_pengajuan') ?>" class="btn btn-secondary mt-4">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

        </div>
    </div>
</div>