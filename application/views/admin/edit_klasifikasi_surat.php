<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Edit Klasifikasi Surat</h2>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Klasifikasi Surat</h6>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo site_url('admin/edit_klasifikasi_surat/' . $klasifikasi['id_klasifikasi_surat']); ?>">
                    <div class="form-group">
                        <label for="kode_surat">Kode Surat</label>
                        <input type="text" class="form-control" id="kode_surat" name="kode_surat" value="<?php echo $klasifikasi['kode_surat']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_surat">Nama Surat</label>
                        <input type="text" class="form-control" id="nama_surat" name="nama_surat" value="<?php echo $klasifikasi['nama_surat']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>