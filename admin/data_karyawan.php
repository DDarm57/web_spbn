<?php include "../layout/header.php" ?>
<?php
include "../db/koneksi.php";
if (isset($_POST["simpan_karyawan"])) {
    require "../admin/function/tambah.php";
    simpan_karyawan($_POST);
}
if (isset($_GET["user_id"])) {
    require "../admin/function/hapus.php";
    hapus_karyawan($_GET);
}
if (isset($_POST["update_karyawan"])) {
    require "../admin/function/update.php";
    update_karyawan($_POST);
}
$query_karyawan = mysqli_query($conn, "SELECT * FROM karyawan");
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Karyawan</h1>
        <p class="d-none d-sm-inline-block"><a href="dashboard.php" class="">Dashboard</a> / Data Karyawan</p>
    </div>

    <div class="mb-2">
        <a href="" class="btn btn-sm btn-primary" data-toggle="modal" id="tambah-karyawan" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah Data</a>
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
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($row = mysqli_fetch_array($query_karyawan)) :
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row["nama_karyawan"]; ?></td>
                                <td><?= $row["jk"]; ?></td>
                                <td><?= $row["alamat"]; ?></td>
                                <td><?= $row["no_hp"]; ?></td>
                                <td>
                                    <?php
                                    $id_user = $row["user_id"];
                                    $get_user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id_user='$id_user'"));
                                    ?>
                                    <a href="" class="btn btn-sm btn-warning edit-karyawan" data-toggle="modal" data-target="#exampleModal" data-id_user="<?= $id_user; ?>" data-nama="<?= $row["nama_karyawan"]; ?>" data-jk="<?= $row["jk"]; ?>" data-alamat="<?= $row["alamat"]; ?>" data-no_hp="<?= $row["no_hp"]; ?>" data-username="<?= $get_user["username"]; ?>" data-password="<?= $get_user["password"]; ?>"><i class="fas fa-pen"></i></a>
                                    <a href="data_karyawan.php?user_id=<?= $row["user_id"]; ?>" class="btn btn-sm btn-danger hapus"><i class="fas fa-trash"></i></a>
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
                    <input type="hidden" name="id_user" id="id_user">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">JK</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" id="exampleRadios1" value="L" required>
                            <label class="form-check-label" for="exampleRadios1">
                                L (Laki-laki)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" id="exampleRadios2" value="P" required>
                            <label class="form-check-label" for="exampleRadios2">
                                P (Perempuan)
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">NO Hp</label>
                        <input type="number" name="no_hp" id="no_hp" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="username">Username (digunakan untuk login)</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">Password (digunakan untuk login)</label>
                                <input type="text" name="password" id="password" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_karyawan" id="btn-simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "../layout/footer.php" ?>