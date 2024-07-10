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
                  Edit Spp
                </li>
              </ol>
            </nav>
            <h1 class="mb-0 fw-bold text-center"> Form Edit Data Spp </h1>
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
                <form action="<?= site_url('spp/update/' . $spp['id']); ?>" enctype="multipart/form-data" method="post">
                <?php echo form_hidden('id', $spp['id']); ?>
                  <div class="form-group">
                    <?php echo form_label('Kelas', 'kelas_id'); ?>
                    <?php echo form_dropdown('kelas_id', $kelas, $spp['kelas_id'], ['class' => 'form-control']); ?>
                  </div><br>
                  <div class="form-group">
                    <?php echo form_label('Siswa', 'siswa_id'); ?>
                    <?php echo form_dropdown('siswa_id', $siswa, $spp['siswa_id'], ['class' => 'form-control']); ?>
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="nis">NIS</label>
                    <input class="form-control form-control-lg" type="text" id="nis" name="nis" value="<?php echo isset($spp['nis']) ? $spp['nis'] : ''; ?>" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="tahun_ajaran">Tahun Ajaran</label>
                    <input class="form-control form-control-lg" type="text" id="tahun_ajaran" name="tahun_ajaran" value="<?php echo isset($spp['tahun_ajaran']) ? $spp['tahun_ajaran'] : ''; ?>" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="bulan_pembayaran">Bulan</label>
                    <input class="form-control form-control-lg" type="text" id="bulan_pembayaran" name="bulan_pembayaran" value="<?php echo isset($spp['bulan_pembayaran']) ? $spp['bulan_pembayaran'] : ''; ?>" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="nominal_pembayaran">Tagihan</label>
                    <input class="form-control form-control-lg" type="text" id="nominal_pembayaran" name="nominal_pembayaran" value="<?php echo isset($spp['nominal_pembayaran']) ? $spp['nominal_pembayaran'] : ''; ?>" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="tanggal_pembayaran">Tanggal Pembayaran</label>
                    <input class="form-control form-control-lg" type="text" id="tanggal_pembayaran" name="tanggal_pembayaran" value="<?php echo isset($spp['tanggal_pembayaran']) ? $spp['tanggal_pembayaran'] : ''; ?>" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="status_pembayaran">Status Pembayaran</label>
                    <select class="form-control form-control-lg" id="status_pembayaran" name="status_pembayaran" required>
                      <!-- <option value="">Pilih Status Pembayaran</option> -->
                      <?php foreach ($statusPembayaranEnum as $status) : ?>
                        <option value="<?php echo $status; ?>" <?php echo isset($spp['status_pembayaran']) && $spp['status_pembayaran'] == $status ? 'selected' : ''; ?>><?php echo $status; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="bukti_pembayaran">Bukti Pembayaran</label>
                    <input class="form-control form-control-lg" type="file" id="bukti_pembayaran" name="bukti_pembayaran" value="<?php echo isset($spp['bukti_pembayaran']) ? $spp['bukti_pembayaran'] : ''; ?>" />
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="metode_pembayaran">Metode Pembayaran</label>
                    <select class="form-control form-control-lg" id="metode_pembayaran" name="metode_pembayaran" required>
                      <!-- <option value="">Pilih Metode Pembayaran</option> -->
                      <?php foreach ($metodePembayaranEnum as $pembayaran) : ?>
                        <option value="<?php echo $pembayaran; ?>" <?php echo isset($spp['metode_pembayaran']) && $spp['metode_pembayaran'] == $pembayaran ? 'selected' : ''; ?>><?php echo $pembayaran; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div><br>
                  <div class="form-group">
                    <label class="form-label" for="catatan">Catatan</label>
                    <input class="form-control form-control-lg" type="text" id="catatan" name="catatan" value="<?php echo isset($spp['catatan']) ? $spp['catatan'] : ''; ?>" />
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