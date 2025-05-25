<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Kelola Klasifikasi Surat</h2>
        <a href="<?php echo site_url('admin/add_klasifikasi_surat'); ?>" class="btn btn-primary mb-3">Tambah Klasifikasi Surat</a>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Klasifikasi Surat</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode Surat</th>
                                <th>Nama Surat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($klasifikasi_surat as $klasifikasi): ?>
                                <tr>
                                    <td><?php echo $klasifikasi['kode_surat']; ?></td>
                                    <td><?php echo $klasifikasi['nama_surat']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/edit_klasifikasi_surat/' . $klasifikasi['id_klasifikasi_surat']); ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="<?php echo site_url('admin/delete_klasifikasi_surat/' . $klasifikasi['id_klasifikasi_surat']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus klasifikasi ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>