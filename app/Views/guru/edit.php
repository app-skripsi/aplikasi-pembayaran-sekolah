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
                <a href="<?php echo base_url('/guru'); ?>">Data Guru</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   Edit guru
                </li>
              </ol>
            </nav>
            <h1 class="mb-0 fw-bold text-center"> Form Edit Data guru </h1>
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
              <form action="<?= site_url('guru/update/' . $guru['id']); ?>" method="post"><?php echo form_hidden('id', $guru['id']); ?>
                  <div class="form-group">
                    <label class="form-label" for="nama">Nama</label>
                    <input class="form-control form-control-lg" type="text" id="nama" name="nama" value="<?php echo isset($guru['nama']) ? $guru['nama'] : ''; ?>"  />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="nip">NIP</label>
                    <input class="form-control form-control-lg" type="text" id="nip" name="nip" value="<?php echo isset($guru['nip']) ? $guru['nip'] : ''; ?>"  />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="nomor_telepon">Nomor Telephone</label>
                    <input class="form-control form-control-lg" type="text" id="nomor_telepon" name="nomor_telepon" value="<?php echo isset($guru['nomor_telepon']) ? $guru['nomor_telepon'] : ''; ?>"  />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="alamat">Alamat</label>
                    <input class="form-control form-control-lg" type="text" id="alamat" name="alamat" value="<?php echo isset($guru['alamat']) ? $guru['alamat'] : ''; ?>"  />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control form-control-lg" type="text" id="email" name="email" value="<?php echo isset($guru['email']) ? $guru['email'] : ''; ?>"  />
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