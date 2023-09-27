<?php
include "../db/koneksi.php";

function update_karyawan($data)
{
  global $conn;

  $id_user = $data["id_user"];
  $nama = $data["nama"];
  $jk = $data["jk"];
  $alamat = $data["alamat"];
  $no_hp = $data["no_hp"];
  $username = $data["username"];
  $password = $data["password"];


  mysqli_query($conn, "UPDATE karyawan SET nama_karyawan='$nama', jk='$jk', alamat='$alamat', no_hp='$no_hp' WHERE user_id='$id_user'");
  mysqli_query($conn, "UPDATE users SET username='$username', password='$password' WHERE id_user='$id_user'");
  echo "
        <script>
        Swal.fire({
            title: 'Berhasil',
            text: 'Data berhasil di update',
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

function update_customer($data)
{
  global $conn;

  $id_customer = $data["id_customer"];
  $nama = $data["nama"];
  $jk = $data["jk"];
  $alamat = $data["alamat"];
  $no_hp = $data["no_hp"];

  $role = $_SESSION["role"];
  if ($role == 1) {
    $url = "data_customer.php";
  } else {
    $url = "customer.php";
  }

  mysqli_query($conn, "UPDATE customer SET nama='$nama', jk='$jk', alamat='$alamat', no_hp='$no_hp' WHERE id_customer='$id_customer'");
  echo "
        <script>
        Swal.fire({
            title: 'Berhasil',
            text: 'Data berhasil di update',
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

function update_bbm($data)
{
  global $conn;

  $id_bbm = $data["id_bbm"];
  $nama_bbm = $data["nama_bbm"];
  $harga_perliter = $data["harga_perliter"];

  mysqli_query($conn, "UPDATE bbm SET nama_bbm='$nama_bbm', harga_perliter='$harga_perliter' WHERE id_bbm='$id_bbm'");

  echo "
  <script>
  Swal.fire({
      title: 'Berhasil',
      text: 'Data berhasil di update',
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

function update_tangki($data)
{
  global $conn;

  $id_tangki = $data["id_tangki"];
  $nama_tangki = $data["nama_tangki"];
  $id_bbm = $data["id_bbm"];
  $jumlah_liter = $data["jumlah_liter"];
  $kapasitas_liter = $data["kapasitas_liter"];

  mysqli_query($conn, "UPDATE tangki SET nama_tangki='$nama_tangki', id_bbm='$id_bbm', jumlah_liter='$jumlah_liter', kapasitas_liter='$kapasitas_liter' WHERE id_tangki='$id_tangki'");

  echo "
  <script>
  Swal.fire({
      title: 'Berhasil',
      text: 'Data berhasil di update',
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
