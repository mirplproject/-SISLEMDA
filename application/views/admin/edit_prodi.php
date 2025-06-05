<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Edit Prodi</h2>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Prodi</h6>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo site_url('admin/edit_prodi/' . $prodi['id_prodi']); ?>">
                    <div class="form-group">
                        <label for="nama_prodi">Nama Prodi</label>
                        <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" value="<?php echo $prodi['nama_prodi']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_fakultas">Fakultas</label>
                        <select class="form-control" id="id_fakultas" name="id_fakultas" required>
                            <option value="">Pilih Fakultas</option>
                            <?php foreach ($fakultas as $fakultas): ?>
                                <option value="<?php echo $fakultas['id_fakultas']; ?>" 
                                        <?php echo $prodi['id_fakultas'] == $fakultas['id_fakultas'] ? 'selected' : ''; ?>>
                                    <?php echo $fakultas['nama_fakultas']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Prodi</button>
                </form>
            </div>
        </div>
    </div>
</div>