<aside class="left-sidebar" data-sidebarbg="skin6">
      <!-- Sidebar scroll-->
      <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
          <ul id="sidebarnav">
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo base_url('/dashboard'); ?>" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
            </li>
            <?php if (session()->get('level') == 1) { ?>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo base_url('/guru'); ?>" aria-expanded="false"><i class="mdi mdi-account-network"></i><span class="hide-menu">Guru</span></a>
            </li>
            <?php } ?>
            <?php if (session()->get('level') == 1 || session()->get('level') == 2) { ?>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo base_url('/kelas'); ?>" aria-expanded="false"><i class="mdi mdi-border-all"></i><span class="hide-menu">Kelas</span></a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo base_url('/siswa'); ?>" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Siswa</span></a>
            </li>
            <?php } ?>
            <?php if (session()->get('level') == 1) { ?>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo base_url('/spp'); ?>" aria-expanded="false"><i class="mdi mdi-file"></i><span class="hide-menu">SPP</span></a>
            </li>
            <!-- <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo base_url('/pengajian'); ?>" aria-expanded="false"><i class="mdi mdi-file"></i><span class="hide-menu">Penggajian</span></a>
            </li> -->
            <?php } ?>

          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>