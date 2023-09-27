<?php
include "../db/koneksi.php";

$query_bbm = mysqli_query($conn, "SELECT * FROM bbm");

$data_bbm = array();
$no = 1;
while ($row = mysqli_fetch_array($query_bbm)) {
    $id_bbm = $row["id_bbm"];
    $liter_terjual = mysqli_fetch_row(mysqli_query($conn, "SELECT sum(liter_terjual) FROM pemasukan WHERE id_bbm='$id_bbm'"));
    $bbm = [
        "nama_bbm" => $row["nama_bbm"],
        "liter_terjual" => $liter_terjual[0],
        "bg" => "#" . $no++ . "e73df"
    ];
    $data_bbm[] = $bbm;
}

header('Content-Type: application/json');
echo json_encode($data_bbm);
