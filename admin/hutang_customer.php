<?php include "../layout/header.php" ?>
<?php
include "../db/koneksi.php";
$query_cust = mysqli_query($conn, "SELECT * FROM customer");
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hutang Customer</h1>
        <p class="d-none d-sm-inline-block"><a href="dashboard.php" class="">Dashboard</a> / Hutang Customer</p>
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
                            <th>Customer</th>
                            <th>Hutang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($row = mysqli_fetch_array($query_cust)) :
                            $id_customer = $row["id_customer"];

                            $get_hutang = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(hutang)
                            FROM pemasukan 
                            WHERE id_customer='$id_customer'"));

                            $jml_hutang = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pemasukan WHERE id_customer='$id_customer' AND status='belum lunas'"));
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row["nama"]; ?></td>
                                <td>Rp. <?= number_format($get_hutang[0]); ?><br>
                                    <?php if ($get_hutang[0] > 0) : ?>
                                        <p class="bg-danger p-1 rounded text-light" style="width: 130px;"><strong>Dari <?= $jml_hutang; ?> transaksi</strong></p>
                                    <?php else : ?>
                                        <p class="bg-success p-1 rounded text-light" style="width: 200px;"><strong>Tidak ada catatan hutang</strong></p>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="detail_hutang.php?id_customer=<?= $row["id_customer"]; ?>" class="btn btn-sm btn-info">Detail</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php $total = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(hutang) FROM pemasukan ")) ?>
                <div class="text-right mt-2">
                    <h5>TOTAL : <?= number_format($total[0]); ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footer.php" ?>