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
                  <a href="<?php echo base_url('/pengajian') ?>">Data Penggajian</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   Tambah Penggajian
                </li>
              </ol>
            </nav>
            <h1 class="mb-0 fw-bold text-center"> Form Tambah Data Penggajian </h1>
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
                <form action="<?= base_url('pengajian/store'); ?>" method="post">
                <div class="form-group">
                  <label class="form-label" for="guru_id">Guru</label>
                  <select class="form-control" id="guru_id" name="guru_id">
                  <option value="">Pilih Guru</option> <!-- Tambahkan opsi ini -->

                    <?php foreach ($guru as $guruItem): ?>
                      <option value="<?= $guruItem['id']; ?>"><?= $guruItem['nama']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                  <div class="form-group">
                    <label class="form-label" for="npk">NIP</label>
                    <input class="form-control form-control-lg" type="text" id="npk" name="npk" placeholder="Masukan NIP"/>
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="bulan">Bulan</label>
                    <input class="form-control form-control-lg" type="text" id="bulan" name="bulan" placeholder="Masukan Bulan" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="tahun">Tahun</label>
                    <input class="form-control form-control-lg" type="text" id="tahun" name="tahun" placeholder="Masukan Tahun" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="tanggal">Tanggal</label>
                    <input class="form-control form-control-lg" type="text" id="tanggal" name="tanggal" placeholder="Masukan Tanggal" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="gaji">Gaji</label>
                    <input class="form-control form-control-lg" type="text" id="gaji" name="gaji" placeholder="Masukan Gaji" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="status">Status Pembayaran</label>
                    <select class="form-control form-control-lg" id="status" name="status" required>
                      <option value="">Pilih Status</option>
                      <?php foreach ($statusPembayaranEnum as $status) : ?>
                        <option value="<?php echo $status; ?>" <?php echo isset($pengajian['status']) && $pengajian['status'] == $status ? 'selected' : ''; ?>><?php echo $status; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="keterangan">Informasi Tambahan</label>
                    <input class="form-control form-control-lg" type="text" id="keterangan" name="keterangan" placeholder="Masukan Informasi Tambahan" />
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
  <script>
    document.getElementById('gaji').addEventListener('input', function(e) {
      var value = e.target.value.replace(/[^,\d]/g, '').toString();
      var split = value.split(',');
      var sisa = split[0].length % 3;
      var rupiah = split[0].substr(0, sisa);
      var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        var separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      e.target.value = '' + rupiah;
    });
  </script>

  <?php echo view("pages/script.php"); ?>
</body>

</html>