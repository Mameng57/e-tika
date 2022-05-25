<?php
  require_once "connect.php";

  $getFunction = $_GET['method'];
  $postFunction = $_POST['method'];

  if ( function_exists($getFunction) ) {
    $getFunction();
  }
  else {
    $postFunction();
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
?>