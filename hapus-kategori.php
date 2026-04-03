<?php

// konek dengan database
require './modul/fuctions.php';

// get id 
$id_kategori = $_GET['id'];

if (hapusKategori($id_kategori) > 0) {

    header('location: kategori_lokasi.php ');
}
