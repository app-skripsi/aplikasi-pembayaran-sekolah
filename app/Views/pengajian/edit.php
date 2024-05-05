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
                  Data Pengajian
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   Edit Pengajian
                </li>
              </ol>
            </nav>
            <h1 class="mb-0 fw-bold text-center"> Form Edit Data Pengajian </h1>
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
              <form action="<?= site_url('pengajian/update/' . $pengajian['id']); ?>" method="post"><?php echo form_hidden('id', $pengajian['id']); ?>
                  <div class="form-group">
                    <label class="form-label" for="guru_id">Guru</label>
                    <input class="form-control form-control-lg" type="text" id="guru_id" name="guru_id" value="<?php echo isset($pengajian['guru_id']) ? $pengajian['guru_id'] : ''; ?>"  />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="bulan">Bulan</label>
                    <input class="form-control form-control-lg" type="text" id="bulan" name="bulan" value="<?php echo isset($pengajian['bulan']) ? $pengajian['bulan'] : ''; ?>"  />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="tahun">Tahun</label>
                    <input class="form-control form-control-lg" type="text" id="tahun" name="tahun" value="<?php echo isset($pengajian['tahun']) ? $pengajian['tahun'] : ''; ?>"  />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="tanggal">Tanggal</label>
                    <input class="form-control form-control-lg" type="text" id="tanggal" name="tanggal" value="<?php echo isset($pengajian['tanggal']) ? $pengajian['tanggal'] : ''; ?>"  />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="gaji">Gaji</label>
                    <input class="form-control form-control-lg" type="text" id="gaji" name="gaji" value="<?php echo isset($pengajian['gaji']) ? $pengajian['gaji'] : ''; ?>"  />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <input class="form-control form-control-lg" type="text" id="status" name="status" value="<?php echo isset($pengajian['status']) ? $pengajian['status'] : ''; ?>"  />
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