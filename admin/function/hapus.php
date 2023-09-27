<?php
include "../db/koneksi.php";

function hapus_karyawan($data)
{
  global $conn;

  $user_id = $data["user_id"];

  $cek_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM karyawan WHERE user_id='$user_id'"));

  if (!$cek_data) {
    echo "
        <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Gagal menghapus data! Data tidak ditemukan.',
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
    $karyawan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM karyawan WHERE user_id='$user_id'"));
    $id_karyawan = $karyawan["id_karyawan"];
    $cek_transaksi = mysqli_fetch_array(mysqli_query($conn, "SELECT id_customer FROM pemasukan WHERE id_karyawan='$id_karyawan'"));
    if ($cek_transaksi) {
      echo "
      <script>
      Swal.fire({
          title: 'Gagal',
          text: 'Gagal menghapus data! Karyawan sudah tercatat di dalam histori transaksi',
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
      mysqli_query($conn, "DELETE FROM karyawan WHERE user_id='$user_id'");
      mysqli_query($conn, "DELETE FROM users WHERE id_user='$user_id'");
      echo "
          <script>
          Swal.fire({
              title: 'Berhasil',
              text: 'Data berhasil dihapus',
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
}

function hapus_customer($data)
{
  global $conn;

  //url
  $role = $_SESSION["role"];

  if ($role == 1) {
    $url = "data_customer.php";
  } else {
    $url = "customer.php";
  }

  $id_customer = $data["id_customer"];

  $cek_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM customer WHERE id_customer='$id_customer'"));

  if (!$cek_data) {
    echo "
        <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Gagal menghapus data! Data tidak ditemukan.',
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
    $cek_transaksi = mysqli_fetch_array(mysqli_query($conn, "SELECT id_customer FROM pemasukan WHERE id_customer='$id_customer'"));
    if ($cek_transaksi) {
      echo "
      <script>
      Swal.fire({
          title: 'Gagal',
          text: 'Gagal menghapus data! Customer sudah tercatat di dalam histori transaksi',
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
      mysqli_query($conn, "DELETE FROM customer WHERE id_customer='$id_customer'");
      echo "
          <script>
          Swal.fire({
              title: 'Berhasil',
              text: 'Data berhasil dihapus',
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
}

function hapus_bbm($data)
{
  global $conn;

  $id_bbm = $data["id_bbm"];

  $cek_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM bbm WHERE id_bbm='$id_bbm'"));

  if (!$cek_data) {
    echo "
        <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Gagal menghapus data! Data tidak ditemukan.',
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
    $cek_bbm = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM pemasukan WHERE id_bbm='$id_bbm'"));
    if ($cek_bbm) {
      echo "
        <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Data gagal di hapus',
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
      mysqli_query($conn, "DELETE FROM bbm WHERE id_bbm='$id_bbm'");
      echo "
          <script>
          Swal.fire({
              title: 'Berhasil',
              text: 'Data berhasil dihapus',
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
}

function hapus_tangki($data)
{
  global $conn;

  $id_tangki = $data["id_tangki"];

  $cek_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tangki WHERE id_tangki='$id_tangki'"));

  if (!$cek_data) {
    echo "
        <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Gagal menghapus data! Data tidak ditemukan.',
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
    $id_bbm = $cek_data["id_bbm"];
    $cek_bbm = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM bbm WHERE id_bbm='$id_bbm'"));
    if ($cek_bbm) {
      echo "
      <script>
      Swal.fire({
          title: 'Gagal',
          text: 'Gagal menghapus data!',
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
      mysqli_query($conn, "DELETE FROM tangki WHERE id_tangki='$id_tangki'");
      echo "
          <script>
          Swal.fire({
              title: 'Berhasil',
              text: 'Data berhasil dihapus',
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
}
