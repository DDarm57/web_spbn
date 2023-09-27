<?php include "../layout/header.php" ?>
<?php
include "../db/koneksi.php";
if (isset($_POST["simpan_tangki"])) {
    require "../admin/function/tambah.php";
    simpan_tangki($_POST);
}
if (isset($_GET["id_tangki"])) {
    require "../admin/function/hapus.php";
    hapus_tangki($_GET);
}
if (isset($_POST["update_tangki"])) {
    require "../admin/function/update.php";
    update_tangki($_POST);
}
$query_tangki = mysqli_query($conn, "SELECT * FROM tangki INNER JOIN bbm ON bbm.id_bbm = tangki.id_bbm");
$query_bbm = mysqli_query($conn, "SELECT * FROM bbm");
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data tangki</h1>
        <p class="d-none d-sm-inline-block"><a href="dashboard.php" class="">Dashboard</a> / Tangki BBM</p>
    </div>

    <div class="mb-2">
        <a href="" class="btn btn-sm btn-primary" data-toggle="modal" id="tambah-tangki" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah Data</a>
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
                            <th>Nama Tangki</th>
                            <th>Nama BBM</th>
                            <th>Kapasitas Liter</th>
                            <th>Jumlah Liter</th>
                            <th>Harga BBM Perliter</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($row = mysqli_fetch_array($query_tangki)) :
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row["nama_tangki"]; ?></td>
                                <td><?= $row["nama_bbm"]; ?></td>
                                <td><?= number_format($row["kapasitas_liter"]); ?> Ltr</td>
                                <td><?= number_format($row["jumlah_liter"]); ?> Ltr</td>
                                <td>Rp. <?= number_format($row["harga_perliter"]); ?></td>
                                <td>
                                    <a href="edit_tangki.php?id_tangki=<?= $row["id_tangki"]; ?>" class="btn btn-sm btn-warning edit-tangki"><i class="fas fa-pen"></i></a>
                                    <a href="tangki_bbm.php?id_tangki=<?= $row["id_tangki"]; ?>" class="btn btn-sm btn-danger hapus"><i class="fas fa-trash"></i></a>
                                </td>
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
            <form action="" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_tangki" id="id_tangki">
                    <div class="form-group">
                        <label for="nama_tangki">Nama Tangki</label>
                        <input type="text" name="nama_tangki" id="nama_tangki" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="id_bbm">Nama Tangki</label>
                        <select name="id_bbm" id="id_bbm" class="form-control">
                            <?php foreach ($query_bbm as $row) : ?>
                                <option value="<?= $row["id_bbm"]; ?>"><?= $row["nama_bbm"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_liter">Jumlah Liter</label>
                        <input type="number" name="jumlah_liter" id="jumlah_liter" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_tangki" id="btn-simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "../layout/footer.php" ?>