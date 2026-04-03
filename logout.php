<?php

// jalankan sessuion
session_start();
// koneksi ke database
require './modul/database.php';

// bersihkan session 
session_destroy();

// link ke halaman login
header("location: index.php");
