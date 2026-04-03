<?php
session_start();
require './modul/fuctions.php';
// cek session
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Tendang balik ke login
    header("Location: index.php");
    exit;
}

// logic simpan data lokasi
if (isset($_POST['simpan-lokasi'])) {

    if (tambahLokasi($_POST) > 0) {
        $sukses = true;
    } else {
        $error = true;
    }
}
// logic ubah/update data lokasi
if (isset($_POST['ubah_lokasi'])) {
    if (ubahLokasi($_POST) > 0) {
        $sukses = true;
    } else {
        $error =  true;
    }
}
// -----------------------------------------

// Logic simpan data kategori
if (isset($_POST['simpan-kategori'])) {
    if (tambahKategori($_POST) > 0) {

        $suksess = true;
    } else {
        echo  mysqli_error($db_connect);
    }
}
// login ubah/update data kategori
if (isset($_POST['ubah_kategori'])) {
    if (ubahKategori($_POST) > 0) {
        $sukses = true;
    } else {
        $error =  true;
    }
}
// -----------------------------------------

// Tampilkan semua data lokasi
$data_lokasi = allData("SELECT * FROM lokasi ORDER BY id_lokasi DESC");
// Tampilkan semua data kategori
$data_kategori = allData("SELECT * FROM kategori ORDER BY id_kategori DESC");


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lokasi & Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- icon link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- link css -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container px-5 fixed-top">
        <!-- navbar -->
        <nav class="navbar navbar-styles navbar-dark navbar-expand-lg  mt-5 rounded-3 p-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="dashboard.php"><i class="bi bi-activity logo-styles"></i></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link mx-0 mx-lg-5" aria-current="page" href="dashboard.php">
                            <i class="bi bi-speedometer2 mx-2 icon-styles"></i>DASHBOARD</a>
                        <a class="nav-link mx-0 mx-lg" href="pendataan.php"><i class="bi bi-database-fill-add icon-styles"></i> PENDATAAN & KELOLA ASET</a>

                        <!-- Tools Dropdown -->
                        <div class="dropdown mx-lg-4 fw-semibold">
                            <a href="#" class="nav-link active dropdown-toggle d-flex align-items-center" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-earmark-bar-graph icon-styles mx-lg-1 me-1"></i>
                                LOKASI & KATEGORI
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-3" aria-labelledby="userMenu">
                                <li>
                                    <h6 class="dropdown-header">Kelola Data Aset</h6>
                                </li>
                                <li><a class="dropdown-item" href="laporan.php"> <i class="bi bi-file-earmark-bar-graph"></i> LAPORAN</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="kategori_lokasi.php"><i class="bi bi-funnel"></i> LOKASI & KATEGORI</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            </ul>
                        </div>
                        <!-- Tools Dropdown end -->

                        <!-- account dropdown -->
                        <div class="dropdown mx-lg-4">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle  icon-styles"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-3" aria-labelledby="userMenu">
                                <li>
                                    <h6 class="dropdown-header">Admin Profile</h6>
                                </li>
                                <li><a class="dropdown-item" href="kategori_lokasi.php"><i class="bi bi-person me-2"></i> Kategori & Lokasi</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-shield-lock me-2"></i> Ganti Password</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            </ul>
                        </div>
                        <!-- account dropdown end -->


                        <a class="mx-0 mx-lg-5 log-styles" href="logout.php">
                            <i class="bi bi-box-arrow-right log-styles"></i> LOGOUT</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- navbar end -->
    </div>

    <!-- main content -->
    <div class="container px-5 main-content">
        <div class="row justify-content-center mt-4 mb-2">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-6 col-lg-6 font-pagination">
                        <small class="m-0">Page</small>
                        <h5>Lokasi dan Kategori Aset</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-5 mt-2">
        <div class="row justify-content-center ">
            <!-- col 1 -->
            <div class="col-lg-4 border-end border-1 py-2">
                <div class="card border-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-10">
                                <h6 class="pt-2">Data Lokasi Aset</h6>
                            </div>
                            <div class="col-2">
                                <a href="" data-bs-toggle="modal" data-bs-target="#tambahLokasi"> <i class="bi bi-plus-circle-fill fs-4 text-success"></i></a>
                            </div>
                            <!-- Modal Tambah Lokasi -->
                            <div class="modal fade" id="tambahLokasi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tambahLokasiLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-light px-4" style="background-color: #3a4ccb;">
                                            <h1 class="modal-title fs-4" id="tambahLokasiLabel">Tambah Lokasi Aset</h1>
                                            <button type="button" class="btn ms-auto border-0 text-light fs-5" data-bs-dismiss="modal" aria-label=""><i class="bi bi-x-lg fw-bold px-2 py-1"></i></button>
                                        </div>
                                        <div class="modal-body px-4">
                                            <form action="" method="post">
                                                <div class="mb-3">
                                                    <label for="">Nama Lokasi</label>
                                                    <input type="text" name="nama_lokasi" required class="form-control my-2" placeholder="Nama Lokasi Aset" autofocus>
                                                </div>
                                                <div class="mt-4 text-end">
                                                    <button type="submit" name="simpan-lokasi" class="btn btn-sm btn-success"><i class="bi bi-floppy"></i> Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end  modal tambah lokasi -->
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                        $no_data = 1;
                        foreach ($data_lokasi as $lokasi) : ?>
                            <li class="list-group-item border-bottom fw-light py-0">
                                <div class="row mt-2">
                                    <div class="col-1">
                                        <p class=""><?= $no_data++ ?></p>
                                    </div>
                                    <div class="col-8">
                                        <p class=""><?= $lokasi['nama_lokasi'] ?></p>
                                    </div>
                                    <div class="col-2">
                                        <div class="btn-group btn-group-sm mx-2" role="group" aria-label="Small button group">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#ubahlokasi<?= $lokasi['id_lokasi'] ?>" class="btn btn-outline-secondary py-0 ps-1"><i class="bi bi-pencil-fill"></i></button>

                                            <a href="hapus-lokasi.php?id=<?= $lokasi['id_lokasi'] ?>" class="btn btn-outline-secondary py-0 ps-1"><i class="bi bi-trash3"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach ?>
                    </ul>

                    <!-- Modal Ubah Lokasi -->
                    <?php foreach ($data_lokasi as $lokasi) : ?>
                        <div class="modal fade" id="ubahlokasi<?= $lokasi['id_lokasi'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ubahLokasiLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header px-4 text-light" style="background-color: #3a4ccb;">
                                        <h1 class="modal-title fs-5" id="tambahLokasiLabel">Ubah Lokasi Aset</h1>
                                        <button type="button" class="btn ms-auto border-0 text-light fs-5" data-bs-dismiss="modal" aria-label=""><i class="bi bi-x-lg fw-bold px-2 py-1"></i></button>
                                    </div>
                                    <div class="modal-body px-4">
                                        <form action="" method="post">
                                            <div class="mb-3">
                                                <label for="">Nama Lokasi</label>
                                                <input type="text" name="nama_lokasi" class="form-control my-2 fw-bold" value="<?= $lokasi['nama_lokasi'] ?>">
                                                <input type="hidden" name="id_lokasi" value="<?= $lokasi['id_lokasi'] ?>">
                                            </div>
                                            <div class="mt-4 text-end">
                                                <button type="submit" name="ubah_lokasi" class="btn btn-sm btn-success"><i class="bi bi-floppy"></i> Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <!-- end  modal tambah lokasi -->
                </div>
            </div>
            <!-- - -->
            <!-- col 2 -->
            <div class="col-lg-4 py-2">
                <div class="card border-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-10">
                                <h6 class="pt-2">Data Kategori Aset</h6>
                            </div>
                            <div class="col-2">
                                <a href="" data-bs-toggle="modal" data-bs-target="#tambahKategori"> <i class="bi bi-plus-circle-fill fs-4 text-primary"></i></a>
                            </div>
                            <!-- Modal Tambah Data Kategori Aset -->
                            <div class="modal fade" id="tambahKategori" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tambahKategoriLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-light px-4" style="background-color: #3a4ccb;">
                                            <h1 class="modal-title fs-4" id="tambahKategoriLabel">Tambah Kategori Aset</h1>
                                            <button type="button" class="btn ms-auto border-0 text-light fs-5" data-bs-dismiss="modal" aria-label=""><i class="bi bi-x-lg fw-bold px-2 py-1"></i></button>
                                        </div>
                                        <div class="modal-body px-4">
                                            <form action="" method="post">
                                                <div class="mb-3">
                                                    <label for="">Nama Kategori</label>
                                                    <input type="text" name="nama_kategori" required class="form-control my-2" placeholder="Masukkan Nama Kategori" autofocus>
                                                </div>
                                                <div class="mt-4 text-end">
                                                    <button type="submit" name="simpan-kategori" class="btn btn-sm btn-success"><i class="bi bi-floppy"></i> Simpan Kategori</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end  Modal Tambah Data Kategori Aset -->
                        </div>
                    </div>
                    <ul class="list-group list-group-flush fw-light">
                        <?php
                        $no_data = 1;
                        foreach ($data_kategori as $kategori) : ?>
                            <li class="list-group-item border-bottom py-0">
                                <div class="row mt-2">
                                    <div class="col-1">
                                        <p class=""><?= $no_data++ ?></p>
                                    </div>
                                    <div class="col-8">
                                        <p><?= $kategori['nama_kategori'] ?></p>
                                    </div>
                                    <div class="col-2">
                                        <div class="btn-group btn-group-sm mx-2" role="group" aria-label="Small button group">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#ubahkategori<?= $kategori['id_kategori'] ?>" class="btn btn-outline-secondary py-0 ps-1"><i class="bi bi-pencil-fill"></i></button>

                                            <a href="hapus-kategori.php?id=<?= $kategori['id_kategori'] ?>" class="btn btn-outline-secondary py-0 ps-1"><i class="bi bi-trash3"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach ?>
                    </ul>

                    <!-- Modal Ubah data Kategori Aset -->
                    <?php foreach ($data_kategori as $kategori) : ?>
                        <div class="modal fade" id="ubahkategori<?= $kategori['id_kategori'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ubahkategoriLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header px-4 text-light" style="background-color: #3a4ccb;">
                                        <h1 class="modal-title fs-5" id="tambahkategoriLabel">Ubah kategori Aset</h1>
                                        <button type="button" class="btn ms-auto border-0 text-light fs-5" data-bs-dismiss="modal" aria-label=""><i class="bi bi-x-lg fw-bold px-2 py-1"></i></button>
                                    </div>
                                    <div class="modal-body px-4">
                                        <form action="" method="post">
                                            <div class="mb-3">
                                                <label for="">Nama kategori</label>
                                                <input type="text" name="nama_kategori" class="form-control my-2 fw-bold" value="<?= $kategori['nama_kategori'] ?>">
                                                <input type="hidden" name="id_kategori" value="<?= $kategori['id_kategori'] ?>">
                                            </div>
                                            <div class="mt-4 text-end">
                                                <button type="submit" name="ubah_kategori" class="btn btn-sm btn-success"><i class="bi bi-floppy"></i> Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <!-- end  Modal Ubah data Kategori Aset -->
                </div>
            </div>
            <!-- - -->
        </div>
    </div>
    <!-- main content end -->
</body>

<!-- js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>