<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Tambah Pengguna</h2>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Pengguna</h6>
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
                        <input type="text" class="form-control" id="inisial" name="inisial">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik">
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            <option value="">Pilih Role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role['id_role']; ?>">
                                    <?php echo $role['nama_role']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group prodi-field" style="display: none;">
                        <label for="prodi_id">Prodi</label>
                        <select class="form-control" id="prodi_id" name="prodi_id">
                            <option value="">Pilih Prodi</option>
                            <?php 
                            if (!empty($prodis)) {
                                foreach ($prodis as $prodi): ?>
                                    <option value="<?php echo $prodi['id_prodi']; ?>" data-fakultas="<?php echo isset($prodi['id_fakultas']) ? $prodi['id_fakultas'] : ''; ?>">
                                        <?php echo $prodi['nama_prodi']; ?>
                                    </option>
                                <?php endforeach;
                            } else {
                                echo '<option value="">Tidak ada data Prodi</option>';
                            } ?>
                        </select>
                        <small>Debug: <?php echo count($prodis); ?> Prodi ditemukan</small>
                    </div>
                    <div class="form-group fakultas-field" style="display: none;">
                        <label for="fakultas_id">Fakultas</label>
                        <select class="form-control" id="fakultas_id" name="fakultas_id">
                            <option value="">Pilih Fakultas</option>
                            <?php 
                            if (!empty($fakultas)) {
                                foreach ($fakultas as $fakultas_item): ?>
                                    <option value="<?php echo $fakultas_item['id_fakultas']; ?>">
                                        <?php echo $fakultas_item['nama_fakultas']; ?>
                                    </option>
                                <?php endforeach;
                            } else {
                                echo '<option value="">Tidak ada data Fakultas</option>';
                            } ?>
                        </select>
                        <small>Debug: <?php echo count($fakultas); ?> Fakultas ditemukan</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var roleSelect = document.getElementById('role_id');
    var prodiField = document.querySelector('.prodi-field');
    var fakultasField = document.querySelector('.fakultas-field');

    function updateFields() {
        var selectedRole = roleSelect.value;
        prodiField.style.display = 'none';
        fakultasField.style.display = 'none';

        if (selectedRole) {
            // Ambil nama role dari opsi yang dipilih
            var roleName = '';
            for (var i = 0; i < roleSelect.options.length; i++) {
                if (roleSelect.options[i].value == selectedRole) {
                    roleName = roleSelect.options[i].text;
                    break;
                }
            }

            if (roleName === 'dosen' || roleName === 'kaprodi') {
                prodiField.style.display = 'block';
                fakultasField.style.display = 'block'; // Fakultas otomatis terisi dari Prodi
            } else if (roleName === 'dekan') {
                fakultasField.style.display = 'block'; // Hanya Fakultas untuk dekan
            }
        }
    }

    roleSelect.addEventListener('change', updateFields);
    updateFields(); // Panggil saat halaman dimuat
});
</script>