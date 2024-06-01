<?php echo view("pages/head"); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
<style>
        .btn-custom {
            display: flex;
            align-items: center;
            margin-bottom: 10px; /* Add some space below each button */
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
            gap: 10px; /* Add some space between left buttons */
        }
    </style>
  <body>
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
    <?php echo view("pages/header") ?>
    <?php  echo view("pages/aside");?>
      <div class="page-wrapper">
        <div class="page-breadcrumb">
          <div class="row align-items-center">
            <div class="col-12">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item">
                    <a href="<?php echo base_url('/dashboard'); ?>" class="link"
                      ><i class="mdi mdi-home-outline fs-4"></i></a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                   Data Siswa
                  </li>
                </ol>
              </nav>
              <h1 class="mb-0 fw-bold text-center"> Informasi Data Siswa </h1>
            </div>
          </div>
          <a href="<?php echo base_url('/siswa/create'); ?>" class="link" style="float: right;">
                    <i class="mdi mdi-plus fs-4 text-primary">Tambah Data</i>
                </a>
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
                        <th scope="col"   class="text-center">No</th>
                        <th scope="col"  class="text-center">Nama</th>
                        <th scope="col"  class="text-center">NIS</th>
                        <th scope="col"  class="text-center">Kelas</th>
                        <th scope="col"  class="text-center">Alamat</th>
                        <th scope="col"  class="text-center">No Telephone</th>
                        <th scope="col"  class="text-center">Jenis Kelamin</th>
                        <th scope="col"  class="text-center">Tanggal Lahir</th>
                        <th scope="col"  class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($siswa as $key => $row) { ?>
                      <tr>
                      <td scope="col" class="text-center"><?php echo $key + 1; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['nama']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['nis']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['kelas']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['alamat']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['nomor_telepon']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['jenis_kelamin']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['tanggal_lahir']; ?></td>
                          <td scope="col" class="text-center">
                            <div class="form-group">
                              <a href="<?php echo base_url('siswa/edit/' . $row['id']); ?>" class="btn btn-sm btn-secondary">
                                edit
                              </a>
                              <a href="<?php echo base_url('siswa/delete/' . $row['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus Data Pelamar ini?');">
                                hapus <i class="fa fa-trash-alt"></i>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <?php echo view("pages/script.php"); ?>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
  </body>
</html>
