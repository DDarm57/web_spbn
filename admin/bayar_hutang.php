<?php

include '../db/koneksi.php';

$id_customer = $_POST["id_customer"];
$id_pemasukan = $_POST["id_pemasukan"];
$hutang = str_replace(",", "", $_POST["hutang"]);
$bayar = str_replace(",", "", $_POST["bayar"]);
$kurang = $_POST["kurang"];

$get_hutang = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM pemasukan WHERE id_pemasukan='$id_pemasukan'"));

$bulan_hutang = date("Y-m", strtotime($get_hutang["tgl_pemasukan"]));
$get_totalPemasukan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM total_pemasukan WHERE bulan='$bulan_hutang'"));

$total_pendapatan = $get_totalPemasukan["total_pendapatan"];
$total_hutang = $get_totalPemasukan["total_hutang"];

if ($kurang == 0) {
    $pendapatan = $get_hutang["total"];
    $status = "lunas";
    $hutang = 0;
    //lunaskan hutang di total pemasukan
    $update_totalPendapatan = $total_pendapatan + $get_hutang["hutang"];
    $update_totalHutang = $total_hutang - $get_hutang["hutang"];
} else {
    $pendapatan = $get_hutang["pendapatan"] + $bayar;
    $hutang = $hutang - $bayar;
    $status = "belum lunas";
    //update ke total pemasukan
    $update_totalPendapatan = $total_pendapatan + $bayar;
    $update_totalHutang = $total_hutang - $bayar;
}

// var_dump($update_totalPendapatan, $update_totalHutang);
// exit;

mysqli_query($conn, "UPDATE total_pemasukan SET total_pendapatan='$update_totalPendapatan', total_hutang='$update_totalHutang' WHERE bulan='$bulan_hutang'");
mysqli_query($conn, "UPDATE pemasukan SET pendapatan='$pendapatan', hutang='$hutang', status='$status' WHERE id_pemasukan='$id_pemasukan'");

// var_dump(mysqli_error($conn));

if (mysqli_affected_rows($conn) > 0) {
    echo "
<script>
alert('Data Behrasil Di Tambahkan');
window.location.href = 'detail_hutang.php?id_customer=" . $id_customer . "';
</script>
";
} else {
    echo "
<script>
alert('Data Gagal Di Tambahkan');
window.location.href = 'detail_hutang.php?id_customer=" . $id_customer . "';
</script>
";
}
