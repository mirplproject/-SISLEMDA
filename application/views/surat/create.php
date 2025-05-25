<div class="container py-5">
    <h2 class="mb-4 text-center text-primary">Form Surat LK</h2>

    <div class="card shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-header bg-primary text-white">
            Isi Data Surat
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo site_url('surat/create'); ?>" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="judul_surat" class="form-label fw-bold">Judul Surat</label>
                    <input type="text" class="form-control" id="judul_surat" name="judul_surat" required placeholder="Masukkan judul surat">
                    <div class="invalid-feedback">
                        Judul surat wajib diisi.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="5" required placeholder="Masukkan keterangan surat"></textarea>
                    <div class="invalid-feedback">
                        Keterangan wajib diisi.
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Simpan sebagai Draft</button>
                    <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .invalid-feedback {
        display: none;
    }

    .needs-validation.was-validated .invalid-feedback {
        display: block;
    }

    @media (max-width: 576px) {
        .card {
            margin: 0 10px;
        }
    }
</style>
