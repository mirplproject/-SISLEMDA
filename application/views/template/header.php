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
        <img src="<?php echo base_url('assets/template/img/logo_binainsani.png" rel="stylesheet')?>" alt="Logo" style="width: 220px; height: 40px; object-fit: contain;"/>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!-- tambahkan text-danger jika ada notif -->
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- tambahkan jika ada notifnya 
                    <span class="badge bg-danger badge-counter">3+</span>
                    -->
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Alerts Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="me-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 12, 2024</div>
                            <span class="font-weight-bold">A new monthly report is ready to download!</span>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="me-3">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-donate text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 7, 2024</div>
                            $290.29 has been deposited into your account!
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="me-3">
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 2, 2024</div>
                            Spending Alert: We've noticed unusually high spending for your account.
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item text-danger" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>