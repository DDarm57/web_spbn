<?php include "../layout/header.php" ?>
<?php
include "../db/koneksi.php";
$id_customer = $_GET["id_customer"];
$query_customer = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM customer 
WHERE id_customer='$id_customer'"));
// var_dump($query_customer);
$get_hutang = mysqli_query($conn, "SELECT * FROM pemasukan
INNER JOIN bbm ON bbm.id_bbm = pemasukan.id_bbm
INNER JOIN karyawan ON karyawan.id_karyawan = pemasukan.id_karyawan
WHERE id_customer='$id_customer' AND status='belum lunas'");
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Hutang</h1>
        <p class="d-none d-sm-inline-block"><a href="dashboard.php" class="">Dashboard</a> / Detail Hutang</p>
    </div>
    <!-- Card Example -->
    <div class="card border-left-primary shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="py-5">
                        <table class="table-responsive">
                            <tbody>
                                <tr>
                                    <td rowspan="3" style="width: 100px;">
                                        <div class="p-2">
                                            <img class="img-profile rounded-circle" src="../template/img/undraw_profile.svg" width="70px">
                                        </div>
                                    </td>
                                    <td><i class="fas fa-user"></i></td>
                                    <td>:</td>
                                    <td><?= $query_customer["nama"]; ?></td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-map"></i></td>
                                    <td>:</td>
                                    <td><?= $query_customer["alamat"]; ?></td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-phone"></i></td>
                                    <td>:</td>
                                    <td><?= $query_customer["no_hp"]; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-6">
                    <form action="bayar_hutang.php" method="post" id="form-hutang" hidden>
                        <input type="hidden" name="id_customer" id="id_customer" value="<?= $id_customer; ?>">
                        <input type="hidden" name="id_pemasukan" id="id_pemasukan">
                        <div class="form-group" id="jml-hutang">
                            <label for="hutang">Hutang</label>
                            <input type="text" name="hutang" id="hutang" class="form-control form-control-sm" readonly required>
                        </div>
                        <label for="bayar">Bayar</label>
                        <input type="hidden" name="kurang" id="kurang">
                        <div class="input-group">
                            <input type="text" name="bayar" id="membayar" class="form-control form-control-sm rp-input" readonly required>
                            <div class="input-group-append">
                                <button type="submit" onclick="return confirm('Kofirmasi Pembayaran')" class="btn btn-primary btn-sm">Bayar</button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start mt-2">
                            <div class="">
                                <h5 id="nama-bbm"></h5>
                            </div>
                            <h5 id="hasil" class="px-2"></h5>
                            <h5 id="total"></h5>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-stripped" id="example1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama BBM</th>
                                <th>Karyawan</th>
                                <th>Tanggal</th>
                                <th>Liter Terjual</th>
                                <th>Total</th>
                                <th>Hutang</th>
                                <th>Status</th>
                                <th>Pendapatan (Membayar)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($row = mysqli_fetch_array($get_hutang)) :
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row["nama_bbm"]; ?></td>
                                    <td><?= $row["nama_karyawan"]; ?></td>
                                    <td><?= $row["tgl_pemasukan"]; ?></td>
                                    <td><?= $row["liter_terjual"]; ?></td>
                                    <td><?= number_format($row["total"]); ?></td>
                                    <td>Rp. <?= number_format($row["hutang"]); ?></td>
                                    <td><?= $row["status"]; ?></td>
                                    <td>Rp. <?= number_format($row["pendapatan"]); ?></td>
                                    <td><a href="" class="btn btn-sm btn-primary bayar" data-id_pemasukan="<?= $row["id_pemasukan"]; ?>" data-nama_bbm="<?= $row["nama_bbm"]; ?>" data-hutang="<?= $row["hutang"]; ?>">Bayar</a></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php $total = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(hutang) FROM pemasukan WHERE id_customer='$id_customer' AND status='belum lunas'")) ?>
                    <div class="text-right mt-2">
                        <h5>TOTAL : <?= number_format($total[0]); ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footer.php" ?>