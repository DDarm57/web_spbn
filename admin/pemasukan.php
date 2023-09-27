<?php include "../layout/header.php" ?>
<?php
include "../db/koneksi.php";
if (isset($_GET["bulan"])) {
    $bulan = $_GET["bulan"];
} else {
    $bulan = date("Y-m");
}
$query_bbm = mysqli_query($conn, "SELECT * FROM pemasukan 
INNER JOIN bbm ON bbm.id_bbm = pemasukan.id_bbm
INNER JOIN karyawan ON karyawan.id_karyawan = pemasukan.id_karyawan
INNER JOIN customer ON customer.id_customer = pemasukan.id_customer
WHERE tgl_pemasukan LIKE '$bulan%'
ORDER BY id_pemasukan DESC
");
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pemasukan</h1>
        <p class="d-none d-sm-inline-block"><a href="dashboard.php" class="">Dashboard</a> / Pemasukan</p>
    </div>
    <!-- DataTales Example -->
    <div class="card border-left-primary shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="mb-2">
                <form action="">
                    <div class="input-group">
                        <div class="input-group-append">
                            <a href="pemasukan.php" class="btn btn-sm btn-primary"><i class="fas fa-sync"></i></a>
                        </div>
                        <input type="month" name="bulan" class="form-control form-control-sm" value="<?= $bulan; ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-stripped" id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama BBM</th>
                            <th>Karyawan</th>
                            <th>Customer</th>
                            <th>Tanggal</th>
                            <th>Liter Terjual</th>
                            <th>Hutang</th>
                            <th>Status</th>
                            <th>Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($row = mysqli_fetch_array($query_bbm)) :
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row["nama_bbm"]; ?></td>
                                <td><?= $row["nama_karyawan"]; ?></td>
                                <td><?= $row["nama"]; ?></td>
                                <td><?= $row["tgl_pemasukan"]; ?></td>
                                <td><?= $row["liter_terjual"]; ?></td>
                                <td>Rp. <?= number_format($row["hutang"]); ?></td>
                                <td>
                                    <p class="p-1 rounded text-light <?= ($row["status"] == "lunas" ? "bg-success" : "bg-danger"); ?>"><strong><?= $row["status"]; ?></strong></p>
                                </td>
                                <td>Rp. <?= number_format($row["pendapatan"]); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php $total = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(pendapatan) FROM pemasukan WHERE tgl_pemasukan LIKE '$bulan%'")) ?>
                <div class="text-right mt-2">
                    <?php
                    if ($total) {
                        $total_pendapatan = $total[0];
                    } else {
                        $total_pendapatan = 0;
                    }
                    ?>
                    <h5>TOTAL : <?= number_format($total_pendapatan); ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footer.php" ?>