<?php
  require_once "connect.php";

  $getFunction = $_GET['method'];

  if ( function_exists($getFunction) ) {
    $getFunction();
  } else {
    header("Content-Type: application/json", true, 200);

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
                `$nama`, `$email`, `$password`, `$umur`, 1, NOW(), NOW()
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