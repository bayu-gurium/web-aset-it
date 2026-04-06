<?php

require './modul/fuctions.php';

// get id 
$id_aset = $_GET['id'];

if (hapusAset($id_aset) > 0) {

    header('location: pendataan.php ');
}
