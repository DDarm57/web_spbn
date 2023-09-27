<?php
include "../db/koneksi.php";

$query_bbm = mysqli_query($conn, "SELECT * FROM bbm");

$data_bbm = array();
while ($row = mysqli_fetch_array($query_bbm)) {
    $id_bbm = $row["id_bbm"];
    $total_pendapatan = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(pendapatan) FROM pemasukan WHERE id_bbm='$id_bbm'"));
    $bbm = [
        "nama_bbm" => $row["nama_bbm"],
        "pendapatan" => $total_pendapatan
    ];
    $data_bbm[] = $bbm;
}

header('Content-Type: application/json');
echo json_encode($data_bbm);
