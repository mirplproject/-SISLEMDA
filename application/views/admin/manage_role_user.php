<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Kelola Role User</h2>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna dan Role</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['nama']; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td>
                                        <?php foreach ($user['role_details'] as $role): ?>
                                            <span class="badge bg-primary text-white"><?php echo $role['nama_role']; ?></span>
                                            <a href="<?php echo site_url('admin/remove_role/' . $user['id_user'] . '/' . $role['id_role']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus role ini?')">Hapus</a>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('admin/assign_role/' . $user['id_user']); ?>" class="btn btn-sm btn-primary">Tambah Role</a>
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