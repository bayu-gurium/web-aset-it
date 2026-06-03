<?php
session_start();
require './modul/fuctions.php';
// cek session
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Tendang balik ke login
    header("Location: index.php");
    exit;
}

// logic simpan data user
if (isset($_POST['simpan-user'])) {

    if (tambahUser($_POST) > 0) {
        $sukses = true;
    } else {
        $error = true;
    }
}

// -----------------------------------------

// Tampilkan semua data lokasi
$data_user = allData("SELECT * FROM user ORDER BY id_user DESC");


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola User</title>
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
                            <a href="#" class="nav-link  dropdown-toggle d-flex align-items-center" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
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
                            <a href="#" class="nav-link active dropdown-toggle d-flex align-items-center" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
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
        <div class="row justify-content-center mt-4 mb-2">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-6 col-lg-6 font-pagination">
                        <small class="m-0">Page</small>
                        <h5>Admin Terdaftar</h5>
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
    </div>

    <div class="container px-5 mt-2">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-lg text-end">
                        <button class="btn btn-sm text-light mb-2" style="background-color: #3a4ccb;" type="button" data-bs-toggle="modal" data-bs-target="#tambahUser"> <i class="bi bi-plus-circle"></i> Tambah User</button>
                        <!-- Modal Tambah User -->
                        <div class="modal fade" id="tambahUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tambahUserLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content text-start">
                                    <div class="modal-header text-light p-1 px-4" style="background-color: #3a4ccb;">
                                        <h5 class="modal-title fs-4" id="tambahUserLabel">Tambah Data User</h5>
                                        <button type="button" class="btn ms-auto border-0 text-light fs-5" data-bs-dismiss="modal" aria-label=""><i class="bi bi-x-lg fw-bold px-2 py-1"></i></button>
                                    </div>
                                    <div class="modal-body px-4">
                                        <form action="" method="post">
                                            <input type="hidden" name="role" value="Admin">
                                            <div class="mb-3">
                                                <label for="">Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap" required class="form-control my-2" placeholder="Nama Lengkap" autofocus>
                                            </div>
                                            <div class="mb-3">
                                                <label for="">Username</label>
                                                <input type="text" name="username" required class="form-control my-2" placeholder="Username" autofocus>
                                            </div>
                                            <div class="mb-3">
                                                <label for="">Email</label>
                                                <input type="email" name="email" required class="form-control my-2" placeholder="Email" autofocus>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="">Password</label>
                                                        <input type="password" name="password" required class="form-control my-2" placeholder="Password" autofocus>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="">Konfirmasi Password</label>
                                                        <input type="password" name="password2" required class="form-control my-2" placeholder="Konfirmasi Password" autofocus>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 text-end">
                                                <button type="submit" name="simpan-user" class="btn btn-sm btn-success"><i class="bi bi-floppy"></i> Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end  modal tambah lokasi -->
                    </div>
                </div>
                <?php if (isset($sukses)) : ?>
                    <div class="alert alert-success p-2 border-0 alert-dismissible d-flex justify-content-between align-items-center px-3" role="alert">
                        <div>
                            <strong>Berhasil !</strong> Data User Baru Berhasil Ditambahkan.
                        </div>
                        <a href="" class="text-decoration-none text-success" data-bs-dismiss="alert" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                <?php endif ?>
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger p-2 border-0 alert-dismissible d-flex justify-content-between align-items-center px-3" role="alert">
                        <div>
                            <strong>Oopss !</strong> Data Gagal Ditambahkan! Periksa Inputan Anda.
                        </div>
                        <a href="" class="text-decoration-none text-success" data-bs-dismiss="alert" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                <?php endif ?>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th class="text-center"><i class="bi bi-pencil-square"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no_data = 1;
                            foreach ($data_user as $user) : ?>
                                <tr>
                                    <td><?= $no_data++ ?></td>
                                    <td><?= $user['nama_lengkap'] ?></td>
                                    <td><?= $user['username'] ?></td>
                                    <td><span class="badge bg-success text-capitalize"><?= $user['role'] ?></span></td>
                                    <td class="text-center">
                                        <!-- Hapus -->
                                        <a href="hapus-user.php?id=<?= $user['id_user'] ?>" class="text-decoration-none" style="color: #f24822;" onclick="return confirm('Yakin mau hapus Data User ini ?')">
                                            <i class="bi bi-trash3 me-3"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- main content end -->
</body>

<!-- js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>