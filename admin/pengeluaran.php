<?php include "../layout/header.php" ?>
<?php
include "../db/koneksi.php";
$query_pengeluaran = mysqli_query($conn, "SELECT * FROM pengeluaran ORDER BY id_pengeluaran DESC");

if (isset($_POST["simpan_pengeluaran"])) {
    require "../admin/function/tambah.php";
    simpan_pengeluaran($_POST);
}
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengeluaran</h1>
        <p class="d-none d-sm-inline-block"><a href="dashboard.php" class="">Dashboard</a> / Pengeluaran</p>
    </div>
    <!-- DataTales Example -->
    <div class="mb-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Tambah Pengeluaran
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
            </div>
        </div>
    </div>
</div>

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
                        <label for="tipe_pengeluaran">Tipe Pengeluaran</label>
                        <select name="tipe_pengeluaran" id="tipe_pengeluaran" class="selectpicker form-control" title="Tipe" required>
                            <option value="Gaji Karyawan">Gaji Karyawan</option>
                            <option value="Biaya Operasional">Biaya Operasional</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rp_perliter">Deskripsi</label>
                        <textarea name="deskripsi" id="dekripsi" cols="10" rows="5" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tgl_pengeluaran">Tgl Pengeluaran</label>
                        <input type="date" name="tgl_pengeluaran" id="tgl_pengeluaran" class="form-control" required value="<?= date("Y-m-d"); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="total_biaya">Biaya Yang Harus Dikeluarkan</label>
                        <input type="text" name="total_biaya" id="total_biaya" class="form-control rp-input" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="simpan_pengeluaran" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "../layout/footer.php" ?>