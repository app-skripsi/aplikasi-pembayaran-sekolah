<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="logo.png" />
    <title>Slip Gaji Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 100px;
            margin-right: 20px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
        }
        .header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    margin-left: auto; /* Memaksa header berada di sebelah kanan */
}
        .title {
            font-size: 24px;
            font-weight: bold;
        }
        .address {
            font-style: italic;
            margin-bottom: 20px;
        }
        .separator {
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
            padding: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkchBuapL05TOgwkgxg5rx00rf_09PijEo4Q&s" alt="Company Logo">
            <div class="company-name">Mi Al Mamuriyah</div>
        </div>
        <div class="header">
            <h2 style="">Slip Gaji Karyawan</h2>
        </div>
        <div class="address">
            <p>ALAMAT: XXXX</p>
        </div>
        <div class="separator"></div>
        <div class="info">
            <p><strong>Nama:</strong> John Doe</p>
            <p><strong>XX:</strong> XX Value</p>
            <p><strong>XX:</strong> XX Value</p>
            <p><strong>XX:</strong> XX Value</p>
        </div>
        <div class="separator"></div>
        <div class="info">
            <p><strong>Gaji:</strong> Rp. XXXX</p>
        </div>
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> NAMA PERUSAHAAN. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
