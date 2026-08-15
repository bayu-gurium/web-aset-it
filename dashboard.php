<?php
session_start();
require './modul/fuctions.php';

// cek session
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Tendang balik ke login
    header("Location: index.php");
    exit;
}

// ambil data untuk statistik & chart dashboard
$dataKategori        = asetPerKategori();
$dataKondisi         = asetPerKondisi();
$asetPerluPerhatian  = asetPerluPerhatian(5);
$asetTerbaru         = asetTerbaru(5);

// siapkan data chart kategori (label & jumlah)
$labelKategori  = array_column($dataKategori, 'nama_kategori');
$jumlahKategori = array_column($dataKategori, 'jumlah');

// siapkan data chart kondisi (label dirapikan & jumlah)
$labelKondisi  = array_map('ucwords', array_column($dataKondisi, 'kondisi'));
$jumlahKondisi = array_column($dataKondisi, 'jumlah');

// helper kecil untuk warna badge kondisi & status di tabel
function badgeKondisi($kondisi)
{
    $kondisi = strtolower($kondisi);
    if ($kondisi === 'baik') return 'success';
    if ($kondisi === 'rusak ringan') return 'warning';
    if ($kondisi === 'rusak berat') return 'danger';
    return 'secondary';
}
function badgeStatus($status)
{
    $status = strtolower($status);
    if ($status === 'aktif') return 'primary';
    if ($status === 'cadangan') return 'secondary';
    if ($status === 'dihapuskan') return 'dark';
    return 'secondary';
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
    <link rel="stylesheet" href="css/style.css?v=<?= file_exists('css/style.css') ? filemtime('css/style.css') : time() ?>">
    <!-- chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.js"></script>

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
                                    <h6 class="dropdown-header">User Profile</h6>
                                </li>
                                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i> Profile Saya</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="user.php"><i class="bi bi-person-add me-2"></i> Admin Terdaftar</a></li>
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
            <div class="col-lg-11">
                <div class="row">
                    <div class="col-6 col-lg-6 font-pagination">
                        <small class="m-0">Page</small>
                        <h5>Dashboard</h5>
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
            </div>
        </div>
        <!-- stat cards -->
        <div class="row justify-content-center g-3 mb-1">
            <div class="col-lg-11">
                <div class="row g-3">
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card stat-card-blue shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="stat-icon stat-icon-blue"><i class="bi bi-hdd-stack-fill"></i></div>
                                <div>
                                    <small class="text-muted d-block">Total Aset</small>
                                    <h3 class="fw-bold m-0"><?= jumlahAset() ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card stat-card-green shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="stat-icon stat-icon-green"><i class="bi bi-check-circle-fill"></i></div>
                                <div>
                                    <small class="text-muted d-block">Aset Aktif</small>
                                    <h3 class="fw-bold m-0"><?= jumlahAsetAktif() ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card stat-card-orange shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="stat-icon stat-icon-orange"><i class="bi bi-patch-check-fill"></i></div>
                                <div>
                                    <small class="text-muted d-block">Kondisi Baik</small>
                                    <h3 class="fw-bold m-0"><?= kondisiBaik() ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card stat-card-red shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="stat-icon stat-icon-red"><i class="bi bi-exclamation-triangle-fill"></i></div>
                                <div>
                                    <small class="text-muted d-block">Perlu Perhatian</small>
                                    <h3 class="fw-bold m-0"><?= jumlahAsetRusak() ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- stat cards end -->

        <!-- charts -->
        <div class="row justify-content-center g-3 mt-1 mb-1">
            <div class="col-lg-11">
                <div class="row g-3">
                    <div class="col-lg-7">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3">Distribusi Aset per Kategori</h6>
                                <?php if (count(array_filter($jumlahKategori)) > 0) : ?>
                                    <canvas id="chartKategori" height="140"></canvas>
                                <?php else : ?>
                                    <p class="text-muted small m-0">Belum ada data aset untuk ditampilkan.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3">Kondisi Aset</h6>
                                <?php if (count(array_filter($jumlahKondisi)) > 0) : ?>
                                    <canvas id="chartKondisi" height="180"></canvas>
                                <?php else : ?>
                                    <p class="text-muted small m-0">Belum ada data aset untuk ditampilkan.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- charts end -->

        <!-- tables -->
        <div class="row justify-content-center g-3 mt-1 mb-4">
            <div class="col-lg-11">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3"><i class="bi bi-exclamation-triangle text-danger"></i> Aset Perlu Perhatian</h6>
                                <?php if (count($asetPerluPerhatian) > 0) : ?>
                                    <div class="table-responsive">
                                        <table class="table table-sm align-middle mb-0">
                                            <thead>
                                                <tr class="text-muted small">
                                                    <th>Kode</th>
                                                    <th>Nama Aset</th>
                                                    <th>Lokasi</th>
                                                    <th>Kondisi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($asetPerluPerhatian as $item) : ?>
                                                    <tr>
                                                        <td class="small"><?= $item['kode_aset'] ?></td>
                                                        <td class="small"><?= $item['nama_aset'] ?></td>
                                                        <td class="small"><?= $item['nama_lokasi'] ?? '-' ?></td>
                                                        <td><span class="badge bg-<?= badgeKondisi($item['kondisi']) ?>"><?= ucwords($item['kondisi']) ?></span></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else : ?>
                                    <p class="text-muted small m-0">Semua aset dalam kondisi baik. Tidak ada yang perlu perhatian.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3"><i class="bi bi-clock-history text-primary"></i> Aset Terbaru Ditambahkan</h6>
                                <?php if (count($asetTerbaru) > 0) : ?>
                                    <div class="table-responsive">
                                        <table class="table table-sm align-middle mb-0">
                                            <thead>
                                                <tr class="text-muted small">
                                                    <th>Kode</th>
                                                    <th>Nama Aset</th>
                                                    <th>Kategori</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($asetTerbaru as $item) : ?>
                                                    <tr>
                                                        <td class="small"><?= $item['kode_aset'] ?></td>
                                                        <td class="small"><?= $item['nama_aset'] ?></td>
                                                        <td class="small"><?= $item['nama_kategori'] ?? '-' ?></td>
                                                        <td><span class="badge bg-<?= badgeStatus($item['status']) ?>"><?= ucwords($item['status']) ?></span></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else : ?>
                                    <p class="text-muted small m-0">Belum ada data aset yang ditambahkan.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- tables end -->
        <!-- main content end -->
    </div>
    <!-- footer -->
    <footer>
        <footer class="text-center text-secondary fs-6 mt-1">
            <small>&copy; Copy Right 2025⚡ by <a href="">Achmad Syafii Ie</a></small>
        </footer>
    </footer>
    <!-- footer end -->
</body>

<!-- js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<!-- chart js init -->
<script>
    // Chart: Distribusi Aset per Kategori
    const kategoriCtx = document.getElementById('chartKategori');
    if (kategoriCtx) {
        new Chart(kategoriCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labelKategori) ?>,
                datasets: [{
                    label: 'Jumlah Aset',
                    data: <?= json_encode($jumlahKategori) ?>,
                    backgroundColor: '#1488cc',
                    borderRadius: 6,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    }

    // Chart: Kondisi Aset
    const kondisiCtx = document.getElementById('chartKondisi');
    if (kondisiCtx) {
        new Chart(kondisiCtx, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($labelKondisi) ?>,
                datasets: [{
                    data: <?= json_encode($jumlahKondisi) ?>,
                    backgroundColor: ['#38ef7d', '#ff9c11', '#eb3349', '#adb5bd']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
</script>

</html>