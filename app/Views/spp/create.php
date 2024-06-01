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
                  <a href="<?php echo base_url('/spp') ?>">Data SPP</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Tambah SPP
                </li>
              </ol>
            </nav>
            <h1 class="mb-0 fw-bold text-center"> Form Tambah Data SPP </h1>
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
                <form action="<?= base_url('spp/store'); ?>" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="form-label" for="kelas_id">Kelas</label>
                    <select class="form-control form-control-lg" id="kelas_id" name="kelas_id">
                      <option value="">Pilih Kelas</option>
                      <?php foreach ($kelas as $kelas_item) : ?>
                        <option value="<?= $kelas_item['id'] ?>"><?= $kelas_item['kelas'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="siswa_id">Siswa</label>
                    <select class="form-control form-control-lg" id="siswa_id" name="siswa_id">
                      <option value="">Pilih Siswa</option>
                      <?php foreach ($siswa as $siswa_item) : ?>
                        <option value="<?= $siswa_item['id'] ?>"><?= $siswa_item['nama'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="nis">NIS</label>
                    <input class="form-control form-control-lg" type="number" id="nis" name="nis" placeholder="Masukan Nis" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="bulan">Bulan</label>
                    <input class="form-control form-control-lg" type="number" id="bulan" name="bulan" placeholder="Masukan Bulan" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="tahun_ajaran">Tahun Ajaran</label>
                    <input class="form-control form-control-lg" type="text" id="tahun_ajaran" name="tahun_ajaran" placeholder="Masukan Tahun" min="1900" max="2100" step="1" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="bulan_pembayaran">Bulan Pembayaran</label>
                    <input class="form-control form-control-lg" type="text" id="bulan_pembayaran" name="bulan_pembayaran" placeholder="Masukan Bulan Pembayaran" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="nominal_pembayaran">Nominal Pembayaran</label>
                    <input class="form-control form-control-lg" type="text" id="nominal_pembayaran" name="nominal_pembayaran" placeholder="Masukan Nominal Pembayaran" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="tanggal_pembayaran">Tanggal Pembayaran</label>
                    <input class="form-control form-control-lg" type="text" id="tanggal_pembayaran" name="tanggal_pembayaran" placeholder="Masukan Tanggal" maxlength="2" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="status_pembayaran">Status Pembayaran</label>
                    <select class="form-control form-control-lg" id="status_pembayaran" name="status_pembayaran" required>
                      <option value="">Pilih Status Pembayaran</option>
                      <?php foreach ($statusPembayaranEnum as $status) : ?>
                        <option value="<?php echo $status; ?>" <?php echo isset($spp['status_pembayaran']) && $spp['status_pembayaran'] == $status ? 'selected' : ''; ?>><?php echo $status; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="metode_pembayaran">Metode Pembayaran</label>
                    <select class="form-control form-control-lg" id="metode_pembayaran" name="metode_pembayaran" required>
                      <option value="">Pilih Metode Pembayaran</option>
                      <?php foreach ($metodePembayaranEnum as $pembayaran) : ?>
                        <option value="<?php echo $pembayaran; ?>" <?php echo isset($spp['metode_pembayaran']) && $spp['metode_pembayaran'] == $pembayaran ? 'selected' : ''; ?>><?php echo $pembayaran; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="bukti_pembayaran">Bukti Pembayaran</label>
                    <input class="form-control form-control-lg" type="file" id="bukti_pembayaran" name="bukti_pembayaran" placeholder="Bukti Pembayaran" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="catatan">Catatan Pembayaran</label>
                    <input class="form-control form-control-lg" type="text" id="catatan" name="catatan" placeholder="Masukan Catatan Pembayaran" />
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
  <script>
    document.getElementById('tanggal_pembayaran').addEventListener('input', function(e) {
      var value = e.target.value.replace(/[^0-9]/g, '');
      if (value.length > 2) value = value.slice(0, 2);
      e.target.value = value;
    });
  </script>
  <script>
    document.getElementById('nominal_pembayaran').addEventListener('input', function(e) {
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
</body>

</html>