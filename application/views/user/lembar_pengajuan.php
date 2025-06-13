<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url('assets/template/css/pengajuan.css'); ?>" />
<div class="row">
    <div class="col-xl-12">
      <!-- <?php if ($this->session->flashdata('success')): ?>
        <div id="notif" class="notif-success">
          <?php echo $this->session->flashdata('success'); ?>
        </div>
      <?php endif; ?> -->
      <div class="container">
        <h2 class="mb-4">Lembar Pengajuan</h2>
        <form action="<?php echo site_url('surat/insert'); ?>" method="post" enctype="multipart/form-data" id="pengajuanForm">
          <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('id_user'); ?>">
          <div class="form-row">
              <div class="form-group">
              <label for="no">No</label>
              <input type="text" id="no" name="no" class="form-control" placeholder="Masukkan nomor pengajuan" required>
              </div>
              <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" id="tanggal" name="tanggal" value="<?php echo date('Y-m-d'); ?>" readonly>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group">
                <label for="bagian">Bagian</label>
                <select id="bagian" name="bagian" onchange="loadSubKode()">
                    <option value="">Pilih Bagian (opsional)</option>
                    <option value="1">1 - Rektor</option>
                    <option value="2">2 - Wakil Rektor Bidang Akademik</option>
                    <option value="3">3 - Wakil Rektor Bidang Non Akademik</option>
                    <option value="4">4 - Senat Akademik</option>
                    <option value="5">5 - Dekan</option>
                    <option value="6">6 - Program Studi</option>
                    <option value="7">7 - LPPM</option>
                    <option value="8">8 - Lembaga Kerjasama</option>
                    <option value="9">9 - PPM</option>
                    <option value="10">10 - Administrasi Akademik</option>
                    <option value="11">11 - Pangkalan Data & Sistem Informasi</option>
                    <option value="12">12 - Administrasi Pengembangan dan Kemahasiswaan, Karir dan Humas</option>
                    <option value="13">13 - Bagian Ketenagaan (SDM)</option>
                    <option value="14">14 - Bagian Keuangan</option>
                    <option value="15">15 - Bagian Umum</option>
                </select>
              </div>
              <div class="form-group">
                <label for="kode">Kode Pengajuan</label>
                <select id="kode" name="kode"  required>
                    <option value=""> -- Pilih Klasifikasi --</option>
                    <?php foreach ($klasifikasis as $k): ?>
                        <option value="<?php echo $k['id_klasifikasi_surat']; ?>">
                            <?php echo $k['kode_surat'] . ' - ' . $k['nama_surat']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
              </div>
          </div>
          <div class="form-group full-width">
              <label for="perihal">Perihal</label>
              <input type="text" id="perihal" name="perihal" class="form-control" placeholder="Masukkan perihal pengajuan" required>
          </div>
          <div class="form-group full-width">
              <label for="tujuan">User Tujuan</label>
              <select name="tujuan" id="tujuan" class="form-control">
                  <option value="">Pilih User Tujuan</option>
                  <?php foreach ($users as $ur): ?>
                      <option value="<?php echo $ur['id_user']; ?>">
                          <?php echo $ur['nama'] . ' (' . $ur['nama_role'] . ')'; ?>
                      </option>
                  <?php endforeach; ?>
              </select>
          </div>
          <div class="form-group full-width">
              <label for="disposisi">Disposisi</label>
              <textarea id="disposisi" name="disposisi" class="form-control" placeholder="Masukkan disposisi atau keterangan pengajuan..."></textarea>
          </div>
          <div class="form-group full-width">
              <label for="dokumen">Dokumen Pendukung</label>
              <input type="file" id="dokumen" name="dokumen" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" >
          </div>
          <div class="buttons">
              <button type="submit" class="btn">Kirim</button>
              <button type="button" class="btn" onclick="batalkanForm()">Batalkan</button>
          </div>
        </form>
      </div>  
    </div>
</div>
<!-- Tambahkan sebelum tag </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('#kode').select2({
      placeholder: "-- Pilih Klasifikasi --",
      allowClear: true
    });
  //   $('#kode').select2({
  //       placeholder: "-- Pilih Klasifikasi --",
  //       allowClear: true,
  //       width: '100%', // Mempertahankan lebar penuh
  //       dropdownAutoWidth: false, // Tidak auto resize width
  //       containerCssClass: 'select2-container-custom', // Custom class untuk styling
  //       dropdownCssClass: 'select2-dropdown-custom', // Custom class untuk dropdown
  //       minimumResultsForSearch: 0, // Hilangkan search box jika tidak diperlukan
  //       escapeMarkup: function(markup) {
  //           return markup; // Memungkinkan HTML markup
  //       },
  //       templateResult: formatOption, // Custom format untuk hasil
  //       templateSelection: formatSelection // Custom format untuk selection
  //   });
  //   $('#kode').on('select2:open', function() {
  //       $('.select2-dropdown').css({
  //           'z-index': 9999,
  //           'border': '2px solid #e5e7eb',
  //           'border-radius': '6px'
  //       });
  //   });
    
  //   // Mempertahankan focus styling
  //   $('#kode').on('select2:focus', function() {
  //       $(this).next('.select2-container').addClass('select2-container--focus');
  //   });
    
  //   $('#kode').on('select2:blur', function() {
  //       $(this).next('.select2-container').removeClass('select2-container--focus');
  //   });
  });
</script>
