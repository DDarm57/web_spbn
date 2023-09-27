<?php include "../karyawan/layout/header.php"; ?>

<?php
include "../db/koneksi.php";
$user_id = $_SESSION["id_user"];

$tgl_sekarang = date("Y-m-d");

if (isset($_GET["cari"])) {
    $dari_tgl = $_GET["dari"];
    $sampai_tgl = $_GET["sampai"];
    if ($dari_tgl > $sampai_tgl) {
        echo "
    <script>
    Swal.fire({
        title: 'Gagal',
        text: 'Tgl pertama tidak boleh lebih besar dari tgl kedua',
        icon: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'transaksi.php'
        }
      });
    </script>
    ";
    }
} else {
    $dari_tgl = $tgl_sekarang;
    $sampai_tgl = $tgl_sekarang;
}

$karyawan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM karyawan WHERE user_id='$user_id'"));
// var_dump($karyawan);
$id_karyawan = $karyawan["id_karyawan"];
$query_customer = mysqli_query($conn, "SELECT * FROM customer");
$query_bbm = mysqli_query($conn, "SELECT * FROM bbm");
$query_pemasukan = mysqli_query($conn, "SELECT * FROM pemasukan
INNER JOIN bbm ON bbm.id_bbm = pemasukan.id_bbm
INNER JOIN karyawan ON karyawan.id_karyawan = pemasukan.id_karyawan
INNER JOIN customer ON customer.id_customer = pemasukan.id_customer
WHERE karyawan.id_karyawan = '$id_karyawan' AND tgl_pemasukan BETWEEN '$dari_tgl' AND '$sampai_tgl'
ORDER BY id_pemasukan DESC
");

$pendapatan = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(pendapatan) FROM pemasukan WHERE id_karyawan='$id_karyawan' AND tgl_pemasukan BETWEEN '$dari_tgl' AND '$sampai_tgl'"));

?>
<div class="container">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
        <a href="#" class="d-none d-sm-inline-block">Transaksi</a>
    </div>
    <div class="card mb-2 p-2">
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
                    <td><?= $karyawan["nama_karyawan"]; ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-cash-register"></i></td>
                    <td>:</td>
                    <?php
                    if ($pendapatan) {
                        $jumlah = $pendapatan[0];
                    } else {
                        $jumlah = 0;
                    }
                    ?>
                    <td>Rp. <?= number_format($jumlah); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-calendar-alt"></i></td>
                    <td>:</td>
                    <td><?= date("d/m/Y"); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
    $query_tangki = mysqli_query($conn, "SELECT * FROM tangki
    INNER JOIN bbm ON bbm.id_bbm = tangki.id_bbm
    ");
    ?>
    <div class="card">
        <div class="card-header">Transkasi Pembelian BBM</div>
        <div class="card-body">
            <div class="row">
                <?php while ($row = mysqli_fetch_array($query_tangki)) : ?>
                    <div class="col-lg-3">
                        <div class="card mb-2">
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <th>Nama Tangki</th>
                                        <td>:</td>
                                        <td><?= $row["nama_tangki"]; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jeni BBM</th>
                                        <td>:</td>
                                        <td><?= $row["nama_bbm"]; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Liter</th>
                                        <td>:</td>
                                        <td><?= $row["jumlah_liter"]; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <form action="bayar.php" method="post">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="id_customer">Customer</label>
                            <select name="id_customer" id="id_customer" class="selectpicker form-control" title="Customer" data-live-search="true" required>
                                <?php foreach ($query_customer as $row) : ?>
                                    <option value="<?= $row["id_customer"]; ?>"><?= $row["nama"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="id_customer">BBM (Bahan Bakar Minyak)</label>
                            <select name="id_bbm" id="id_bbm" class="selectpicker form-control" title="BBM" required>
                                <?php foreach ($query_bbm as $row) : ?>
                                    <optgroup label="<?= $row["nama_bbm"]; ?>">
                                        <option value="<?= $row["id_bbm"]; ?>"><?= $row["harga_perliter"]; ?></option>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="tgl_pemasukan">Tanggal</label>
                            <input type="date" name="tgl_pemasukan" id="tgl_pemasukan" class="form-control" value="<?= date("Y-m-d"); ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="liter_terjual">Liter Terjual</label>
                            <input type="text" name="liter_terjual" id="liter_terjual" class="form-control rp-input" readonly required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="total_pendapatan">Total Pendapatan (Membayar)</label>
                            <input type="text" name="total_pendapatan" id="total_pendapatan" class="form-control rp-input" readonly required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="status">Status Lunas</label>
                            <input type="text" name="status" id="status" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="card mt-2 mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <h5 id="hasil"></h5>
                            <div class="px-2">
                                <h5 id="kembalian"></h5>
                                <input type="hidden" name="hutang" id="hutang">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <h5>Total : </h5>
                            <div class="px-2">
                                <h5 id="total"></h5>
                                <input type="hidden" name="total" id="total-rupiah">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" name="bayar" class="btn btn-primary btn-sm mb-2">Simpan</button>
                </div>
            </form>
            <div class="mb-2">
                <div class="row">
                    <div class="col-sm-6">
                        <form action="">
                            <div class="input-group">
                                <input type="date" name="dari" id="" class="form-control form-control-sm" value="<?= $dari_tgl; ?>" required>
                                <input type="date" name="sampai" id="" class="form-control form-control-sm" value="<?= $sampai_tgl; ?>" required>
                                <div class="input-group-append">
                                    <a href="transaksi.php" class="btn btn-sm btn-primary"><i class="fas fa-sync"></i></a>
                                    <button type="submit" name="cari" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-stripped" id="example1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama BBM</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Liter Terjual</th>
                        <th>Total Rp</th>
                        <th>Pendapatan</th>
                        <th>Hutang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = mysqli_fetch_array($query_pemasukan)) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row["nama_bbm"]; ?></td>
                            <td><?= $row["nama"]; ?></td>
                            <td><?= $row["tgl_pemasukan"]; ?></td>
                            <td><?= number_format($row["liter_terjual"]); ?></td>
                            <td>Rp. <?= number_format($row["total"]); ?></td>
                            <td>Rp. <?= number_format($row["pendapatan"]); ?></td>
                            <td>Rp. <?= number_format($row["hutang"]); ?></td>
                            <td><?= $row["status"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../karyawan/layout/footer.php"; ?>