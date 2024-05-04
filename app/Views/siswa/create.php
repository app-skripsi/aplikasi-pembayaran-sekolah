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
                <li class="breadcrumb-item" aria-current="page">
                  Data Siswa
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   Tambah Siswa
                </li>
              </ol>
            </nav>
            <h1 class="mb-0 fw-bold text-center"> Form Tambah Data Siswa </h1>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <?php
            $inputs = session()->getFlashdata('inputs');
            $errors = session()->getFlashdata('errors');
            if (!empty($errors)) { ?>
              <div class="alert alert-danger" role="alert">
                Whoops! Ada kesalahan saat input data, yaitu:
                <ul>
                  <?php foreach ($errors as $error) : ?>
                    <li><?= esc($error) ?></li>
                  <?php endforeach ?>
                </ul>
              </div>
            <?php } ?>
            <div class="card shadow">
              <div class="card-body">
                <form action="<?= base_url('siswa/store'); ?>" method="post">
                  <div class="form-group">
                    <label class="form-label" for="kelas_id">Kelas</label>
                    <input class="form-control form-control-lg" type="text" id="kelas_id" name="kelas_id"/>
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="nama">Nama</label>
                    <input class="form-control form-control-lg" type="text" id="nama" name="nama" placeholder="Masukan Nama Siswa" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="nis">Nis</label>
                    <input class="form-control form-control-lg" type="text" id="nis" name="nis" placeholder="Masukan Nis" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="alamat">Alamat</label>
                    <input class="form-control form-control-lg" type="text" id="alamat" name="alamat" placeholder="Masukan Alamat" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="nomor_telepon">Nomer Telepon</label>
                    <input class="form-control form-control-lg" type="text" id="nomor_telepon" name="nomor_telepon" placeholder="Masukan Nomer Telephone" />
                  </div><br><div class="form-group">

                    <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                    <input class="form-control form-control-lg" type="text" id="jenis_kelamin" name="jenis_kelamin" placeholder="Masukan Jenis Kelamin" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                    <input class="form-control form-control-lg" type="date" id="tanggal_lahir" name="tanggal_lahir" placeholder="Masukan Tanggal Lahir" />
                  </div><br>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
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