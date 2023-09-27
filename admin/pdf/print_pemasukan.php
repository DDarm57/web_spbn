<?php
require_once '../../vendor/autoload.php'; // Sesuaikan dengan path ke autoload.inc.php

use Dompdf\Dompdf;
// use Dompdf\Options;

// Create an instance of Dompdf
$dompdf = new Dompdf;

if (isset($_POST["bulan"])) {
    $bulan = $_POST["bulan"];
} else {
    $bulan = $_GET["bulan"];
}
include "../../db/koneksi.php";
$query_bbm = mysqli_query($conn, "SELECT * FROM pemasukan 
INNER JOIN bbm ON bbm.id_bbm = pemasukan.id_bbm
INNER JOIN karyawan ON karyawan.id_karyawan = pemasukan.id_karyawan
INNER JOIN customer ON customer.id_customer = pemasukan.id_customer
WHERE tgl_pemasukan LIKE '$bulan%'
ORDER BY id_pemasukan DESC
");

$html = "
    <h6>
    SPBN Branta Pamekasan <br>
    Pemasukan Bulan = " . $bulan . "</h6>";
$html .= '
    <table width="100%" style="border-collapse: collapse; font-size: 14px;">
        <thead>
            <tr>
                <th style="border: 1px solid black; background-color: #A9E6FF;">No</th>
                <th style="border: 1px solid black; background-color: #A9E6FF;;">Nama BBM</th>
                <th style="border: 1px solid black; background-color: #A9E6FF;;">Karyawan</th>
                <th style="border: 1px solid black; background-color: #A9E6FF;;">Customer</th>
                <th style="border: 1px solid black; background-color: #A9E6FF;;">Tanggal</th>
                <th style="border: 1px solid black; background-color: #A9E6FF;;">Liter Terjual</th>
                <th style="border: 1px solid black; background-color: #A9E6FF;;">Hutang</th>
                <th style="border: 1px solid black; background-color: #A9E6FF;;">Status</th>
                <th style="border: 1px solid black; background-color: #A9E6FF;;">Pendapatan</th>
            </tr>
        </thead>
        <tbody>';

$no = 1;
while ($row = mysqli_fetch_array($query_bbm)) {
    $html .= '
        <tr>
            <td style="border: 1px solid black;">' . $no++ . '</td>
            <td style="border: 1px solid black;">' . $row["nama_bbm"] . '</td>
            <td style="border: 1px solid black;">' . $row["nama_karyawan"] . '</td>
            <td style="border: 1px solid black;">' . $row["nama"] . '</td>
            <td style="border: 1px solid black;">' . $row["tgl_pemasukan"] . '</td>
            <td style="border: 1px solid black;">' . $row["liter_terjual"] . '</td>
            <td style="border: 1px solid black;">Rp. ' . number_format($row["hutang"]) . '</td>
            <td style="border: 1px solid black;">
                <strong>' . $row["status"] . '</strong>
            </td style="border: 1px solid black;">
            <td style="border: 1px solid black;">Rp. ' . number_format($row["pendapatan"]) . '</td>
        </tr>';
}
$html .= '</tbody>
    </table>
    ';
if (isset($_POST["status"]) == "view") {
    sleep(1);
    echo json_encode($html);
} else {
    $dompdf->loadHtml($html);
    // (Optional) Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');
    //Render the HTML as PDF
    $dompdf->render();
    // Output the generated PDF to the browser
    $dompdf->stream('test.pdf', ['Attachment' => false]);
    // echo $element;
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
