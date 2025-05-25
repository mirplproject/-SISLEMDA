<div class="container-fluid p-4">
    <h2 class="mb-4">Surat Masuk</h2>
    <div class="card">
        <div class="card-header bg-secondary text-white">
            Daftar Surat Masuk
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengirim</th>
                        <th>Judul Surat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($surat_masuk as $surat): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($surat->pengirim); ?></td>
                            <td><?php echo htmlspecialchars($surat->judul_surat); ?></td>
                            <td><?php echo htmlspecialchars($surat->created_at); ?></td>
                            <td><?php echo htmlspecialchars($surat->status); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>