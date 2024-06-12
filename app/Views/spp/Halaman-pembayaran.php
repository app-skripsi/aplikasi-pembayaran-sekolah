<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Informasi Pembayaran SPP</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url('asset/img/favicon.png'); ?>" rel="icon">
  <link href="<?php echo base_url('asset/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url('asset/vendor/aos/aos.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('asset/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('asset/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('asset/vendor/glightbox/css/glightbox.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('asset/vendor/remixicon/remixicon.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('asset/vendor/swiper/swiper-bundle.min.css'); ?>" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url('asset/css/style.css'); ?>" rel="stylesheet">
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="<?php echo base_url('/'); ?>" class="logo d-flex align-items-center">
        <span>MI AL MA’MURIYAH</span>
      </a>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="<?php echo base_url("/") ?>">Home</a></li>
          <li><a class="nav-link scrollto active" href="<?php echo base_url("/bayar-spp") ?>">Pembayaran SPP</a></li>
          <li><a class="getstarted scrollto" href="<?php echo base_url("/login") ?>">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="<?php echo base_url("/"); ?>">Home</a></li>
          <li><a href="<?php echo base_url('/bayar-spp'); ?>">Pembayaran SPP</a></li>
          <li>Informasi SPP Siswa</li>
        </ol>
        <h2>Informasi SPP</h2>
        <?php if (isset($spp) && !empty($spp)): ?>
          <p>Nama: <?= $spp[0]['nama']; ?></p>
          <p>NIS: <?= $spp[0]['nis']; ?></p>
          <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#sppModal">
            Lihat Informasi SPP
          </button>
        <?php else: ?>
          <p><?= isset($error) ? $error : 'Data SPP tidak ditemukan.'; ?></p>
        <?php endif; ?>
      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Modal ======= -->
    <div class="modal fade" id="sppModal" tabindex="-1" aria-labelledby="sppModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="sppModalLabel">Informasi Status Pembayaran SPP</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php if (isset($spp) && !empty($spp)): ?>
              <?php foreach ($spp as $row): ?>
                <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <p class="card-title"><strong>Nama:</strong> <?= $row['nama']; ?></p>
                      <p class="card-text"><strong>Kelas:</strong> <?= $row['kelas']; ?></p>
                      <p class="card-text"><strong>Tahun Ajaran:</strong> <?= $row['tahun_ajaran']; ?></p>
                      <p class="card-text"><strong>Bulan Pembayaran:</strong> <?= $row['bulan_pembayaran']; ?></p>
                    </div>
                    <div class="col-md-6">
                      <p class="card-text"><strong>Nominal : </strong>Rp. <?= number_format($row['nominal_pembayaran'], 0, ',', '.'); ?></p>
                      <p class="card-text"><strong>Tanggal Bayar:   </strong> <?= $row['tanggal_pembayaran']; ?></p>
                      <p class="card-text"><strong>Metode Bayar:    </strong> <?= $row['metode_pembayaran']; ?></p>
                      <p class="card-text"><strong>Catatan:</strong> <?= $row['catatan']; ?></p>
                      <p class="card-text"><strong>Status Pembayaran:</strong> <?= $row['status_pembayaran']; ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p>Data SPP tidak ditemukan.</p>
            <?php endif; ?>
          </div>
          <div class="modal-footer">
            <?php if (isset($spp) && !empty($spp) && strtolower($spp[0]['status_pembayaran']) == 'belum lunas'): ?>
              <a href="<?= base_url('spp/createMidtransTransaction/' . $spp[0]['nis']); ?>" class="btn btn-danger">Silahkan Bayar Pembayaran</a>
            <?php elseif (isset($spp) && !empty($spp) && strtolower($spp[0]['status_pembayaran']) == 'lunas'): ?>
              <button class="btn btn-success">Pembayaran Sudah Lunas</button>
            <?php endif; ?>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div><!-- End Modal -->

  </main><!-- End #main -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo base_url('asset/vendor/purecounter/purecounter_vanilla.js'); ?>"></script>
  <script src="<?php echo base_url('asset/vendor/aos/aos.js'); ?>"></script>
  <script src="<?php echo base_url('asset/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('asset/vendor/glightbox/js/glightbox.min.js'); ?>"></script>
  <script src="<?php echo base_url('asset/vendor/isotope-layout/isotope.pkgd.min.js'); ?>"></script>
  <script src="<?php echo base_url('asset/vendor/swiper/swiper-bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('asset/vendor/php-email-form/validate.js'); ?>"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo base_url('asset/js/main.js'); ?>"></script>

</body>

</html>
