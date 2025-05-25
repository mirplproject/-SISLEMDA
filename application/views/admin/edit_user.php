<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Edit Pengguna</h2>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Pengguna</h6>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo site_url('admin/edit_user/' . $user['id_user']); ?>">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $user['nama']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password (kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="inisial">Inisial</label>
                        <input type="text" class="form-control" id="inisial" name="inisial" value="<?php echo $user['inisial']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $user['nik']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Role Saat Ini</label>
                        <p>
                            <?php if (!empty($user['roles'])): ?>
                                <?php foreach ($user['roles'] as $role): ?>
                                    <span class="badge bg-primary text-white"><?php echo $role['nama_role']; ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted">Belum ada role</span>
                            <?php endif; ?>
                        </p>
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
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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