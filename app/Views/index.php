<?php echo view("pages/head"); ?>

<body>
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>
  <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
    data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    <?php echo view("pages/header") ?>
    <?php echo view("pages/aside"); ?>
    <div class="page-wrapper">
      <div class="page-breadcrumb">
        <div class="row align-items-center">
          <div class="col-6">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-0 d-flex align-items-center">
                <li class="breadcrumb-item">
                  <a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Dashboard
                </li>
              </ol>
            </nav>
            <h1 class="mb-0 fw-bold">Dashboard</h1>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <!-- column -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <!-- title -->
                <div class="d-md-flex">
                  <div>
                    <h4 class="card-title">Informasi</h4>
                    <h5 class="card-subtitle">
                      Tampilan Data dan Jumlah Data
                    </h5>
                  </div>
                </div>
                <!-- title -->
                <div class="table-responsive">
                  <table class="table mb-0 table-hover align-middle text-nowrap">
                    <thead>
                      <tr>
                        <th class="border-top-0">Informasi Data</th>
                        <th class="border-top-0">Total Jumlah Data</th>
                        <th class="border-top-0">Lihat Data</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="">
                              <h4 class="m-b-0 font-16">Data Siswa</h4>
                            </div>
                          </div>
                        </td>
                        <td><?= $siswa ?? 0 ?></td>
                        <td>
                          <a href="<?php echo base_url('/siswa') ?>" class="btn btn-danger" target="_blank">Lihat
                            Data</a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="">
                              <h4 class="m-b-0 font-16">Data Kelas</h4>
                            </div>
                          </div>
                        </td>
                        <td><?= $kelas ?? 0 ?></td>
                        <td>
                          <a href="<?php echo base_url('/kelas') ?>" class="btn btn-danger" target="_blank">Lihat
                            Data</a>
                        </td>
                      </tr>
                      <?php if (session()->get('level') == 1) { ?>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="">
                              <h4 class="m-b-0 font-16">Data Guru</h4>
                            </div>
                          </div>
                        </td>
                        <td><?= $guru ?? 0 ?></td>
                        <td>
                          <a href="<?php echo base_url('/guru') ?>" class="btn btn-danger" target="_blank">Lihat
                            Data</a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="">
                              <h4 class="m-b-0 font-16">Data SPP</h4>
                            </div>
                          </div>
                        </td>
                        <td><?= $spp ?? 0 ?></td>
                        <td>
                          <a href="<?php echo base_url('/spp') ?>" class="btn btn-danger" target="_blank">Lihat Data</a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="">
                              <h4 class="m-b-0 font-16">Data Penggajian</h4>
                            </div>
                          </div>
                        </td>
                        <td><?= $penggajian ?? 0 ?></td>
                        <td>
                          <a href="<?php echo base_url('/pengajian') ?>" class="btn btn-danger" target="_blank">Lihat
                            Data</a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php echo view("pages/footer.php"); ?>
    </div>
  </div>
  <?php echo view("pages/script"); ?>
</body>

</html>