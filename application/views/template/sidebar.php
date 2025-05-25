<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion" style="background-color: #00923F;">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <br><br>
                <a class="nav-link <?php echo $this->uri->segment(1) == 'admin' && $this->uri->segment(2) == '' ? 'active' : ''; ?>" href="<?php echo site_url('admin'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link <?php echo $this->uri->segment(2) == 'manage_prodi' ? 'active' : ''; ?>" href="<?php echo site_url('admin/manage_prodi'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Kelola Prodi
                </a>
                <a class="nav-link <?php echo $this->uri->segment(2) == 'manage_role_user' ? 'active' : ''; ?>" href="<?php echo site_url('admin/manage_role_user'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-tag"></i></div>
                    Kelola Role User
                </a>
                <a class="nav-link <?php echo $this->uri->segment(2) == 'manage_user' ? 'active' : ''; ?>" href="<?php echo site_url('admin/manage_user'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Kelola Pengguna
                </a>
                <a class="nav-link <?php echo $this->uri->segment(2) == 'manage_klasifikasi_surat' ? 'active' : ''; ?>" href="<?php echo site_url('admin/manage_klasifikasi_surat'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
                    Kelola Klasifikasi Surat
                </a>
                <a class="nav-link" href="<?php echo site_url('auth/logout'); ?>">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                    Logout
                </a>
            </div>
        </div>
    </nav>
</div>