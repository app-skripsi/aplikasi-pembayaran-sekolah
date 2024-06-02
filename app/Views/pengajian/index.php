<?php echo view("pages/head"); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
<style>
  .btn-custom {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    /* Add some space below each button */
  }

  .btn-custom .mdi {
    margin-right: 5px;
  }

  .button-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .left-buttons {
    display: flex;
    gap: 10px;
    /* Add some space between left buttons */
  }
</style>

<body>
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>
  <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    <?php echo view("pages/header") ?>
    <?php echo view("pages/aside"); ?>
    <div class="page-wrapper">
      <div class="page-breadcrumb">
        <div class="row align-items-center">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-0 d-flex align-items-center">
                <li class="breadcrumb-item">
                  <a href="<?php echo base_url('/dashboard'); ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Data Penggajian
                </li>
              </ol>
            </nav>
            <h1 class="mb-0 fw-bold text-center">Informasi Data Penggajian</h1>
          </div>
        </div>
        <hr>
        <div class="button-container">
          <div class="left-buttons">
            <a href="<?php echo base_url('/spp/pdf'); ?>" class="btn btn-danger btn-custom">
              <i class="mdi mdi-file-pdf-box fs-4"></i> Print Laporan PDF
            </a>
            <a href="<?php echo base_url('/spp/excel'); ?>" class="btn btn-success btn-custom">
              <i class="mdi mdi-file-excel-box fs-4"></i> Print Laporan Excel
            </a>
          </div>
          <a href="<?php echo base_url('/pengajian/create'); ?>" class="btn btn-primary btn-custom">
            <i class="mdi mdi-plus fs-4"></i> Tambah Data
          </a>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="dataTable" class="table">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Guru</th>
                        <th scope="col" class="text-center">Npk</th>
                        <th scope="col" class="text-center">Bulan</th>
                        <th scope="col" class="text-center">Tahun</th>
                        <th scope="col" class="text-center">Tanggal</th>
                        <th scope="col" class="text-center">Gaji</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Informasi Tambahan</th>
                        <th scope="col" class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($pengajian as $key => $row) { ?>
                        <tr>
                          <td scope="col" class="text-center"><?php echo $key + 1; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['nama']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['npk']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['bulan']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['tahun']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['tanggal']; ?></td>
                          <td scope="col" class="text-center">Rp. <?= $row['gaji'] ?>,000</td>
                          <td scope="col" class="text-center"><?php echo $row['status']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['keterangan']; ?></td>
                          <td scope="col" class="text-center">
                            <div class="btn-group">
                              <a href="<?php echo base_url('pengajian/edit/' . $row['id']); ?>" class="btn btn-sm btn-secondary">
                                edit
                              </a>
                              <a href="<?php echo base_url('pengajian/delete/' . $row['id']); ?>" class="btn btn-sm btn-danger">
                                Hapus
                            </a>
                            </div>
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
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
  <?php echo view("pages/script.php"); ?>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable();
    });
  </script>
</body>

</html>