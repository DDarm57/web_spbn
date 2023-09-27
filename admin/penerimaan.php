<?php include "../layout/header.php" ?>
<?php
include "../db/koneksi.php";
$query_penerimaan = mysqli_query($conn, "SELECT * FROM penerimaan 
INNER JOIN bbm ON bbm.id_bbm = penerimaan.id_bbm
ORDER BY id_penerimaan DESC
");

if (isset($_POST["simpan_penerimaan"])) {
    require "../admin/function/tambah.php";
    simpan_penerimaan($_POST);
}
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Penerimaan</h1>
        <p class="d-none d-sm-inline-block"><a href="dashboard.php" class="">Dashboard</a> / Penerimaan</p>
    </div>
    <!-- DataTales Example -->
    <div class="mb-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Tambah Penerimaan
        </button>
    </div>
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
            </div>
        </div>
    </div>
</div>

<?php
$query_bbm = mysqli_query($conn, "SELECT * FROM bbm");
?>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="id_bbm">BBM</label>
                        <select name="id_bbm" id="id_bbm" class="selectpicker form-control" title="BBM" required>
                            <?php while ($bbm = mysqli_fetch_array($query_bbm)) : ?>
                                <option value="<?= $bbm["id_bbm"]; ?>"><?= $bbm["nama_bbm"]; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rp_perliter">Rp Perliter</label>
                        <input type="text" name="rp_perliter" id="rp_perliter" class="form-control rp-input" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_penerimaan">Tgl Penerimaan</label>
                        <input type="date" name="tgl_penerimaan" id="tgl_penerimaan" class="form-control" required value="<?= date("Y-m-d"); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="isi_liter">Isi Liter</label>
                        <input type="text" name="isi_liter" id="isi_liter" class="form-control rp-input" required>
                    </div>
                    <div class="form-group">
                        <label for="total_rp">Total</label>
                        <div class="input-group">
                            <input type="text" name="total_rp" id="total_rp" class="form-control" required readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-primary" id="hitung-rp">Hitung</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="simpan_penerimaan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "../layout/footer.php" ?>