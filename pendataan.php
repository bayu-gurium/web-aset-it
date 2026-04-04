<?php
session_start();
require './modul/fuctions.php';
// cek session
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Tendang balik ke login
    header("Location: index.php");
    exit;
}

// query tampilkan data Lokasi dan Kategori
$data_lokasi = allData("SELECT * FROM lokasi");
$data_kategori = allData("SELECT * FROM kategori");

// cek aksi pada tombol simpan
if (isset($_POST['simpan_pendataan'])) {

    if (tambahDataPendataan($_POST) > 0) {
        $sukses = true;
    } else {
        echo  mysqli_error($db_connect);
    }
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendataan Aset</title>
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
                        <a class="nav-link mx-0 mx-lg fw-semibold active" href="pendataan.php"><i class="bi bi-database-fill-add icon-styles"></i> PENDATAAN & KELOLA ASET</a>
                        <!-- Tools Dropdown -->

                        <div class="dropdown mx-lg-4">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-earmark-bar-graph icon-styles mx-lg-1 me-1"></i>
                                LAPORAN
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
                                <li></li>
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
        <div class="row justify-content-center mt-4 mb-3">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-6 col-lg-6 font-pagination">
                        <small class="m-0">Page</small>
                        <h5>Pengelolaan Aset</h5>
                    </div>
                    <div class="col-lg col-lg-6">
                        <form action="" method="post">
                            <div class="input-group mt-2">
                                <input type="text" class="form-control fw-lighter rounded-start-3" placeholder="Search">
                                <button class="btn btn-search-styles  rounded-end-3" type="submit" id="submit"><i class="bi bi-search" style="font-size: 20px;"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row my-1">
                    <div class="col-lg text-end fw-lighter">
                        <button class="btn btn-sm text-light mb-2" style="background-color: #3a4ccb;" type="button" data-bs-toggle="modal" data-bs-target="#modalTambahAset"> <i class="bi bi-plus-circle"></i> Tambah Aset</button>
                        <!-- Modal Tambah Pendtaan Aset -->
                        <div class="modal fade text-start fw-normal" id="modalTambahAset" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTambahAsetLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="modal-content border-0">
                                        <div class="modal-header px-5 text-light" style="background-color: #3a4ccb;">
                                            <h1 class="modal-title fs-5 mx-4" id="modalTambahAsetLabel">Tambah Data Aset Baru</h1>
                                            <button type="button" class="btn ms-auto border-0 fs-5" data-bs-dismiss="modal" aria-label="close"><i class="bi bi-x-lg text-light"></i></button>
                                        </div>
                                        <div class="modal-body fw-light">
                                            <div class="row justify-content-center">
                                                <!-- col 1 -->
                                                <div class="col-md-8">
                                                    <div class="row justify-content-center">
                                                        <!-- col-1 -->
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label for="nama-aset" class="form-label">Nama Aset</label>

                                                                <input type="text" value="AST-1" name="kode_aset">
                                                                <input type="text" class="form-control" name="nama_aset" id="nama-aset" placeholder="Masukkan Nama Aset">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="lokasi" class="form-label">Lokasi</label>
                                                                <select class="form-select form-select mb-3" name="id_lokasi">
                                                                    <option class="fw-light"> Pilih Lokasi </option>
                                                                    <?php foreach ($data_lokasi as $lokasi) : ?>
                                                                        <option value=" <?= $lokasi['id_lokasi'] ?> "><?= $lokasi['nama_lokasi'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="kondisi" class="form-label">Kondisi</label>
                                                                <select class="form-select form-select mb-3" name="kondisi">
                                                                    <option value="Baik">Baik</option>
                                                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                                                    <option value="Rusak Berat">Rusak Berat</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- col-2 -->
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label for="katgory" class="form-label">Kategori Aset</label>
                                                                <select class="form-select form-select mb-3" name="id_kategori">
                                                                    <option class="fw-light"> Pilih Kategori </option>
                                                                    <?php foreach ($data_kategori as $kategori) : ?>
                                                                        <option value="<?= $kategori['id_kategori'] ?>"><?= $kategori['nama_kategori']  ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tgl" class="form-label">Tanggal Perolehan</label>
                                                                <input type="date" class="form-control" id="tgl" name="tgl_perolehan">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-select form-select mb-3" name="status">
                                                                    <option value="Aktif">Aktif</option>
                                                                    <option value="Cadangan">Cadangan</option>
                                                                    <option value="Dihapuskan">Dihapuskan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-sm-center">
                                                        <div class="col-md-10">
                                                            <div class="mb-3">
                                                                <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                                                <textarea class="form-control" name="spesifikasi" id="spesifikasi" placeholder="Spesifikasi Aset"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-sm-center">
                                                        <div class="col-md-10">
                                                            <div class="mb-3">
                                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                                <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan Aset"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- col 2 -->
                                                <div class="col-md-4 pe-5">
                                                    <div class="row justify-content-center mt-4">
                                                        <div class="preview  rounded my-3 bg-secondary-subtle" style="width: 80%; height: 300px;"></div>
                                                        <div class="field ">
                                                            <div class="row px-2">
                                                                <div class="col-md px-4">
                                                                    <input type="file" class="form-control form-control" aria-describedby="ket" name="foto_aset">
                                                                    <div class="form-text" id="ket">* Ukuran Foto Max 500MB</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer text-center">
                                                        <button type="submit" class="btn text-light" name="simpan_pendataan" style="background-color: #14Ae5c;"><i class="bi bi-floppy me-2"></i> Simpan</button>
                                                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal end -->
                    </div>
                </div>
                <?php if (isset($sukses)) : ?>
                    <div class="alert alert-success p-2 px-2 border-0">
                        <small>Data Aset Baru berhasil Ditambahkan</small>
                    </div>
                <?php endif ?>
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger p-2 px-2 border-0">
                        <small>Data Aset Gagal Ditambahkan!!</small>
                    </div>
                <?php endif ?>
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped fw-light">
                        <thead class="text-center border-bottom border-top">
                            <tr>
                                <th class="fs-6">NO</th>
                                <th class="fs-6">KODE ASET</th>
                                <th class="fs-6">NAMA ASET</th>
                                <th class="fs-6">KATEGORI</th>
                                <th class="fs-6">LOKASI</th>
                                <th class="fs-6">KONDISI</th>
                                <th class="fs-6"><i class="bi bi-pencil-square"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="">1</td>
                                <td class="">BRI01</td>
                                <td class="">Printer Epson</td>
                                <td class="">Printer</td>
                                <td class="text-center">BRIBOX</td>
                                <td class="text-center">Baik</td>
                                <td class="text-end">
                                    <a href="" style="color: #14Ae5c;"><i class="bi bi-pencil-fill me-3"></i></a>
                                    <a href="" style="color: #f24822;"><i class="bi bi-trash3 me-3"></i></a>
                                    <a href="" style="color: #2b32b2;"><i class="bi bi-eye me-3"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="">1</td>
                                <td class="">BRI01</td>
                                <td class="">Printer Epson</td>
                                <td class="">Printer</td>
                                <td class="text-center">BRIBOX</td>
                                <td class="text-center">Baik</td>
                                <td class="text-end">
                                    <a href="" style="color: #14Ae5c;"><i class="bi bi-pencil-fill me-3"></i></a>
                                    <a href="" style="color: #f24822;"><i class="bi bi-trash3 me-3"></i></a>
                                    <a href="" style="color: #2b32b2;"><i class="bi bi-eye me-3"></i></a>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- table end -->

            </div>
        </div>
    </div>
    <!-- main content end -->
</body>

<!-- js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>