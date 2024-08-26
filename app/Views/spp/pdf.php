<html>

<head>
    <link rel="icon" type="image/png" sizes="16x16" href="logo.png" />
    <style>
        .table-header,
        .table-cell {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .table-header {
            background-color: #f2f2f2;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            /* Add space between rows */
        }

        @media (max-width: 768px) {

            .table-header,
            .table-cell {
                font-size: 12px;
                /* Adjust font size for smaller screens */
            }
        }
    </style>
</head>

<body>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th class="table-header" style="text-align: center;">No</th>
                    <th scope="col" class="text-center">Siswa</th>
                    <th scope="col" class="text-center">Kelas</th>
                    <th scope="col" class="text-center">Nis</th>
                    <th scope="col" class="text-center">Tahun Ajaran</th>
                    <th scope="col" class="text-center">Bulan</th>
                    <th scope="col" class="text-center">Nominal</th>
                    <th scope="col" class="text-center">Tanggal Bayar</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Metode</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($spp as $key => $row) { ?>
                    <tr>
                        <td scope="col" class="text-center"><?php echo $key + 1; ?></td>
                        <td scope="col" class="text-center"><?php echo $row['nama']; ?></td>
                        <td scope="col" class="text-center"><?php echo $row['kelas']; ?></td>
                        <td scope="col" class="text-center"><?php echo $row['nis']; ?></td>
                        <td scope="col" class="text-center"><?php echo $row['tahun_ajaran']; ?></td>
                        <td scope="col" class="text-center"><?php echo $row['bulan_pembayaran']; ?></td>
                        <td scope="col" class="text-center">
                            <?php echo 'Rp. ' . number_format($row['nominal_pembayaran'], 3, ',', '.'); ?></td>
                        <td scope="col" class="text-center"><?php echo $row['tanggal_pembayaran']; ?></td>
                        <td scope="col" class="text-center"><?php echo $row['status_pembayaran']; ?></td>
                        <td scope="col" class="text-center"><?php echo $row['metode_pembayaran']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>