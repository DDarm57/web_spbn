<?php include "../layout/header.php" ?>
<?php
include "../db/koneksi.php";

if (isset($_POST["update_tangki"])) {
    require "../admin/function/update.php";
    update_tangki($_POST);
}
$id_tangki = $_GET["id_tangki"];
$get_tangki = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tangki INNER JOIN bbm ON bbm.id_bbm = tangki.id_bbm WHERE id_tangki = $id_tangki"));
$query_bbm = mysqli_query($conn, "SELECT * FROM bbm");
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data tangki</h1>
        <p class="d-none d-sm-inline-block"><a href="dashboard.php" class="">Dashboard</a> / <a href="tangki_bbm.php">Tangki BBM</a> / Edit Tangki</p>
    </div>
    <form action="" method="post">
        <input type="hidden" name="id_tangki" id="id_tangki" value="<?= $get_tangki["id_tangki"]; ?>">
        <div class="form-group">
            <label for="nama_tangki">Nama Tangki</label>
            <input type="text" name="nama_tangki" id="nama_tangki" class="form-control" value="<?= $get_tangki["nama_tangki"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="id_bbm">Nama Tangki</label>
            <select name="id_bbm" id="id_bbm" class="form-control">
                <?php foreach ($query_bbm as $row) : ?>
                    <option <?= ($get_tangki["id_bbm"] == $row["id_bbm"] ? "selected" : ""); ?> value="<?= $row["id_bbm"]; ?>"><?= $row["nama_bbm"]; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="jumlah_liter">Jumlah Liter</label>
            <input type="number" name="jumlah_liter" id="jumlah_liter" class="form-control" value="<?= $get_tangki["jumlah_liter"]; ?>" required readonly>
        </div>
        <div class="form-group">
            <label for="kapasitas_liter">Kapasitas Liter</label>
            <input type="number" name="kapasitas_liter" id="kapasitas_liter" class="form-control" value="<?= $get_tangki["kapasitas_liter"]; ?>" required>
        </div>
        <div class="mt-2">
            <button type="submit" name="update_tangki" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
<?php include "../layout/footer.php" ?>