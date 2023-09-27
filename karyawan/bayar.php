<?php
session_start();
include "../db/koneksi.php";
$user_id = $_SESSION["id_user"];

$karyawan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM karyawan WHERE user_id='$user_id'"));

$id_bbm = $_POST["id_bbm"];
$id_karyawan = $karyawan["id_karyawan"];
$id_customer = $_POST["id_customer"];
$tgl_pemasukan = $_POST["tgl_pemasukan"];
$liter_terjual = str_replace(",", "", $_POST["liter_terjual"]);
$total = $_POST["total"];
$pendapatan = str_replace(",", "",  $_POST["total_pendapatan"]);
$hutang = $_POST["hutang"];
$status = $_POST["status"];

$jml_hutang = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pemasukan WHERE id_customer='$id_customer' AND status='belum lunas'"));

if ($jml_hutang >= 1) {
    echo "
    <script>
    alert('Customer mempunyai yang belum di lunasi. Gagal memproses transaksi');
    window.location.href = 'transaksi.php';
    </script>
    ";
} else {

    $get_tangkiBbm = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tangki WHERE id_bbm='$id_bbm'"));

    $liter_tangki = $get_tangkiBbm["jumlah_liter"];

    $cek_ltrTangki = $liter_tangki - $liter_terjual;

    if ($cek_ltrTangki < 0) {
        echo "
        <script>
        alert('Liter tangki tidak cukup dengan transaksi yang dilakukan');
        window.location.href = 'transaksi.php';
        </script>
        ";
    } else {
        $ltr_tangki = $get_tangkiBbm["jumlah_liter"];
        $kurangi_ltrTangki = $ltr_tangki - $liter_terjual;

        if ($status == "lunas") {
            $pendapatan = $total;
        }

        mysqli_query($conn, "UPDATE tangki SET jumlah_liter='$kurangi_ltrTangki' WHERE id_bbm='$id_bbm'");

        mysqli_query($conn, "INSERT INTO pemasukan (id_bbm,id_karyawan,id_customer,tgl_pemasukan,liter_terjual,total,pendapatan,hutang,status) 
        VALUES ('$id_bbm', '$id_karyawan', '$id_customer', '$tgl_pemasukan', '$liter_terjual','$total','$pendapatan', '$hutang', '$status')");

        $bulan = date("Y-m", strtotime($tgl_pemasukan));

        $get_totalPemasukan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM total_pemasukan ORDER BY id_totalPemasukan DESC"));
        if ($get_totalPemasukan) {
            if ($bulan != $get_totalPemasukan["bulan"]) {
                mysqli_query($conn, "INSERT INTO total_pemasukan (total_pendapatan,total_hutang,bulan) VALUES ('$pendapatan', '$hutang', '$bulan')");
                var_dump(mysqli_error($conn));
            } else {

                $total_pemasukan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM total_pemasukan ORDER BY id_totalPemasukan DESC"));

                $t_pendapatan = $total_pemasukan["total_pendapatan"] + $pendapatan;
                $t_hutang = $total_pemasukan["total_hutang"] + $hutang;

                mysqli_query($conn, "UPDATE total_pemasukan SET total_pendapatan='$t_pendapatan', total_hutang='$t_hutang' WHERE bulan='$bulan'");
            }
        } else {
            mysqli_query($conn, "INSERT INTO total_pemasukan (total_pendapatan,total_hutang,bulan) VALUES ('$pendapatan', '$hutang', '$bulan')");
        }

        if (mysqli_affected_rows($conn) > 0) {
            echo "
        <script>
        alert('Data Behrasil Di Tambahkan');
        window.location.href = 'transaksi.php';
        </script>
        ";
        } else {
            echo "
        <script>
        alert('Data Gagal Di Tambahkan');
        window.location.href = 'transaksi.php';
        </script>
        ";
        }
    }
}
