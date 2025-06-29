<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion" style="background-color: #00923F;">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <br><br>
                <?php
                $role = $this->session->userdata('active_role');

                // Definisikan kategori user berdasarkan role
                $user1_roles = [
                    'dosen', 'pelayanan_akademik', 'komputasi_data', 'penelitian_pkm', 'publikasi_hki',
                    'inkubator_bisnis', 'pendidikan_pelatihan', 'pengembangan_karir', 'pelayanan', 'akuntansi',
                    'pajak', 'kerumahtanggaan', 'sarpras', 'upt_perpustakaan', 'lab', 'ppks', 'data_analyst',
                    'konten_editor', 'monitoring_evaluasi', 'pelaporan_data', 'spme'
                ];
                $user2_roles = [
                    'dekan', 'bak', 'lppm', 'kerjasama', 'keuangan', 'umum', 'si_infrastruktur_jaringan',
                    'kemahasiswaan', 'marketing_promosi', 'bic', 'ppm', 'warek1', 'warek2', 'warek3', 'rektor'
                ];
                $user3_roles = ['sdm', 'yayasan'];

                // Tentukan kategori user berdasarkan role
                $user_category = '';
                if (in_array($role, $user1_roles)) {
                    $user_category = 'user1';
                } elseif (in_array($role, $user2_roles)) {
                    $user_category = 'user2';
                } elseif (in_array($role, $user3_roles)) {
                    $user_category = 'user3';
                }

                if ($role == 'Admin') {
                    echo '<a class="nav-link ' . ($this->uri->segment(1) == 'admin' && $this->uri->segment(2) == '' ? 'active' : '') . '" href="' . site_url('admin') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                          </a>';
                    echo '<a class="nav-link ' . ($this->uri->segment(2) == 'manage_prodi' ? 'active' : '') . '" href="' . site_url('admin/manage_prodi') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Kelola Prodi
                          </a>';
                    echo '<a class="nav-link ' . ($this->uri->segment(2) == 'manage_role_user' ? 'active' : '') . '" href="' . site_url('admin/manage_role_user') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-tag"></i></div>
                            Kelola Peran Pengguna
                          </a>';
                    echo '<a class="nav-link ' . ($this->uri->segment(2) == 'manage_user' ? 'active' : '') . '" href="' . site_url('admin/manage_user') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Kelola Pengguna
                          </a>';
                    echo '<a class="nav-link ' . ($this->uri->segment(2) == 'add_role' ? 'active' : '') . '" href="' . site_url('admin/add_role') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
                            Tambah Peran
                          </a>';
                    echo '<a class="nav-link ' . ($this->uri->segment(2) == 'manage_klasifikasi_surat' ? 'active' : '') . '" href="' . site_url('admin/manage_klasifikasi_surat') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
                            Kelola Klasifikasi Pengajuan
                          </a>';
                } else {
                    echo '<a class="nav-link ' . ($this->uri->segment(1) == 'user' && $this->uri->segment(2) == 'dashboard' ? 'active' : '') . '" href="' . site_url('user/dashboard') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                          </a>';
                    echo '<a class="nav-link ' . ($this->uri->segment(2) == 'lembar_pengajuan' ? 'active' : '') . '" href="' . site_url('user/lembar_pengajuan') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Lembar Pengajuan
                          </a>';
                    echo '<a class="nav-link ' . ($this->uri->segment(2) == 'status_pengajuan' ? 'active' : '') . '" href="' . site_url('user/status_pengajuan') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div>
                            Status Pengajuan
                          </a>';
                    echo '<a class="nav-link ' . ($this->uri->segment(2) == 'surat_masuk' ? 'active' : '') . '" href="' . site_url('user/surat_masuk') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-envelope-open"></i></div>
                            Surat Masuk
                          </a>';
                    echo '<a class="nav-link ' . ($this->uri->segment(2) == 'riwayat_pengajuan' ? 'active' : '') . '" href="' . site_url('user/riwayat_pengajuan') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                            Riwayat Pengajuan
                          </a>';
                    echo '<a class="nav-link ' . ($this->uri->segment(2) == 'laporan' ? 'active' : '') . '" href="' . site_url('user/laporan') . '">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                            Laporan
                          </a>';

                    if ($user_category == 'user2') {
                        echo '<a class="nav-link ' . ($this->uri->segment(2) == 'laporan' ? 'active' : '') . '" href="' . site_url('user/laporan') . '">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                                Laporan
                              </a>';
                    }

                    if ($user_category == 'user3') {
                        echo '<a class="nav-link ' . ($this->uri->segment(2) == 'arsip' ? 'active' : '') . '" href="' . site_url('user/arsip') . '">
                                <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                                Arsip
                              </a>';
                    }
                }
                ?>
                <a class="nav-link" href="<?php echo site_url('auth/logout'); ?>">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                    Logout
                </a>
            </div>
        </div>
    </nav>
</div>