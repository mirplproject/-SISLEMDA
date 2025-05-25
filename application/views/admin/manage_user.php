<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Kelola User</h2>
        <a href="<?php echo site_url('admin/add_user'); ?>" class="btn btn-primary mb-3">Tambah User</a>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['nama']; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td><?php echo $user['roles']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/edit_user/' . $user['id_user']); ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="<?php echo site_url('admin/delete_user/' . $user['id_user']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
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