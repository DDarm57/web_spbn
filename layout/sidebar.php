<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ADMIN<sup>spbn</sup></div>
    </a>
    <?php
    include "../db/koneksi.php";
    $jml_saldo = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM wallet"));
    if ($jml_saldo == NULL) {
        $saldo = 0;
    } else {
        $saldo = $jml_saldo["saldo"];
    }
    ?>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="wallet.php"><i class="fas fa-fw fa-wallet"></i><span>Wallet <br>Rp. <?= number_format($saldo); ?> </span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="data_karyawan.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Data Karyawan</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="data_customer.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Customer</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="data_bbm.php">
            <i class="fas fa-fw fa-oil-can"></i>
            <span>Data BBM</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="tangki_bbm.php">
            <i class="fas fa-fw fa-oil-can"></i>
            <span>Tangki BBM</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="pemasukan.php">
            <i class="fas fa-money-bill-wave"></i>
            <span>Pemasukan </span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="hutang_customer.php">
            <i class="fas fa-receipt"></i>
            <span>Hutang Customer</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="penerimaan.php">
            <i class="fas fa-money-check"></i>
            <span>Penerimaan</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="pengeluaran.php">
            <i class="fas fa-money-check"></i>
            <span>Pengeluaran</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="laporan.php">
            <i class="fas fa-money-check"></i>
            <span>Laporan Keuangan</span></a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-4">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>