<?php
  require_once "connect.php";

  $getFunction = $_GET['method'];
  $getId = null;

  if(isset($_GET['id'])) {
    $getId = $_GET['id'];
  }

  if ( function_exists($getFunction) ) {
    if(is_null($getId)) {
      $getFunction();
    }else{
      $getFunction($getId);
    }
  } else {
    header("Content-Type: application/json", true, 400);

    $data = array(
      'status' => 400,
      'alasan' => "Pastikan Method API dipanggil secara benar."
    );

    echo json_encode($data);
  }

  function get_artikel() {
    global $connect;

    $sql = "SELECT artikel.id, artikel.judul, artikel.isi,
            artikel.created_at, artikel.updated_at, user.nama, user.email
            FROM `artikel` JOIN `user`
            ON artikel.user_id = user.id";
    $query = mysqli_query($connect, $sql);

    while( $data = mysqli_fetch_assoc($query) ) {
      $body["data"][] = $data;
    }

    $body["status"] = array('status' => 200, 'alasan' => "Sukses");
    header("Content-Type: application/json", true, 200);
    echo json_encode($body);
  }

  function detail_artikel($id) {
    global $connect;

    $sql = "SELECT artikel.id, artikel.judul, artikel.isi,
            artikel.created_at, artikel.updated_at, user.nama, user.email
            FROM `artikel` JOIN `user`
            ON artikel.user_id = user.id WHERE artikel.id = " . $id;
    $query = mysqli_query($connect, $sql);

    while( $data = mysqli_fetch_assoc($query) ) {
      $body["data"] = $data;
    }

    $body["status"] = array('status' => 200, 'alasan' => "Sukses");
    header("Content-Type: application/json", true, 200);
    echo json_encode($body);
  }

  function tambah_konsultasi() {
    global $connect;

    $pesan = $_POST['pesan'];
    $pengguna_id = $_POST['pengguna_id'];
    $dokter_id = $_POST['dokter_id'];

    $sql = "INSERT INTO konsultasi (pesan, pengguna_id, dokter_id,
            created_at, updated_at)
              VALUES (
                '$pesan', '$pengguna_id', '$dokter_id', NOW(), NOW()
              )";
    $query = mysqli_query($connect, $sql);

    if ( $query ) {
      $response = array(
        'status' => 200,
        'alasan' => 'Tambah Konsultasi Sukses...',
      );
    } else {
      $response = array(
        'status' => 400,
        'alasan' => 'Format pemasukan data salah',
      );
    }

    header("Content-Type: application/json", true, 200);
    echo json_encode($response);
  }

  function hapus_konsultasi($id) {
    global $connect;

    $sql = "DELETE FROM konsultasi WHERE id = $id";
    $query = mysqli_query($connect, $sql);

    if ( $query ) {
      $response = array(
        'status' => 200,
        'alasan' => 'Hapus Konsultasi Sukses...',
      );
    } else {
      $response = array(
        'status' => 400,
        'alasan' => 'Format pemasukan data salah',
      );
    }

    header("Content-Type: application/json", true, 200);
    echo json_encode($response);
  }

  function login() {
    global $connect;

    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `user` WHERE email = '$email' AND password = '$password'";
    $query = mysqli_query($connect, $sql);

    $check = mysqli_num_rows($query);
    if($check == 1) {
      $body["data"] = mysqli_fetch_assoc($query);
      $body["status"] = array('status' => 200, 'alasan' => "Sukses");
    }else{
      $body["data"] = [];
      $body["status"] = array('status' => 404, 'alasan' => "Email atau password salah");
    }

    header("Content-Type: application/json", true, 200);
    echo json_encode($body);
  }

  function profil($id) {
    global $connect;

    $sql = "SELECT * FROM `user` WHERE id = $id";
    $query = mysqli_query($connect, $sql);

    while( $data = mysqli_fetch_assoc($query) ) {
      $body["data"] = $data;
    }

    $body["status"] = array('status' => 200, 'alasan' => "Sukses");
    header("Content-Type: application/json", true, 200);
    echo json_encode($body);
  }

  function register() {
    global $connect;

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $umur = $_POST['umur'];

    $sql = "INSERT INTO user (nama, email, password, umur, role_id,
            created_at, updated_at)
              VALUES (
                '$nama', '$email', '$password', '$umur', 1, NOW(), NOW()
              )";
    $query = mysqli_query($connect, $sql);

    if ( $query ) {
      $response = array(
        'status' => 200,
        'alasan' => 'Daftar Sukses...',
      );
    } else {
      $response = array(
        'status' => 400,
        'alasan' => 'Format pemasukan data salah',
      );
    }

    header("Content-Type: application/json", true, 200);
    echo json_encode($response);
  }
?>