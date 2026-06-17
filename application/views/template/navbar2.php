<div class="sidebar-wrapper">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?= base_url('assets/assets/'); ?>img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="info">
                <a href="<?= base_url('dashboard/') ?>" class=" d-block text-capitalize">
                    <?= $_SESSION['username'] ?>
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
                <?php if (!empty($menus)): ?>
                    <?php foreach ($menus as $m): ?>
                        <li class="nav-item">
                            <a href="<?= base_url($m['url']) ?>" class="nav-link">
                                <i class="nav-icon <?= $m['icon'] ?>"></i>
                                <p>
                                    <?= $m['title'] ?>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?= base_url('auth/logout') ?>" class="nav-link">
                        <i class="fa-long-arrow-right fa-solid"></i>
                        <p>logout</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</div>