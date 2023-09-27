<?php
session_start();
include "db/koneksi.php";

$ussername = $_POST["username"];
$password = $_POST["password"];

$cek_login = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE username='$ussername' AND password='$password'"));


if ($cek_login) {
    $_SESSION["log"] = true;
    $_SESSION["id_user"] = $cek_login["id_user"];
    $_SESSION["role"] = $cek_login["role"];

    if ($cek_login["role"] == 1) {
        echo "
        <script>
        alert ('login berhasil sebagai admin');
        window.location.href = 'admin/dashboard.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert ('login berhasil sebagai karyawan');
        window.location.href = 'karyawan/transaksi.php';
        </script>
        ";
    }
} else {
    echo "
        <script>
        alert ('login gagal username atau password salah');
        window.location.href = 'index.php';
        </script>
    ";
}
