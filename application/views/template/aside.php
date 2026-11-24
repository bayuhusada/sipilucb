    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="<?php echo base_url('dashboard'); ?>" class="app-brand-link">
              <span class="app-brand-text demo menu-text fw-bolder ms-2">Teknik Sipil</span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item <?php echo $this->uri->segment(1) == 'dashboard' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('dashboard'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
              </a>
            </li>

            <li class="menu-item <?php echo $this->uri->segment(1) == 'profile' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('profile'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Profile">Profil Saya</div>
              </a>
            </li>

            <?php if (in_array($user['role'], array('superadmin', 'admin', 'admin_berita'))): ?>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Publikasi</span>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'news' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/news'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-news"></i>
                <div data-i18n="Berita">Berita</div>
              </a>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'categories' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/categories'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div data-i18n="Kategori">Kategori</div>
              </a>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'agendas' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/agendas'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div data-i18n="Agenda">Agenda</div>
              </a>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'faqs' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/faqs'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-question-mark"></i>
                <div data-i18n="FAQ">FAQ</div>
              </a>
            </li>
            <?php endif; ?>

            <?php if (in_array($user['role'], array('superadmin', 'admin'))): ?>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Akademik</span>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'study_programs' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/study_programs'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div data-i18n="Program Studi">Profil Prodi</div>
              </a>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'lecturers' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/lecturers'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div data-i18n="Dosen">Dosen</div>
              </a>
            </li>
            <?php endif; ?>

            <?php if (in_array($user['role'], array('superadmin', 'admin', 'admin_berita'))): ?>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Media</span>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'banners' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/banners'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-slideshow"></i>
                <div data-i18n="Banner">Banner Slider</div>
              </a>
            </li>
            <?php endif; ?>
            <?php if (in_array($user['role'], array('superadmin', 'admin'))): ?>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'features' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/features'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-star"></i>
                <div data-i18n="Features">Program Unggulan</div>
              </a>
            </li>
            <?php endif; ?>
            <?php if (in_array($user['role'], array('superadmin', 'admin'))): ?>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'galleries' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/galleries'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-images"></i>
                <div data-i18n="Galeri">Galeri</div>
              </a>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'downloads' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/downloads'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-download"></i>
                <div data-i18n="Download">Download</div>
              </a>
            </li>
            <?php endif; ?>

            <?php if ($user['role'] === 'superadmin'): ?>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Admin</span>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'menus' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/menus'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-menu"></i>
                <div data-i18n="Menu">Menu Navigasi</div>
              </a>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'users' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/users'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Users">Users</div>
              </a>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'translate' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/translate'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-globe"></i>
                <div data-i18n="Translate">Auto Translate</div>
              </a>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'theme' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/theme'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-palette"></i>
                <div data-i18n="Theme">Warna Tema</div>
              </a>
            </li>
            <li class="menu-item <?php echo $this->uri->segment(2) == 'settings' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/settings'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Settings">Settings</div>
              </a>
            </li>
            <!-- <li class="menu-item <?php echo $this->uri->segment(2) == 'sweeper' ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/sweeper'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-eraser"></i>
                <div data-i18n="Sweeper">Pembersih File Yatim</div>
              </a>
            </li> -->

            <?php endif; ?>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

			<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
				id="layout-navbar">

				<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
					<a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
						<i class="bx bx-menu bx-sm"></i>
					</a>
				</div>

				<div class="position-absolute start-50 translate-middle-x">
					<a href="#" class="navbar-brand mb-0 h1 text-primary fw-bold">Teknik Sipil</a>
				</div>

				<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
					<div class="navbar-nav ms-auto">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bx bx-user-circle bx-sm me-1"></i>
                                <span><?php echo html_escape($user['username']); ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo base_url('profile'); ?>"><i class="bx bx-user me-1"></i> Profil Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><?php echo form_open('auth/logout', array('style' => 'display:inline')); ?><button type="submit" class="dropdown-item"><i class="bx bx-log-out me-1"></i> Logout</button><?php echo form_close(); ?></li>
                            </ul>
                        </div>
					</div>

				</div>
			</nav>

          <!-- / Navbar -->

					          <!-- Content wrapper -->
          <div class="content-wrapper">
