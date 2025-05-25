<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Tambah User</h2>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah User</h6>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo site_url('admin/add_user'); ?>">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="inisial">Inisial</label>
                        <input type="text" class="form-control" id="inisial" name="inisial" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" required>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="form-control" id="role_id" name="role_id" required onchange="toggleRoleFields(this)">
                            <option value="">Pilih Role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role['id_role']; ?>" data-name="<?php echo $role['nama_role']; ?>">
                                    <?php echo ucfirst($role['nama_role']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="role_name" id="role_name">
                    </div>
                    <div class="form-group" id="prodi_field" style="display: none;">
                        <label for="prodi_id">Prodi</label>
                        <select class="form-control" id="prodi_id" name="prodi_id">
                            <option value="">Pilih Prodi</option>
                            <?php foreach ($prodis as $prodi): ?>
                                <option value="<?php echo $prodi['id_prodi']; ?>"><?php echo $prodi['nama_prodi']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" id="fakultas_field" style="display: none;">
                        <label for="fakultas_id">Fakultas</label>
                        <select class="form-control" id="fakultas_id" name="fakultas_id">
                            <option value="">Pilih Fakultas</option>
                            <?php foreach ($fakultas as $f): ?>
                                <option value="<?php echo $f['id_fakultas']; ?>"><?php echo $f['nama_fakultas']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah User</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function toggleRoleFields(select) {
    var roleName = select.options[select.selectedIndex].getAttribute('data-name');
    document.getElementById('role_name').value = roleName;
    var prodiField = document.getElementById('prodi_field');
    var fakultasField = document.getElementById('fakultas_field');
    prodiField.style.display = 'none';
    fakultasField.style.display = 'none';
    if (roleName === 'dosen' || roleName === 'kaprodi') {
        prodiField.style.display = 'block';
    } else if (roleName === 'dekan') {
        fakultasField.style.display = 'block';
    }
}
</script>