<?php include "../layout/header.php" ?>
<?php

include "../db/koneksi.php";
$bulan = date("Y-m");
function tgl_indo($tanggal)
{
    $bulan = array(
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tahun
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tanggal

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

if (isset($_GET["cari"])) {
    $dari_tgl = $_GET["dari"];
    $sampai_tgl = $_GET["sampai"];
} else {
    $tgl_pendTerakhir = mysqli_fetch_array(mysqli_query($conn, "SELECT tgl_pemasukan FROM pemasukan 
    GROUP BY tgl_pemasukan ORDER BY tgl_pemasukan DESC"));
    // $tgl_peneTerakhir = mysqli_fetch_array(mysqli_query($conn, "SELECT tgl_penerimaan FROM penerimaan
    // GROUP BY tgl_penerimaan ORDER BY tgl_penerimaan DESC"));
    if ($tgl_pendTerakhir != NULL) {
        $dari_tgl = $tgl_pendTerakhir["tgl_pemasukan"];
        $sampai_tgl = $tgl_pendTerakhir["tgl_pemasukan"];
    } else {
        $dari_tgl = date("Y-m-01");
        $sampai_tgl = date("Y-m-01", strtotime("+ 30 day"));
    }
}

$jml_saldo = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM wallet"));
if ($jml_saldo == NULL) {
    $saldo = 0;
} else {
    $saldo = $jml_saldo["saldo"];
}
$pemasukan = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(pendapatan) FROM pemasukan WHERE tgl_pemasukan BETWEEN '$dari_tgl%' AND '$sampai_tgl%'"));

$data_bbm = mysqli_query($conn, "SELECT * FROM bbm");

$bg = [
    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
    '#858796', '#5a5c69', '#f8f9fc', '#d1d3e2', '#f8f9fc'
];

$pengeluaran = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(total_biaya) FROM pengeluaran WHERE tgl_pengeluaran BETWEEN '$dari_tgl' AND '$sampai_tgl'"));
$penerimaan = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(total_rp) FROM penerimaan WHERE tgl_penerimaan BETWEEN '$dari_tgl' AND '$sampai_tgl'"));

// var_dump($penerimaan);
// exit;

$total_pengeluaran = $pengeluaran[0] + $penerimaan[0];


$total_pendapatan = $pemasukan[0] - $total_pengeluaran;

$hutang_cust = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(hutang) FROM pemasukan"));

?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block">Dashboard</a>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <form action="" class="mb-2">
                <div class="input-group">
                    <input type="date" name="dari" id="" class="form-control form-control-sm" value="<?= $dari_tgl; ?>" required>
                    <input type="date" name="sampai" id="" class="form-control form-control-sm" value="<?= $sampai_tgl; ?>" required>
                    <div class="input-group-append">
                        <a href="dashboard.php" class="btn btn-sm btn-primary"><i class="fas fa-sync"></i></a>
                        <button type="submit" name="cari" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-6">
            <h5>Result : <?= tgl_indo($dari_tgl); ?> - <?= tgl_indo($sampai_tgl); ?></h5>
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pemasukan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($pemasukan[0]); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pengeluaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($total_pengeluaran); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-check-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($total_pendapatan); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Hutang Cust</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($hutang_cust[0]); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Total Transkasi BBM</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area" style="width: 100%; margin: auto;">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Total Liter Terjual</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2" style="width: 100%; margin: auto;">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small label-chart">
                        <?php
                        $no = 0;
                        while ($row = mysqli_fetch_array($data_bbm)) : ?>
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color: <?= $bg[$no++]; ?>;"></i> <?= $row["nama_bbm"]; ?>
                            </span>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Total Pemasukan dan Pendapatan Pertahun</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <p><i class="fas fa-circle" style="color:darkcyan;"></i> Total Pendapatan Seharusnya</p>
                <p class="px-2"><i class="fas fa-circle" style="color:blue;"></i> Total Pendapatan</p>
                <p><i class="fas fa-circle" style="color:indianred;"></i> Total Hutang Customer</p>
            </div>
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>
<?php include "../layout/footer.php" ?>