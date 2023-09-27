<?php include "../layout/header.php" ?>
<?php
include "../db/koneksi.php";
if (isset($_POST["simpan_bbm"])) {
    require "../admin/function/tambah.php";
    simpan_bbm($_POST);
}
if (isset($_GET["id_bbm"])) {
    require "../admin/function/hapus.php";
    hapus_bbm($_GET);
}
if (isset($_POST["update_bbm"])) {
    require "../admin/function/update.php";
    update_bbm($_POST);
}
$query_bbm = mysqli_query($conn, "SELECT * FROM bbm");
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data BBM</h1>
        <p class="d-none d-sm-inline-block"><a href="dashboard.php" class="">Dashboard</a> / Data BBM</p>
    </div>

    <div class="mb-2">
        <a href="" class="btn btn-sm btn-primary" data-toggle="modal" id="tambah-bbm" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah Data</a>
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
                            <th>Nama BBM</th>
                            <th>Harga BBM Perliter</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($row = mysqli_fetch_array($query_bbm)) :
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row["nama_bbm"]; ?></td>
                                <td>Rp. <?= number_format($row["harga_perliter"]); ?></td>
                                <td>
                                    <a href="" class="edit-bbm btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal" data-id_bbm="<?= $row["id_bbm"]; ?>" data-nama_bbm="<?= $row["nama_bbm"]; ?>" data-harga_perliter="<?= $row["harga_perliter"]; ?>"><i class="fas fa-pen"></i></a>
                                    <a href="data_bbm.php?id_bbm=<?= $row["id_bbm"]; ?>" class="btn btn-sm btn-danger hapus"><i class="fas fa-trash"></i></a>
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
                    <input type="hidden" name="id_bbm" id="id_bbm">
                    <div class="form-group">
                        <label for="nama_bbm">Nama BBM</label>
                        <input type="text" name="nama_bbm" id="nama_bbm" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_perliter">Harga Perliter</label>
                        <input type="text" name="harga_perliter" id="harga_perliter" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_bbm" id="btn-simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "../layout/footer.php" ?>