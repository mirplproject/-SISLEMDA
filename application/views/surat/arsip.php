<div class="container-fluid p-4">
    <h2 class="mb-4">Arsip</h2>
    <div class="card">
        <div class="card-header bg-info text-white">
            Daftar Arsip Surat
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Surat</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($surat_arsip as $surat): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($surat->judul_surat); ?></td>
                            <td><?php echo htmlspecialchars($surat->status); ?></td>
                            <td><?php echo htmlspecialchars($surat->created_at); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>