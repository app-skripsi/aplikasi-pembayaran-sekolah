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
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nama</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Tahun Ajaran</th>
                <th>Bulan</th>
                <th>Besar Iuran</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Status Pembayaran</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($spp as $row): ?>
                <tr>
                  <td><?= $row['nama']; ?></td>
                  <td><?= $row['nis']; ?></td>
                  <td><?= $row['kelas']; ?></td>
                  <td><?= $row['tahun_ajaran']; ?></td>
                  <td><?= $row['bulan_pembayaran']; ?></td>
                  <td>Rp. <?= number_format($row['nominal_pembayaran'], 0, ',', '.'); ?></td>
                  <td><?= $row['tanggal_pembayaran']; ?></td>
                  <td><?= $row['status_pembayaran']; ?></td>
                  <td>
                    <?php if (strtolower($row['status_pembayaran']) == 'belum lunas'): ?>
                      <button id="pay-button-<?= $row['nis']; ?>" class="btn btn-danger" onclick="pay(<?= $row['nis']; ?>)">Bayar SPP</button>
                    <?php else: ?>
                      <button class="btn btn-success" disabled>Lunas</button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </section><!-- End Breadcrumbs -->

  </main><!-- End #main -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-11U7w6NIwYfR1H2g"></script>
  <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('<?=$snapToken?>', {
          // Optional
          onSuccess: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          },
          // Optional
          onPending: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          },
          // Optional
          onError: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          }
        });
      };
    </script>

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
