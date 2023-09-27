<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/bootstrap-select/dist/css/bootstrap-select.css">
    <link href="../template/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="../assets/DataTables/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/DataTables/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/DataTables/datatables-buttons/css/buttons.bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Hello, world!</title>
    <style>
        .card {
            border-radius: 20px;
        }

        .card-header {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    $log = $_SESSION["log"];
    if ($log != true) {
        echo "
        <script>
        alert ('silahkan login terlebih dahulu');
        window.location.href = '../index.php';
        </script>
    ";
    } else {
        if ($_SESSION["role"] != 2) {
            echo "
            <script>
            alert ('anda adalah admin');
            window.location.href = '../admin/dashboard.php';
            </script>
        ";
        }
    }
    ?>
    <nav class="navbar navbar-expand-md navbar-dark mb-4" style="background-color: #3C43B4;">
        <div class="container">
            <a href="../../index3.html" class="navbar-brand">
                <span class="brand-text font-weight-bold">SPBN BRANTA</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="transaksi.php" class="nav-link"><i class="fas fa-cash-register"></i> Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a href="customer.php" class="nav-link"><i class="fas fa-user"></i> Customer</a>
                    </li>
                    <li class="nav-item">
                        <a href="../logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>