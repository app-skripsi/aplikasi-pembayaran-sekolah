<?php echo view("pages/head"); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <?php echo view("pages/header") ?>
        <?php echo view("pages/aside"); ?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo base_url('/dashboard'); ?>" class="link"><i
                                            class="mdi mdi-home-outline fs-4"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Spp
                                </li>
                            </ol>
                        </nav>
                        <h1 class="mb-0 fw-bold text-center"> Informasi Data Spp </h1>
                    </div>
                </div>
                <a href="<?php echo base_url('/spp/create'); ?>" class="link" style="float: right;">
                    <i class="mdi mdi-plus fs-4 text-primary">Tambah Data</i>
                </a>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">Siswa</th>
                                                <th scope="col" class="text-center">Kelas</th>
                                                <th scope="col" class="text-center">Nis</th>
                                                <th scope="col" class="text-center">Tahun Ajaran</th>
                                                <th scope="col" class="text-center">Bulan</th>
                                                <th scope="col" class="text-center">Nominal</th>
                                                <th scope="col" class="text-center">Tanggal Bayar</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Metode</th>
                                                <th scope="col" class="text-center">Bukti Pembayaran</th>
                                                <th scope="col" class="text-center">Catatan</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($spp as $key => $row) { ?>
                                            <tr>
                                                <td scope="col" class="text-center"><?php echo $key + 1; ?></td>
                                                <td scope="col" class="text-center"><?php echo $row['siswa']; ?></td>
                                                <td scope="col" class="text-center"><?php echo $row['kelas']; ?></td>
                                                <td scope="col" class="text-center"><?php echo $row['nis']; ?></td>
                                                <td scope="col" class="text-center"><?php echo $row['tahun_ajaran']; ?></td>
                                                <td scope="col" class="text-center"><?php echo $row['bulan_pembayaran']; ?>
                                                </td>
                                                <td scope="col" class="text-center"><?php echo $row['nominal_pembayaran']; ?>
                                                </td>
                                                <td scope="col" class="text-center"><?php echo $row['tanggal_pembayaran']; ?>
                                                </td>
                                                <td scope="col" class="text-center"><?php echo $row['status_pembayaran']; ?>
                                                </td>
                                                <td scope="col" class="text-center"><?php echo $row['metode_pembayaran']; ?>
                                                </td>
                                                <td><a href="<?php base_url('uploads/bukti_pembayaran/' . $row['bukti_pembayaran']) ?>"
                                                        id="pseudo-dynamism" target="_blank"><?php echo $row['bukti_pembayaran']; ?></a>
                                                </td>
                                                <td scope="col" class="text-center"><?php echo $row['catatan']; ?></td>
                                                <td scope="col" class="text-center">
                                                    <div class="btn-group">
                                                        <a href="<?php echo base_url('spp/edit/' . $row['id']); ?>"
                                                            class="btn btn-sm btn-secondary">
                                                            edit
                                                        </a>
                                                        <a href="<?php echo base_url('spp/delete/' . $row['id']); ?>"
                                                            class="btn btn-sm btn-danger delete-btn">
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
    </div>
    <?php echo view("pages/script.php"); ?>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
</body>

</html>
