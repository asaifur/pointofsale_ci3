<?php $this->load->view('template/header'); ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!--begin::Header-->

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!--begin::End Navbar Links-->
            <ul class="navbar-nav ml-auto">
                <!--begin::Navbar Search-->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="d-none d-md-inline"><?= $_SESSION['username'] ?></span>
                    </a>
                </li>
                <!--end::User Menu Dropdown-->
            </ul>
            <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 bs-pink">
        <img src="<?= base_url('assets') ?>/img/Halal_Indonesia.png" alt="Halal" class="img-thumbnail mx-auto d-block" style="opacity: .8;width:50px;">
        <?php $this->load->view('template/navbar'); ?>
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?= $title; ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><?= $title ?></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <!--begin::Container-->
            <div class="container-fluid">
                <?= $contents; ?>
            </div>
            <!--end::Row-->
        </section>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
    <footer class="main-footer">
        <strong>
            Copyright &copy; <?= date('Y') ?>&nbsp;
            <a href="https://wa.link/38cm8i" class="text-decoration-none">HTP Sinergi</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
    </footer>
    <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->


</body>
<!--end::Body-->

</html>