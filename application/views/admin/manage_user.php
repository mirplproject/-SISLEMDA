<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Kelola Pengguna</h2>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
            </div>
            <div class="card-body">
                <a href="<?php echo site_url('admin/add_user'); ?>" class="btn btn-primary mb-3">Tambah Pengguna</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Prodi</th>
                                <th>Fakultas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $user['nama']; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td><?php echo $user['roles']; ?></td>
                                    <td><?php echo $user['nama_prodi']; ?></td>
                                    <td><?php echo $user['nama_fakultas']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/edit_user/' . $user['id_user']); ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="<?php echo site_url('admin/delete_user/' . $user['id_user']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</a>
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