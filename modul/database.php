<?php

// Database Connection required
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "aset_it";

// connection
$db_connect = mysqli_connect($host, $user, $pass, $db_name);

if (!$db_connect) {

    die("Koneksi Databse GAGAL !! " . mysqli_connect_error());
}
