<?php include "../layout/header.php" ?>
<?php
include "../db/koneksi.php";
if (isset($_GET["cari"])) {
    $dari_tgl = $_GET["dari"];
    $sampai_tgl = $_GET["sampai"];
} else {
    $dari_tgl = date("Y-m-01");
    $sampai_tgl = date("Y-m-01", strtotime("+ 30 day"));
}

$query_bbm = mysqli_query($conn, "SELECT * FROM pemasukan 
INNER JOIN bbm ON bbm.id_bbm = pemasukan.id_bbm
INNER JOIN karyawan ON karyawan.id_karyawan = pemasukan.id_karyawan
INNER JOIN customer ON customer.id_customer = pemasukan.id_customer
WHERE tgl_pemasukan BETWEEN '$dari_tgl' AND '$sampai_tgl'
ORDER BY id_pemasukan DESC
");
$query_penerimaan = mysqli_query($conn, "SELECT * FROM penerimaan 
INNER JOIN bbm ON bbm.id_bbm = penerimaan.id_bbm
WHERE tgl_penerimaan BETWEEN '$dari_tgl' AND '$sampai_tgl'
ORDER BY id_penerimaan DESC
");
$query_pengeluaran = mysqli_query($conn, "SELECT * FROM pengeluaran WHERE tgl_pengeluaran BETWEEN '$dari_tgl' AND '$sampai_tgl' ORDER BY id_pengeluaran DESC");
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Keuangan</h1>
        <p class="d-none d-sm-inline-block"><a href="dashboard.php" class="">Dashboard</a> / Laporan Keuangan</p>
    </div>
    <!-- DataTales Example -->
    <div class="mb-2">
        <div class="row">
            <div class="col-sm-6">
                <form action="" class="mb-2">
                    <div class="input-group">
                        <input type="date" name="dari" id="" class="form-control form-control-sm" value="<?= $dari_tgl; ?>" required>
                        <input type="date" name="sampai" id="" class="form-control form-control-sm" value="<?= $sampai_tgl; ?>" required>
                        <div class="input-group-append">
                            <a href="laporan.php" class="btn btn-sm btn-primary"><i class="fas fa-sync"></i></a>
                            <button type="submit" name="cari" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card border-left-primary shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary mt-2">Pemasukan</h6>
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalpemasukan" id="print-pemasukan">Download</button>
            </div>
        </div>
        <div class="card-body">
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
                <?php
                $total = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(pendapatan) FROM pemasukan WHERE tgl_pemasukan BETWEEN '$dari_tgl' AND '$sampai_tgl'"));
                $total_hutang = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(hutang) FROM pemasukan WHERE tgl_pemasukan BETWEEN '$dari_tgl' AND '$sampai_tgl'"));
                $total_liter = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(liter_terjual) FROM pemasukan WHERE tgl_pemasukan  BETWEEN '$dari_tgl' AND '$sampai_tgl'"))
                ?>
                <div class="text-right mt-2">
                    <?php
                    if ($total) {
                        $total_pendapatan = $total[0];
                    } else {
                        $total_pendapatan = 0;
                    }
                    ?>
                    <div class="d-flex justify-content-end">
                        <div class="px-2">
                            <h5 class="bg-info p-1 rounded text-light">Total Liter Terjual : <strong><?= number_format($total_liter[0]); ?></strong> Ltr</h5>
                        </div>
                        <div class="px-2">
                            <h5 class="bg-danger p-1 rounded text-light">Total Hutang Customer : Rp. <strong><?= number_format($total_hutang[0]); ?></strong></h5>
                        </div>
                        <div class="px-2">
                            <h5 class="bg-success p-1 rounded text-light">Total Pendapatan : Rp. <strong><?= number_format($total_pendapatan); ?></strong></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $pengeluaran = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(total_biaya) FROM pengeluaran WHERE tgl_pengeluaran BETWEEN '$dari_tgl' AND '$sampai_tgl'"));
    $penerimaan = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(total_rp) FROM penerimaan WHERE tgl_penerimaan BETWEEN '$dari_tgl' AND '$sampai_tgl'"));
    $total_pengeluaran = $pengeluaran[0] + $penerimaan[0];
    ?>
    <div class="card border-left-primary shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary mt-2">Penerimaan & Pengeluaran</h6>
                <!-- <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalpemasukan" id="print-pengeluaran">Download</button> -->
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama BBM</th>
                                    <th>Isi Liter</th>
                                    <th>Tgl Penerimaan</th>
                                    <th>Rp Perliter</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_array($query_penerimaan)) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row["nama_bbm"]; ?></td>
                                        <td><?= number_format($row["isi_liter"]); ?></td>
                                        <td><?= $row["tgl_penerimaan"]; ?></td>
                                        <td>Rp. <?= number_format($row["rp_perliter"]); ?></td>
                                        <td>Rp. <?= number_format($row["total_rp"]); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <div class="mt-2">
                            <h5>Total : Rp. <?= number_format($penerimaan[0]); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-bordered table-stripped" id="example3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tipe Pengeluaran</th>
                                    <th>Deskripsi</th>
                                    <th>Tgl Pengeluaran</th>
                                    <th>Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_array($query_pengeluaran)) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row["tipe_pengeluaran"]; ?></td>
                                        <td><?= $row["deskripsi"]; ?></td>
                                        <td><?= $row["tgl_pengeluaran"]; ?></td>
                                        <td>Rp. <?= number_format($row["total_biaya"]); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <div class="mt-2">
                            <h5>Total : Rp. <?= number_format($pengeluaran[0]); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2 text-right">
                <h5>Total Penerimaan + Pengeluaran = Rp. <?= number_format($total_pengeluaran); ?></h5>
            </div>
        </div>
    </div>
</div>

<!-- Modal donwload pemasukan -->
<div class="modal fade" id="exampleModalpemasukan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="view-laporan">
                    <input type="hidden" name="status" id="" value="view">
                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <div class="input-group">
                            <input type="month" name="bulan" id="bulan" class="form-control" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-sm btn-primary">Cek Data</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="content-laporan" style="font-size:small; overflow-x:auto;">
                    <div class="text-center mt-4" id="loading">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close-modal">Close</button>
                <a href="" class="btn btn-primary" id="simpan-pdf">Simpan</a>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footer.php" ?>