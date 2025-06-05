<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Edit Role</h2>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Role</h6>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo site_url('admin/edit_role/' . $role['id_role']); ?>">
                    <div class="form-group">
                        <label for="nama_role">Nama Role</label>
                        <input type="text" class="form-control" id="nama_role" name="nama_role" value="<?php echo $role['nama_role']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Role</button>
                    <a href="<?php echo site_url('admin/manage_role_user'); ?>" class="btn btn-secondary ml-2">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>