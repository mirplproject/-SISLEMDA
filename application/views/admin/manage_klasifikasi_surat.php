<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Kelola Klasifikasi Surat</h2>
        <!-- Tombol Tambah Klasifikasi Surat -->
        <a href="<?php echo site_url('admin/add_klasifikasi_surat'); ?>" class="btn btn-primary mb-3">Tambah Klasifikasi Surat</a>

        <!-- Search Bar -->
        <div class="row mb-3">
            <div class="col-md-4">
                <form method="get" action="<?php echo site_url('admin/manage_klasifikasi_surat'); ?>">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Cari Kode atau Nama Surat..." value="<?php echo isset($search) ? $search : ''; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notifikasi -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Klasifikasi Surat</h6>
            </div>
            <div class="card-body">
                <!-- Tambahkan style overflow agar tabel bisa scroll horizontal -->
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-bordered" style="min-width: 600px;" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Surat</th>
                                <th>Nama Surat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($klasifikasi_surat)): ?>
                                <?php $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1; ?>
                                <?php foreach ($klasifikasi_surat as $klasifikasi): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $klasifikasi['kode_surat']; ?></td>
                                        <td><?php echo $klasifikasi['nama_surat']; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('admin/edit_klasifikasi_surat/' . $klasifikasi['id_klasifikasi_surat']); ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="<?php echo site_url('admin/delete_klasifikasi_surat/' . $klasifikasi['id_klasifikasi_surat']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus klasifikasi ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data klasifikasi surat.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-links">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>