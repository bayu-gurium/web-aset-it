<?php
session_start();
require './modul/fuctions.php';
// cek session
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Tendang balik ke login
    header("Location: index.php");
    exit;
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan</title>
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
                        <button class="btn btn-sm text-light" style="background-color: #3a4ccb;" type="button" data-bs-toggle="modal" data-bs-target="#modalTambahAset"> <i class="bi bi-plus-circle"></i> Tambah Aset</button>
                        <!-- Modal -->
                        <div class="modal fade text-start fw-normal" id="modalTambahAset" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTambahAsetLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <form action="">
                                    <div class="modal-content border-0">
                                        <div class="modal-header px-5 text-light" style="background-color: #3a4ccb;">
                                            <h1 class="modal-title fs-5 mx-4" id="modalTambahAsetLabel">Tambah Data Aset Baru</h1>
                                            <button type="button" class="btn-close me-4" data-bs-dismiss="modal" aria-label="close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <!-- col 1 -->
                                                <div class="col-md-8">
                                                    <div class="row justify-content-center">
                                                        <!-- col-1 -->
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label for="nama-aset" class="form-label">Nama Aset</label>
                                                                <input type="text" class="form-control " name="nama-aset" id="nama-aset" placeholder="Nama Aset">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="lokasi" class="form-label">Lokasi</label>
                                                                <select class="form-select form-select mb-3" name="lokasi">
                                                                    <option selected> Pilih Lokasi </option>
                                                                    <option value="1">Teller</option>
                                                                    <option value="2">Operator</option>
                                                                    <option value="3">Gudang</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="kondisi" class="form-label">Kondisi</label>
                                                                <select class="form-select form-select mb-3" name="kondisi">
                                                                    <option value="1">Baik</option>
                                                                    <option value="2">Rusak Ringan</option>
                                                                    <option value="3">Rusak Berat</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- col-2 -->
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label for="katgory" class="form-label">Kategori Aset</label>
                                                                <select class="form-select form-select mb-3" name="kategory">
                                                                    <option selected> Pilih Kategori </option>
                                                                    <option value="1">Leptop</option>
                                                                    <option value="2">Printer</option>
                                                                    <option value="3">Wifi</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tgl" class="form-label">Tanggal Perolehan</label>
                                                                <input type="date" class="form-control" id="tgl" name="tgl">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-select form-select mb-3" name="status">
                                                                    <option value="1">Aktif</option>
                                                                    <option value="2">Cadangan</option>
                                                                    <option value="3">Dihapuskan</option>
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
                                                                    <input type="file" class="form-control form-control" aria-describedby="ket">
                                                                    <div class="form-text" id="ket">* Ukuran Foto Max 500MB</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer text-center">
                                                        <button type="submit" class="btn text-light" style="background-color: #14Ae5c;"><i class="bi bi-floppy me-2"></i> Simpan</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
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
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-striped">
                        <thead class="text-center border-bottom border-top">
                            <tr>
                                <th class="th-1">NO</th>
                                <th class="th-1">KODE ASET</th>
                                <th class="th-1">NAMA ASET</th>
                                <th class="th-1">KATEGORI</th>
                                <th class="th-1">LOKASI</th>
                                <th class="th-1">KONDISI</th>
                                <th class="th-1"><i class="bi bi-pencil-square"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="td-">1</td>
                                <td class="td-">BRI01</td>
                                <td class="td-">Printer Epson</td>
                                <td class="td-">Printer</td>
                                <td class="text-center td-">BRIBOX</td>
                                <td class="text-center td-">Baik</td>
                                <td class="text-end td-">
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