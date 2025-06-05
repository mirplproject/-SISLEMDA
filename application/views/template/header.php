<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SISLEMDA - Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="<?php echo base_url('assets/template/css/styles.css" rel="stylesheet')?>" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            #layoutSidenav {
                display: flex;
                flex-direction: row; /* Changed back to row to place sidebar and content side-by-side */
                flex-grow: 1;
            }

            #layoutSidenav_nav {
                /* Sidebar styles remain the same */
            }

            #layoutSidenav_content {
                flex-grow: 1;
                display: flex; /* Add flex display to the content area */
                flex-direction: column; /* Arrange main and footer vertically */
            }

            main {
                flex-grow: 1; /* Allow main content to take up available vertical space */
            }

            #layoutSidenav_nav .sb-sidenav a,
            #layoutSidenav_nav .sb-sidenav .sb-sidenav-menu-heading,
            #layoutSidenav_nav .sb-sidenav .nav-link .sb-nav-link-icon i {
                color: white !important;
            }

            #layoutSidenav_nav .sb-sidenav .sb-sidenav-footer {
                color: white !important;
                background-color: rgba(0, 0, 0, 0.2);
            }

            footer.mt-auto {
                /* Remove margin-top: auto here */
            }
        </style>
    </head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-light bg-white border-bottom border-3 border-success">
        <img src="<?php echo base_url('assets/template/img/logo_binainsani.png') ?>" alt="Logo" style="width: 220px; height: 40px; object-fit: contain;"/>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <ul class="navbar-nav ms-auto me-3 my-2 my-md-0 d-flex align-items-center gap-3">
            <!-- Notifikasi -->
            <li class="nav-item">
                <div class="bg-success rounded-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-bell text-white"></i>
                </div>
            </li>

            <!-- Admin dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url('assets/template/img/gambarorg.jpg') ?>" class="rounded-3" width="40" height="40" alt="Admin">
                    <span class="fw-semibold text-dark"><?php echo $this->session->userdata('name'); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item text-danger" href="<?php echo site_url('auth/logout'); ?>">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
<div id="layoutSidenav">