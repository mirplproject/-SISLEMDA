<div class="container-fluid p-4">
    <h2 class="mb-4">History Surat</h2>
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
                        <th>Aksi</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($surat_history as $surat): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($surat->judul_surat); ?></td>
                            <td><?php echo htmlspecialchars($surat->action); ?></td>
                            <td><?php echo htmlspecialchars($surat->keterangan); ?></td>
                            <td><?php echo htmlspecialchars($surat->created_at); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>