<style>
    label {
        font-weight: bold;
    }
    input, select, textarea {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
</style>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Form Lembar Kendali </h1>
            <form action="<?php echo base_url('formlk/insert') ?>" method="post">
                <div class="col-10 mb-3">
                    <label for="No">No Surat</label>
                    <input type="number" name="no_surat" id="No" class="form-control" placeholder="Masukkan No Surat" required>
                </div>
                <div class="col-10 mb-3">
                    <label for="tgl">Tanggal Surat</label>
                    <input type="date" name="tgl_surat" id="tgl" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="perihal">Perihal</label>
                    <input type="text" name="perihal" id="perihal" class="form-control" placeholder="Masukkan Perihal Surat" required>
                </div>
                <div class="mb-3">
                    <label for="kode">Kode Pengajuan</label>
                    <select name="kode_pengajuan" id="kode" class="form-control" required>
                        <option value="">Pilih Kode Pengajuan</option>
                        <!-- <?php foreach($klasifikasi as $k):?>
                            <option value="<?= $k->kode_surat ?>">
                                <?= $k->kode_surat ?> - <?= $k->nama_surat ?>
                            </option>
                        <?php endforeach;?> -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tujuan">Tujuan Surat</label>
                    <input type="text" name="tujuan" id="tujuan" class="form-control" placeholder="Masukkan Tujuan Surat" required>
                </div>
                <div class="mb-3">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Masukkan Keterangan Surat" required></textarea>   
                </div>
                <div class="mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">Pilih Status</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tgl_selesai">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="catatan">Catatan</label>
                    <textarea name="catatan" id="catatan" class="form-control" placeholder="Masukkan Catatan"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>