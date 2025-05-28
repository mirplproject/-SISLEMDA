<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Kelola Role</h2>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-xl-12">
                <h2 class="mb-4">Tambah Role Baru</h2>
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Role</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo site_url('admin/add_role'); ?>">
                            <div class="form-group">
                                <label for="nama_role">Nama Role</label>
                                <input type="text" class="form-control" id="nama_role" name="nama_role" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah Role</button>
                            <a href="<?php echo site_url('admin/manage_role_user'); ?>" class="btn btn-secondary ml-2">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel daftar role -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($roles)): ?>
                            <?php foreach ($roles as $role): ?>
                                <tr>
                                    <td><?php echo $role['nama_role']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/edit_role/' . $role['id_role']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="<?php echo site_url('admin/delete_role/' . $role['id_role']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="2">Tidak ada data Role.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
