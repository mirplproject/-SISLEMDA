<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Kelola Prodi</h2>
        <a href="<?php echo site_url('admin/add_prodi'); ?>" class="btn btn-primary mb-3">Tambah Prodi</a>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Prodi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Prodi</th>
                                <th>Fakultas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prodis as $prodi): ?>
                                <tr>
                                    <td><?php echo $prodi['nama_prodi']; ?></td>
                                    <td><?php echo $prodi['nama_fakultas'] ?? '-'; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/edit_prodi/' . $prodi['id_prodi']); ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="<?php echo site_url('admin/delete_prodi/' . $prodi['id_prodi']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus prodi ini?')">Hapus</a>
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