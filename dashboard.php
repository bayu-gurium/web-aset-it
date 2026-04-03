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
    <title>Dashboard</title>
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
                        <a class="nav-link active mx-0 mx-lg-5 fw-semibold" aria-current="page" href="dashboard.php">
                            <i class="bi bi-speedometer2 mx-2 icon-styles"></i>DASHBOARD</a>
                        <a class="nav-link mx-0 mx-lg" href="pendataan.php"><i class="bi bi-database-fill-add icon-styles"></i> PENDATAAN & KELOLA ASET</a>
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
        <div class="row justify-content-center mt-4 mb-3">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-6 col-lg-6 font-pagination">
                        <small class="m-0">Page</small>
                        <h5>Dashboard</h5>
                    </div>
                    <div class="col-lg col-lg-6">
                        <form action="" method="post">
                            <div class="input-group mt-2">
                                <input type="text" class="form-control rounded-start-3" placeholder="Search">
                                <button class="btn btn-search-styles  rounded-end-3" type="submit" id="submit"><i class="bi bi-search" style="font-size: 20px;"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- thumnail -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-dashboard shadow-sm border-0 p-2">
                    <!-- row 1 -->
                    <div class="row justify-content-center">
                        <div class="col-lg-7 mb-3 mt-4">
                            <div class="image-dashboard"></div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-4 border-bottom border-1"></div>
                        </div>
                    </div>
                    <!-- row 2 -->
                    <div class="row justify-content-center mt-3 mb-3">
                        <div class="col-3 text-center text-light">
                            <small class="m-0 fw-light card-status">Jumlah</small>
                            <h1 class="fw-bold m-0">50</h1>
                            <small class="m-0 fw-light card-status">Aset</small>
                        </div>
                        <div class="col-3 text-center text-light">
                            <small class="m-0 fw-light card-status">Status</small>
                            <h1 class="fw-bold m-0">50</h1>
                            <small class="m-0 fw-light card-status">Baik <br> Sering digunakan</small>
                        </div>
                        <div class="col-3 text-center text-light">
                            <small class="m-0 fw-light card-status">Status</small>
                            <h1 class="fw-bold m-0">50</h1>
                            <small class="m-0 fw-light card-status">Rusak/Dalam Perbaikan Jarang Digunakan </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- thumnail end -->
        <!-- Paragraph -->
        <div class="row justify-content-center text-center mt-2">
            <div class="col-lg-8">
                <p class="fw-normal">Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque quia, quaerat maiores hic eos natus corporis porro iusto exercitationem beatae fuga.</p>
            </div>
        </div>
        <!-- main content end -->
    </div>
    <!-- footer -->
    <footer>
        <footer class="text-center text-secondary fs-6 mt-1">
            <small>&copy; Copy Right 2025⚡ by <a href="">Nama Develop</a></small>
        </footer>
    </footer>
    <!-- footer end -->
</body>

<!-- js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>