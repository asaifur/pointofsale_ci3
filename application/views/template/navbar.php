  <!--begin::Brand Image-->
  <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
              <a href="#" class="d-block"><?= $title ?></a>
          </div>
      </div>
      <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

              <li class="nav-item">
                  <a href="<?= base_url('') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dashboard</p>
                  </a>
              </li>

              <?php if (!empty($menus)): ?>

                  <?php foreach ($menus as $modul => $items): ?>

                      <li class="nav-header"><?= strtoupper($modul); ?></li>

                      <?php foreach ($items as $m): ?>
                          <li class="nav-item">
                              <a href="<?= base_url($m->url); ?>" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p><?= $m->title; ?></p>
                              </a>
                          </li>
                      <?php endforeach; ?>

                  <?php endforeach; ?>

              <?php endif; ?>

              <li class="nav-item">
                  <a href="<?= base_url('auth/logout') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Logout</p>
                  </a>
              </li>

          </ul>
      </nav>
  </div>