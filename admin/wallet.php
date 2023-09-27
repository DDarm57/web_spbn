<?php include "../layout/header.php" ?>
<?php
include "../db/koneksi.php";
$query_deposit = mysqli_query($conn, "SELECT * FROM deposit ORDER BY id_deposit DESC");
$jml_saldo = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM wallet"));
if ($jml_saldo == NULL) {
    $saldo = 0;
} else {
    $saldo = $jml_saldo["saldo"];
}
if (isset($_POST["simpan_deposit"])) {
    require "../admin/function/tambah.php";
    simpan_deposit($_POST);
}
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Deposit</h1>
        <p class="d-none d-sm-inline-block"><a href="dashboard.php" class="">Dashboard</a> / Data Deposit</p>
    </div>
    <div class="card border-left-primary shadow h-100 py-2 mb-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Jumlah Saldo Perusahaan</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($saldo); ?></div>
                    <div class="mt-2">
                        <a href="" class="btn btn-sm btn-primary" data-toggle="modal" id="tambah-tangki" data-target="#exampleModal"><i class="fas fa-plus"></i> Deposit</a>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-money-bill-wave-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card border-left-primary shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-stripped" id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Info</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($row = mysqli_fetch_array($query_deposit)) :
                            if ($row["info"] != "deposit") {
                                $info = "(-)";
                            } else {
                                $info = "(+)";
                            }
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row["info"]; ?></td>
                                <td><?= $info; ?> Rp. <?= number_format($row["total_deposit"]); ?></td>
                                <td><?= $row["tanggal"]; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deposit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $tgl_pendTerakhir = mysqli_fetch_array(mysqli_query($conn, "SELECT tgl_pemasukan FROM pemasukan GROUP BY tgl_pemasukan ORDER BY tgl_pemasukan DESC"));
            $pendapatan_terakhir = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(pendapatan) FROM pemasukan GROUP BY tgl_pemasukan ORDER BY tgl_pemasukan DESC"));
            ?>
            <form action="" method="post">
                <div class="modal-body">
                    <?php if ($tgl_pendTerakhir != NULL) : ?>
                        <?php if ($pendapatan_terakhir != 0) : ?>
                            <div class="alert alert-info">
                                <div class="d-flex">
                                    <div class="">
                                        Total Pemasukan Terakhir
                                    </div>
                                    <div class="px-2">
                                        <p id="pendTerakhir"><?= number_format($pendapatan_terakhir[0]); ?></p>
                                    </div>
                                    <a href="" id="inp-pendTerakhir">Inputkan</a>
                                </div>
                                Dari Tanggal : <?= $tgl_pendTerakhir["tgl_pemasukan"]; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="total_deposit">Jumlah Deposit</label>
                        <input type="text" name="total_deposit" id="total_deposit" class="form-control rp-input" required>
                        <small id="msg-total" class="text-info">Pastikan sesuai dengan total pendapatan yang ada</small>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= date("Y-m-d"); ?>" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" onclick="return confirm('Deposit Sekarang? pastikan jumlah deposit sesuai.')" name="simpan_deposit" id="btn-simpan" class="btn btn-primary">Deposit Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "../layout/footer.php" ?>