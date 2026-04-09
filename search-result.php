<?php
session_start();
require './modul/fuctions.php';

$keyword = mysqli_real_escape_string($db_connect, trim($_GET['keyword']));

// Query JOIN untuk nyari di nama aset, kategori, lokasi, atau kondisi
$query = "SELECT aset.*, kategori.nama_kategori, lokasi.nama_lokasi 
          FROM aset 
          JOIN kategori ON aset.id_kategori = kategori.id_kategori
          JOIN lokasi ON aset.id_lokasi = lokasi.id_lokasi
          WHERE aset.nama_aset LIKE '%$keyword%' 
          OR kategori.nama_kategori LIKE '%$keyword%' 
          OR aset.kondisi LIKE '%$keyword%'
          OR lokasi.nama_lokasi LIKE '%$keyword%'
          OR kategori.nama_kategori LIKE '%$keyword%'
          OR aset.status LIKE '%$keyword%'
          OR aset.kode_aset LIKE '%$keyword%'";

$result = mysqli_query($db_connect, $query);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Aset</title>
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
                        <h5>Result Data Aset</h5>
                    </div>
                    <div class="col-lg col-lg-6">
                        <form action="search-result.php" method="get">
                            <div class="input-group mt-2">
                                <input type="text" name="keyword" class="form-control rounded-start-3" placeholder="Search" autocomplete="off">
                                <button class="btn btn-search-styles  rounded-end-3" type="submit" id="submit"><i class="bi bi-search" style="font-size: 20px;"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="container mt-4">
                        <div class="alert alert-sm alert-light">
                            <h6 class="m-0"><i class="bi bi-search mx-2"></i> Hasil Pencarian : <span class="fw-bold px-2"> "<?= $keyword ?> "</span> </h6>
                        </div>
                        <hr>
                        <div class="row">
                            <?php if (mysqli_num_rows($result) > 0) : ?>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card shadow border-0 border-top border-secondary-subtle border-3 rounded-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <h5 class="card-title fw-bold"><?= $row['nama_aset'] ?></h5>
                                                        <p class="card-text mb-1">
                                                            <span class="badge bg-light text-dark"><?= $row['kode_aset'] ?></span>
                                                            <span class="badge bg-info text-dark"><?= $row['nama_kategori'] ?></span>
                                                        </p>
                                                        <small class="text-muted d-block">Lokasi: <?= $row['nama_lokasi'] ?></small>
                                                        <small class="text-muted d-block">Kondisi: **<?= $row['kondisi'] ?>**</small>
                                                        <a href="detail_aset.php?id=<?= $row['id_aset'] ?>" class="btn btn-sm btn-outline-info mt-2" data-bs-toggle="modal" data-bs-target="#modalDetailAset<?= $row['id_aset'] ?>">Lihat Detail</a>
                                                    </div>
                                                    <div class="col-3 d-flex justify-content-center align-items-center">
                                                        <img src="./assets/img/foto-aset/<?= $row['foto_aset'] ?>" alt="" width="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Detail -->
                                    <div class="modal fade text-start fw-normal" id="modalDetailAset<?= $row['id_aset'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDetailAsetLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="modal-content border-0">
                                                    <div class="modal-header px-5 p-2 text-light bg-info">
                                                        <h1 class="modal-title fs-5 mx-2" id="modalTambahAsetLabel">Detail Data Aset <?= $row['kode_aset'] ?> - <?= $row['nama_aset'] ?> </h1>
                                                        <button type="button" class="btn ms-auto border-0 fs-5 text-light" data-bs-dismiss="modal" aria-label="close"><i class="bi bi-x-lg"></i></button>
                                                    </div>
                                                    <div class="modal-body fw-light">
                                                        <div class="row">
                                                            <div class="col-md-5 mb-3">
                                                                <div class="card border-0 shadow-sm">
                                                                    <img src="assets/img/foto-aset/<?= $row['foto_aset'] ?>" class="img-fluid rounded" style="width: 100%; height: 450px; object-fit: cover;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7 pe-5">
                                                                <h4 class="fw-bold"><?= $row['nama_aset'] ?></h4>
                                                                <hr>
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                                        <span>
                                                                            <i class="bi bi-tag-fill text-muted me-2"></i>
                                                                            <span class="text-muted">Kategori</span>
                                                                        </span>
                                                                        <span class="fw-semibold"><?= $row['nama_kategori'] ?></span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                                        <span>
                                                                            <i class="bi bi-calendar3 text-muted me-2"></i>
                                                                            <span class="text-muted">Tanggal Perolehan</span>
                                                                        </span>
                                                                        <span class="fw-semibold"><?= date('d M Y', strtotime($row['tgl_perolehan'])) ?></span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                                        <span>
                                                                            <i class="bi bi-geo-alt-fill text-muted me-2"></i>
                                                                            <span class="text-muted">Lokasi Penempatan</span>
                                                                        </span>
                                                                        <span class="fw-semibold"><?= $row['nama_lokasi'] ?></span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                                        <span>
                                                                            <i class="bi bi-activity text-muted me-2"></i>
                                                                            <span class="text-muted">Kondisi Saat Ini</span>
                                                                        </span>
                                                                        <span class="badge rounded bg-<?= ($row['kondisi'] == 'Baik') ? 'success' : 'warning' ?>">
                                                                            <?= $row['kondisi'] ?>
                                                                        </span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                                        <span>
                                                                            <i class="bi bi-info-circle-fill text-muted me-2"></i>
                                                                            <span class="text-muted">Status Operasional</span>
                                                                        </span>
                                                                        <span class="fw-semibold text-<?= ($row['status'] == 'Aktif') ? 'success' : 'warning' ?> "><?= $row['status'] ?></span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                                    </li>
                                                                </ul>
                                                                <div class="row mt-4">
                                                                    <div class="col-12">
                                                                        <div class="p-3 bg-light rounded-1 border-start border-info border-2">
                                                                            <h6 class="fw-bold">Spesifikasi Teknik:</h6>
                                                                            <p class="mb-0 text-secondary small"><?= nl2br($row['spesifikasi']) ?></p>
                                                                        </div>
                                                                        <div class="mt-3 p-2 bg-light rounded-1 border-start border-secondary border-2">
                                                                            <h6 class="fw-bold">Keterangan Tambahan:</h6>
                                                                            <p class="text-muted small"><?= !empty($row['keterangan']) ? nl2br($row['keterangan']) : '-' ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--  -->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <div class="alert alert-warning">Data tidak ditemukan dengan kata kunci tersebut.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>