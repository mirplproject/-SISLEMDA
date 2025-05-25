<div class="content">
    <h2>Dashboard Yayasan</h2>
    <p>Selamat datang, <?php echo $this->session->userdata('nama'); ?> (Username: <?php echo $this->session->userdata('username'); ?>)</p>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Surat Anda</h5>
                    <p class="card-text"><?php echo $surat_count; ?> Surat</p>
                </div>
            </div>
        </div>
    </div>
</div>