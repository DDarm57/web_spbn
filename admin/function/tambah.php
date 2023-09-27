<?php
include "../db/koneksi.php";
date_default_timezone_set("Asia/Jakarta");

function simpan_karyawan($data)
{
  global $conn;

  $nama = $data["nama"];
  $jk = $data["jk"];
  $alamat = $data["alamat"];
  $no_hp = $data["no_hp"];
  $username = $data["username"];
  $password = $data["password"];

  $cek_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM karyawan WHERE nama_karyawan='$nama'"));

  if ($cek_data) {
    echo "
        <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Gagal menambahkan data! Data sudah ada.',
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'data_karyawan.php'
            }
          });
        </script>
        ";
  } else {
    mysqli_query($conn, "INSERT INTO users (username,password,role) VALUES ('$username', '$password', '2')");
    $user_id = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO karyawan (user_id,nama_karyawan,jk,alamat,no_hp) VALUES ('$user_id', '$nama', '$jk', '$alamat', '$no_hp')");
    echo "
        <script>
        Swal.fire({
            title: 'Berhasil',
            text: 'Data berhasil ditambahkan',
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'data_karyawan.php'
            }
          });
        </script>
        ";
  }
}

function simpan_customer($data)
{
  global $conn;

  $nama = htmlspecialchars($data["nama"]);
  $jk = $data["jk"];
  $alamat = htmlspecialchars($data["alamat"]);
  $no_hp = $data["no_hp"];
  // $date_now = date("Y-m-d H:i:s");


  $cek_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM customer WHERE nama='$nama'"));

  //url
  $role = $_SESSION["role"];

  if ($role == 1) {
    $url = "data_customer.php";
  } else {
    $url = "customer.php";
  }

  if ($cek_data) {
    echo "
    <script>
    Swal.fire({
        title: 'Gagal',
        text: 'Gagal menambahkan data! Data sudah ada.',
        icon: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '" . $url . "'
        }
      });
    </script>
    ";
  } else {

    mysqli_query($conn, "INSERT INTO customer (nama,jk,alamat,no_hp) VALUES ('$nama','$jk','$alamat','$no_hp')");

    echo "
    <script>
    Swal.fire({
        title: 'Berhasil',
        text: 'Data berhasil ditambahkan',
        icon: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '" . $url . "'
        }
      });
    </script>
    ";
  }
}

function simpan_bbm($data)
{
  global $conn;

  $nama_bbm = $data["nama_bbm"];
  $harga_perliter = $data["harga_perliter"];

  $cek_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM bbm WHERE nama_bbm='$nama_bbm'"));

  if ($cek_data) {
    echo "
    <script>
    Swal.fire({
        title: 'Gagal',
        text: 'Gagal menambahkan data! Data sudah ada.',
        icon: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'data_bbm.php'
        }
      });
    </script>
    ";
  } else {
    mysqli_query($conn, "INSERT INTO bbm (nama_bbm,harga_perliter) VALUES ('$nama_bbm','$harga_perliter')");

    echo "
    <script>
    Swal.fire({
        title: 'Berhasil',
        text: 'Data berhasil ditambahkan',
        icon: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'data_bbm.php'
        }
      });
    </script>
    ";
  }
}

function simpan_tangki($data)
{
  global $conn;

  $nama_tangki = $data["nama_tangki"];
  $id_bbm = $data["id_bbm"];
  $jumlah_liter = $data["jumlah_liter"];

  $cek_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tangki WHERE nama_tangki='$nama_tangki'"));

  if ($cek_data) {
    echo "
    <script>
    Swal.fire({
        title: 'Gagal',
        text: 'Gagal menambahkan data! Data sudah ada.',
        icon: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'tangki_bbm.php'
        }
      });
    </script>
    ";
  } else {
    mysqli_query($conn, "INSERT INTO tangki (nama_tangki,id_bbm,jumlah_liter) VALUES ('$nama_tangki','$id_bbm','$jumlah_liter')");

    echo "
    <script>
    Swal.fire({
        title: 'Berhasil',
        text: 'Data berhasil ditambahkan',
        icon: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'tangki_bbm.php'
        }
      });
    </script>
    ";
  }
}

function simpan_penerimaan($data)
{
  global $conn;
  $tgl_sekarang = date("Y-m-d");
  $id_bbm = $data["id_bbm"];
  $isi_liter = str_replace(",", "", $data["isi_liter"]);
  $tgl_penerimaan = $data["tgl_penerimaan"];
  $rp_perliter = str_replace(",", "", $data["rp_perliter"]);
  // $total_rupiah = str_replace(",", "", $data["total_rp"]);

  $total_rp = $rp_perliter * $isi_liter;

  $get_bbm = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM bbm WHERE id_bbm='$id_bbm'"));

  if ($rp_perliter >= $get_bbm["harga_perliter"]) {
    echo "
    <script>
    Swal.fire({
        title: 'Gagal',
        text: 'Harga rp perliter lebih besar dari harga jual bbm. Silahkan update harga penjualan bbm',
        icon: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'penerimaan.php'
        }
      });
    </script>
    ";
  } else {
    //cek saldo
    $jml_saldo = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM wallet"));

    if ($jml_saldo == NULL) {
      $saldo = 0;
    } else {
      $saldo = $jml_saldo["saldo"];
    }

    if ($saldo < $total_rp) {
      echo "
    <script>
    Swal.fire({
        title: 'Gagal',
        text: 'Saldo tidak cukup. Silahkan deposit terlebih dahulu dibagian wallet',
        icon: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'penerimaan.php'
        }
      });
    </script>
    ";
    } else {
      $get_tangki = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tangki WHERE id_bbm='$id_bbm'"));

      if ($get_tangki["kapasitas_liter"] < $isi_liter) {
        echo "
        <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Kapasitas liter tangki tidak mencukupi dari total penerimaan liter bbm. Kurangi total liter penerimaan',
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'penerimaan.php'
            }
          });
        </script>
        ";
      } else {
        //kurangi saldo wallet
        $id_wallet = $jml_saldo["id_wallet"];
        $kurangi_saldo = $saldo - $total_rp;

        // var_dump($id_wallet, $kurangi_saldo);
        // exit;

        mysqli_query($conn, "UPDATE wallet SET saldo='$kurangi_saldo' WHERE id_wallet='$id_wallet'");

        //tambah mutasi saldo
        mysqli_query($conn, "INSERT INTO deposit (info,total_deposit,tanggal) VALUES ('Penerimaan BBM', '$total_rp', '$tgl_sekarang')");

        mysqli_query($conn, "INSERT INTO penerimaan (id_bbm,isi_liter,tgl_penerimaan,rp_perliter,total_rp) VALUES ('$id_bbm','$isi_liter','$tgl_penerimaan','$rp_perliter','$total_rp')");

        $jumlah_liter = $get_tangki["jumlah_liter"] + $isi_liter;
        mysqli_query($conn, "UPDATE tangki SET jumlah_liter='$jumlah_liter' WHERE id_bbm='$id_bbm'");

        echo "
        <script>
        Swal.fire({
            title: 'Berhasil',
            text: 'Data berhasil ditambahkan',
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'penerimaan.php'
            }
          });
        </script>
        ";
      }
    }
  }

  // $kurangi_pendapatan = $cek_data["total_pendapatan"] - $total_rp;

  // mysqli_query($conn, "UPDATE total_pemasukan SET total_pendapatan='$kurangi_pendapatan' WHERE bulan='$bulan'");

}

function simpan_pengeluaran($data)
{
  global $conn;
  $tgl_sekarang = date("Y-m-d");
  $tipe_pengeluaran = $data["tipe_pengeluaran"];
  $deskripsi = $data["deskripsi"];
  $tgl_pengeluaran = $data["tgl_pengeluaran"];
  $total_biaya = str_replace(",", "", $data["total_biaya"]);

  $jml_saldo = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM wallet"));

  if ($jml_saldo == NULL) {
    $saldo = 0;
  } else {
    $saldo = $jml_saldo["saldo"];
  }


  if ($saldo < $total_biaya) {
    echo "
    <script>
    Swal.fire({
        title: 'Gagal',
        text: 'Saldo tidak cukup. Silahkan deposit terlebih dahulu dibagian wallet',
        icon: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'pengeluaran.php'
        }
      });
    </script>
  ";
  } else {
    //kurangi saldo wallet
    $id_wallet = $jml_saldo["id_wallet"];
    $kurangi_saldo = $saldo - $total_biaya;
    //tambah mutasi saldo
    mysqli_query($conn, "INSERT INTO deposit (info,total_deposit,tanggal) VALUES ('$tipe_pengeluaran', '$total_biaya', '$tgl_sekarang')");

    mysqli_query($conn, "UPDATE wallet SET saldo='$kurangi_saldo' WHERE id_wallet='$id_wallet'");

    mysqli_query($conn, "INSERT INTO pengeluaran (tipe_pengeluaran,deskripsi,tgl_pengeluaran,total_biaya) 
    VALUE ('$tipe_pengeluaran','$deskripsi','$tgl_pengeluaran', $total_biaya)");

    echo "
  <script>
  alert ('Biaya pengeluaran berhasil di tambahkan');
  window.location.href = 'pengeluaran.php';
  </script>
  ";
  }
}

function simpan_deposit($data)
{
  global $conn;

  $total_deposit = str_replace(",", "", $data["total_deposit"]);
  $tanggal = $data["tanggal"];

  $cek_data = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM deposit WHERE tanggal='$tanggal'"));

  // var_dump($cek_data);
  // exit;
  if ($cek_data >= 7) {
    echo "
    <script>
    alert ('Deposit gagal dilakukan. Maksimal deposit 7 kali dalam satu hari');
    window.location.href = 'wallet.php';
    </script>
    ";
  } else {

    mysqli_query($conn, "INSERT INTO deposit (info,total_deposit,tanggal) VALUES ('deposit','$total_deposit','$tanggal')");
    //update ke wallet
    $get_wallet = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM wallet"));

    if ($get_wallet != NULL) {
      $id_walet = $get_wallet["id_wallet"];
      $total_saldo = $get_wallet["saldo"] + $total_deposit;
      mysqli_query($conn, "UPDATE wallet SET saldo='$total_saldo' WHERE id_wallet='$id_walet'");
    } else {
      mysqli_query($conn, "INSERT INTO wallet (saldo) VALUES ('$total_deposit')");
    }
    echo "
  <script>
  alert ('Deposit berhasil dilakukan');
  window.location.href = 'wallet.php';
  </script>
  ";
  }
}
