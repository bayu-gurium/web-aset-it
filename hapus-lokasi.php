<?php

// konek dengan database
require './modul/fuctions.php';

// get id 
$id_lokasi = $_GET['id'];

if (hapusLokasi($id_lokasi) > 0) {

    header('location: kategori_lokasi.php ');
}
