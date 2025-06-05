<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Kelola Prodi</h2>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Prodi</h6>
                <a href="<?php echo site_url('admin/add_prodi'); ?>" class="btn btn-primary">Tambah Prodi</a>
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
                                    <td>
                                        <?php
                                        $related_fakultas = array_filter($fakultas, function($f) use ($prodi) {
                                            return isset($prodi['id_fakultas']) && $f['id_fakultas'] == $prodi['id_fakultas'];
                                        });
                                        echo !empty($related_fakultas) ? array_values($related_fakultas)[0]['nama_fakultas'] : '-';
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('admin/edit_prodi/' . $prodi['id_prodi']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="<?php echo site_url('admin/delete_prodi/' . $prodi['id_prodi']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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