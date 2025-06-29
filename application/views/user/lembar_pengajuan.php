<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url('assets/template/css/pengajuan.css'); ?>" />
<div class="row">
    <div class="col-xl-12">
      <!-- <?php if ($this->session->flashdata('success')): ?>
        <div id="notif" class="notif-success">
          <?php echo $this->session->flashdata('success'); ?>
        </div>
      <?php endif; ?>  -->
      <div class="container">
        <h2 class="mb-4">Lembar Pengajuan</h2>
        <form action="<?php echo site_url('surat/insert'); ?>" method="post" enctype="multipart/form-data" id="pengajuanForm">
          <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('id_user'); ?>">
          <input type="hidden" name="nama_role" value="<?php echo htmlspecialchars($nama_role); ?>">
          <div class="form-row">
              <div class="form-group">
              <label for="no">No</label>
              <input type="text" id="no" name="no" class="form-control" value="<?php echo $no_surat; ?>" readonly>
              </div>
              <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" id="tanggal" name="tanggal" value="<?php echo date('Y-m-d'); ?>" readonly>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group">
                <label for="unit">Unit Pengajuan</label>
                <select id="unit" name="unit" required onchange="updateKlasifikasi()">
                    <option value=""> -- Pilih Unit Pengajuan --</option>
                    <?php foreach ($unitpengajuan as $u): ?>
                        <option value="<?php echo $u['id_unit']; ?>">
                            <?php echo $u['kode_unit'] . ' - ' . $u['nama_unit']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="kode">Kode Pengajuan</label>
                <select id="kode" name="kode" required>
                    <option value=""> -- Pilih Klasifikasi --</option>
                    <!-- Options will be populated based on the selected unit -->
                </select>
              </div>
          </div>
          <div class="form-group full-width">
              <label for="perihal">Perihal</label>
              <input type="text" id="perihal" name="perihal" class="form-control" placeholder="Masukkan perihal pengajuan" required>
          </div>
          <!-- <div class="form-group full-width">
              <label for="tujuan">User Tujuan</label>
              <select name="tujuan" id="tujuan" class="form-control">
                  <option value="">Pilih User Tujuan</option>
                  <?php foreach ($users as $ur): ?>
                      <option value="<?php echo $ur['id_user']; ?>">
                          <?php echo $ur['nama'] . ' (' . $ur['nama_role'] . ')'; ?>
                      </option>
                  <?php endforeach; ?>
              </select>
          </div> -->
          <div class="form-group full-width">
              <label for="disposisi">Disposisi</label>
              <textarea id="disposisi" name="disposisi" class="form-control" placeholder="Masukkan disposisi atau keterangan pengajuan..."></textarea>
          </div>
          <div class="form-group full-width">
              <label for="dokumen">Dokumen Pendukung</label>
              <input type="file" id="dokumen" name="dokumen[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" >
          </div>
          <div id="selectedFiles"></div><br>
              <!-- File tags will be rendered here -->
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

  const klasifikasis = <?php echo json_encode($klasifikasis); ?>; // Assuming $klasifikasis is an array of objects
  function updateKlasifikasi() {
      const unitSelect = document.getElementById('unit');
      const kodeSelect = document.getElementById('kode');
      const selectedUnitId = unitSelect.value;
      // Clear previous options
      kodeSelect.innerHTML = '<option value=""> -- Pilih Klasifikasi --</option>';
      // Filter klasifikasis based on selected unit
      const filteredKlasifikasis = klasifikasis.filter(k => k.id_unit === selectedUnitId);
      // Populate the kode select with filtered options
      filteredKlasifikasis.forEach(k => {
          const option = document.createElement('option');
          option.value = k.id_klasifikasi_surat;
          option.textContent = k.kode_surat + ' - ' + k.nama_surat;
          kodeSelect.appendChild(option);
      });
  }


  // === File upload multiple with tags + remove ===
  let selectedFiles = [];
  const fileInput = document.getElementById('dokumen');
  fileInput.addEventListener('change', handleFileSelection);
  function handleFileSelection() {
    const newFiles = Array.from(fileInput.files);
    newFiles.forEach(f => {
      if (!selectedFiles.some(s => s.name === f.name && s.size === f.size)) {
        selectedFiles.push(f);
      }
    });
    renderFileTags();
    updateInputFiles();
  }
  function renderFileTags() {
    const container = document.getElementById('selectedFiles');
    container.innerHTML = '';
    selectedFiles.forEach((f, i) => {
      const tag = document.createElement('div');
      tag.className = 'file-tag';
      tag.innerHTML = `<span>${f.name}</span>
        <button type="button" class="remove-file" onclick="removeFile(${i})">×</button>`;
      container.appendChild(tag);
    });
  }
  function removeFile(index) {
    selectedFiles.splice(index, 1);
    renderFileTags();
    updateInputFiles();
  }
  function updateInputFiles() {
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    fileInput.files = dt.files;
  }
</script>
