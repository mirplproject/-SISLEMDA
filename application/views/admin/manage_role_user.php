<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Kelola Role User</h2>

        <!-- Flashdata Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <!-- Search Bar -->
        <form method="get" action="<?php echo site_url('admin/manage_role_user'); ?>" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan username, nama, atau role..." value="<?php echo isset($search) ? $search : ''; ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <!-- Tabel Role User -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Fakultas</th>
                    <th>Prodi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['nama']; ?></td>
                            <td>
                                <?php echo $user['roles']; ?>
                                <br>
                                <a href="<?php echo site_url('admin/assign_role/' . $user['id_user']); ?>" class="btn btn-sm btn-success mt-1">Tambah Role</a>
                            </td>
                            <td><?php echo $user['nama_fakultas']; ?></td>
                            <td><?php echo $user['nama_prodi']; ?></td>
                            <td>
                                <?php if (!empty($user['role_details'])): ?>
                                    <?php foreach ($user['role_details'] as $role): ?>
                                        <?php if (count($user['role_details']) > 1): ?>
                                            <a href="<?php echo site_url('admin/remove_role/' . $user['id_user'] . '/' . $role['id_role']); ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')">Hapus <?php echo $role['nama_role']; ?></a><br>
                                        <?php else: ?>
                                            <span class="text-muted">Minimal 1 role</span><br>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada role</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data pengguna.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-links">
            <?php echo $pagination; ?>
        </div>
    </div>
</div>

