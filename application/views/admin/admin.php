<div class="container mt-4">
    <h2 class="text-center mb-4">Dashboard Admin</h2>
    <h4 class="text-center mb-5">Jumlah Pengguna Berdasarkan Jabatan</h4>

    <div class="row g-4 justify-content-center">
        <?php
        $jabatanList = [
            'Admin' => 'Admin',
            'Dosen' => 'Dosen Biasa',
            'Kaprodi' => 'Kaprodi',
            'Dekan' => 'Dekan',
            'Warek1' => 'Warek1',
            'Warek2' => 'Warek2',
            'Rektor' => 'Rektor'
        ];

        foreach ($jabatanList as $key => $label): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card shadow h-100 border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= $label ?></h5>
                        <p class="card-text">
                            <?= isset($user_counts[$key]) ? $user_counts[$key] : 0 ?> Pengguna
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
