<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Tambah Role untuk <?php echo $user['nama']; ?></h2>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Role</h6>
            </div>
            <div class="card-body">
                <p>Role saat ini: 
                    <?php foreach ($user_roles as $role): ?>
                        <span class="badge bg-primary text-white"><?php echo $role['nama_role']; ?></span>
                    <?php endforeach; ?>
                </p>
                <form method="post" action="<?php echo site_url('admin/assign_role/' . $user['id_user']); ?>">
                    <div class="form-group">
                        <label for="role_id">Tambah Role Baru</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            <option value="">Pilih Role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role['id_role']; ?>">
                                    <?php echo ucfirst($role['nama_role']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Role</button>
                </form>
            </div>
        </div>
    </div>
</div>