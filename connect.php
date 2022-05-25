<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $database = "etika";

  $connect = mysqli_connect($hostname, $username, $password, $database);

  if (!$connect) {
    die(mysqli_connect_error());
  }
?>