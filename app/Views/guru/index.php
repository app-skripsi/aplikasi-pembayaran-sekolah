<?php echo view("pages/head"); ?>


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
                  Data Guru
                </li>
              </ol>
            </nav>
            <h1 class="mb-0 fw-bold text-center"> Informasi Data Guru </h1>
          </div>
        </div>
        <a href="<?php echo base_url('/guru/create'); ?>" class="link" style="float: right;">
          <i class="mdi mdi-plus fs-4 text-primary">Tambah Data</i>
        </a>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Nama</th>
                        <th scope="col" class="text-center">NIP</th>
                        <th scope="col" class="text-center">No Telephone</th>
                        <th scope="col" class="text-center">Alamat</th>
                        <th scope="col" class="text-center">Email</th>
                        <th scope="col" class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($guru as $key => $row) { ?>
                        <tr>
                          <td scope="col" class="text-center"><?php echo $key + 1; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['nama']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['nip']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['nomor_telepon']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['alamat']; ?></td>
                          <td scope="col" class="text-center"><?php echo $row['email']; ?></td>
                          <td scope="col" class="text-center">
                            <div class="btn-group">
                              <a href="<?php echo base_url('guru/edit/' . $row['id']); ?>" class="btn btn-sm btn-secondary">
                                edit
                              </a>
                              <a href="<?php echo base_url('guru/delete/' . $row['id']); ?>" class="btn btn-sm btn-danger delete-btn">
                                hapus
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
    <?php echo view("pages/script.php"); ?>
</body>

</html>