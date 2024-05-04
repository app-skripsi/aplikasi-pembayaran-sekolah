<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SPP - MI AL MA’MURIYAH</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="asset/img/favicon.png" rel="icon">
  <link href="asset/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="asset/vendor/aos/aos.css" rel="stylesheet">
  <link href="asset/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="asset/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="asset/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="asset/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="asset/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="asset/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- <img src="asset/img/logo.png" alt=""> -->
        <span>MI AL MA’MURIYAH</span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="<?php echo base_url("/") ?>">Home</a></li>
          <li><a class="nav-link scrollto active" href="<?php echo base_url("/bayar-spp") ?>">Pembayaran Spp</a></li>
          <li><a class="getstarted scrollto" href=<?php echo base_url("/login") ?>>Login</a></li>
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
          <li>Pembayaran SPP</li>
        </ol>
        <h2>Halaman Pembayaran SPP</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
  <div class="container">
    <div class="card shadow">
      <div class="card-body">
        <h2 class="card-title text-center">Form Cari Data Siswa</h2>
        <form action="<?= base_url('spp/getByNIS  '); ?>" method="post">
          <div class="form-group mb-3">
            <label for="siswa_id">Siswa ID:</label>
            <input type="number" class="form-control" id="siswa_id" name="siswa_id" placeholder="Silahkan Memasukan Data NIS siswa.." required>
          </div>
          <button type="submit" class="btn btn-primary">Cari Data</button>
        </form>
      </div>
    </div>
  </div>
</section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
        <div class="copyright">
        &copy; Copyright <strong><span>MI AL MA’MURIYAH</span></strong>. All Rights Reserved
      </div>
        </div>
      </div>
    </div>
  </footer><!-- End Footer -->


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script>
  function showPaymentDetails() {
    var selectedMethod = document.getElementById("metode_pembayaran").value;
    if (selectedMethod === "transfer") {
      document.getElementById("transferDetails").style.display = "block";
      document.getElementById("gopayDetails").style.display = "none";
    } else if (selectedMethod === "gopay") {
      document.getElementById("transferDetails").style.display = "none";
      document.getElementById("gopayDetails").style.display = "block";
    } else {
      document.getElementById("transferDetails").style.display = "none";
      document.getElementById("gopayDetails").style.display = "none";
    }
  }

  function payWithGoPay() {
    // Code to handle GoPay payment
    alert("Redirecting to GoPay payment page...");
  }
</script>
  <!-- Vendor JS Files -->
  <script src="asset/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="asset/vendor/aos/aos.js"></script>
  <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="asset/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="asset/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="asset/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="asset/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="asset/js/main.js"></script>

</body>

</html>