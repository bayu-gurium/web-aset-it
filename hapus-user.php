<?php

session_start();
require './modul/fuctions.php';

// get id 
$id_user = $_GET['id'];
$id_admin = $_SESSION['id_user'];

if ($id_user == $id_admin) {
    header('location: user.php');
    exit;
}


if (hapusUser($id_user) > 0) {

    header('location: user.php ');
}
