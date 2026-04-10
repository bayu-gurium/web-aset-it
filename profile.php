<?php
session_start();
require './modul/fuctions.php';
// cek session
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Tendang balik ke login
    header("Location: index.php");
    exit;
}

// Ambil data user yang sedang login
$id_user = $_SESSION["id_user"];
$user = mysqli_query($db_connect, "SELECT * FROM user WHERE id_user = $id_user");
$u = mysqli_fetch_assoc($user);

// simpan perubahan di klik
if (isset($_POST['simpan_nama'])) {

    if (ubahNamaUser($_POST) > 0) {
        $suksess_update = true;
    } else {
        $error_update = true;
    }
}
// Update Password
if (isset($_POST['update_password'])) {
    if (updatePassword($_POST) > 0) {

        $sukkses_up_pass = true;
    } else {
        $error_up_pass = true;
    }
}
// Ubah FotoProfile
if (isset($_POST["update_foto"])) {
    $id_user = $_POST["id_user"];
    $foto_lama = $_POST["foto_lama"];

    // Jalankan fungsi upload
    $foto_baru = uploadFotoProfile();

    // Cek respon dari fungsi upload
    if ($foto_baru === "error_format") {
        echo "<script>alert('Format file tidak didukung! Harus JPG/PNG.'); window.history.back();</script>";
        exit;
    } elseif ($foto_baru === "error_size") {
        echo "<script>alert('Ukuran foto terlalu besar! Maksimal 2MB.'); window.history.back();</script>";
        exit;
    } elseif ($foto_baru === "no_file") {
        echo "<script>alert('Pilih file foto dulu'); window.history.back();</script>";
        exit;
    } else {
        // --- PROSES PENGHAPUSAN FOTO LAMA ---
        // Kita hanya hapus jika fotonya BUKAN 'default.jpg' dan filenya beneran ada.
        if ($foto_lama !== 'default.jpg') {
            $path_foto_lama = 'assets/img/profile_foto/' . $foto_lama;
            if (file_exists($path_foto_lama)) {
                // Gunakan unlink() untuk hapus file
                unlink($path_foto_lama);
            }
        }

        // --- UPDATE DATABASE ---
        mysqli_query($db_connect, "UPDATE user SET foto_profile = '$foto_baru' WHERE id_user = '$id_user'");

        // Jika berhasil update (ada baris yang terpengaruh)
        if (mysqli_affected_rows($db_connect) > 0) {
            echo "<script>alert('Foto profile berhasil diperbarui!'); document.location.href='profile.php';</script>";
        } else {
            // Jika query gagal atau datanya sama (jarang terjadi karena unlink)
            echo "<script>alert('Gagal memperbarui foto di database.'); document.location.href='profile.php';</script>";
        }
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile</title>
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
                        <h5>Profile Saya</h5>
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header p-3">
                        <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Profile Saya</h5>
                    </div>
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center mb-4">
                                <img src="assets/img/profile_foto/<?= $u['foto_profile'] ?>"
                                    class="rounded-circle img-thumbnail shadow-sm"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                                <button class="btn btn-sm btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalGantiFoto">
                                    <i class="bi bi-camera me-1"></i> Ganti Foto
                                </button>
                            </div>

                            <!-- Modal Ganti foto  -->
                            <div class="modal fade" id="modalGantiFoto" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="modal-content border-0">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title"><i class="bi bi-camera me-2"></i>Ganti Foto Profile</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id_user" value="<?= $u['id_user']; ?>">
                                                <input type="hidden" name="foto_lama" value="<?= $u['foto_profile']; ?>">

                                                <div class="text-center mb-3">
                                                    <img src="assets/img/profile_foto/<?= $u['foto_profile']; ?>" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                    <p class="text-muted small mt-2">Foto Saat Ini</p>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Pilih Foto Baru</label>
                                                    <input type="file" name="foto_profile" class="form-control" accept="image/png, image/jpeg, image/jpg" required>
                                                    <small class="text-muted italic">*Format: JPG, JPEG, PNG. Maks: 2MB.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" name="update_foto" class="btn btn-primary px-4">
                                                    <i class="bi bi-upload me-1"></i> Upload & Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Modal Ganti foto  -->


                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md">
                                        <?php if (isset($suksess_update)) : ?>
                                            <div class="alert alert-success p-2 border-0 alert-dismissible d-flex justify-content-between align-items-center px-3" role="alert">
                                                <div>
                                                    <strong>Berhasil !</strong> Nama User berhasil diubah.
                                                </div>
                                                <a href="" class="text-decoration-none text-success" data-bs-dismiss="alert" aria-label="Close">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </div>
                                        <?php endif ?>
                                        <!-- alert update Password -->
                                        <?php if (isset($sukkses_up_pass)) : ?>
                                            <div class="alert alert-success p-2 border-0 alert-dismissible d-flex justify-content-between align-items-center px-3" role="alert">
                                                <div>
                                                    <strong>Berhasil !</strong> Password berhasil diubah!
                                                </div>
                                                <a href="" class="text-decoration-none text-success" data-bs-dismiss="alert" aria-label="Close">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </div>
                                        <?php endif ?>
                                        <?php if (isset($error_up_pass)) : ?>
                                            <div class="alert alert-danger p-2 border-0 alert-dismissible d-flex justify-content-between align-items-center px-3" role="alert">
                                                <div>
                                                    <strong>Gagal !</strong> Password Gagal diubah!
                                                </div>
                                                <a href="" class="text-decoration-none text-success" data-bs-dismiss="alert" aria-label="Close">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <form action="" method="post">
                                    <input type="hidden" name="id_user" value="<?= $u['id_user']; ?>">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Username</label>
                                        <input type="text" class="form-control bg-light" value="<?= $u['username']; ?>" readonly>
                                        <small class="text-muted italic">*Username tidak dapat diubah</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" class="form-control" value="<?= $u['nama_lengkap']; ?>" required>
                                    </div>

                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalGantiPassword">
                                            <i class="bi bi-key me-1"></i> Ganti Password
                                        </button>
                                        <button type="submit" class="btn btn-primary px-4" name="simpan_nama">
                                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </form>

                                <!-- Modal Ganti Password -->
                                <div class="modal fade" id="modalGantiPassword" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="" method="post">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Ganti Password</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_user" value="<?= $u['id_user']; ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label">Password Baru</label>
                                                        <input type="password" placeholder="Masukkan Password Baru" name="pass_baru" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Konfirmasi Password Baru</label>
                                                        <input type="password" placeholder="Konfirmasi Password Baru" name="konfirmasi_pass" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="update_password" class="btn btn-primary w-100">Update Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Modal Ganti Password -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content end -->
</body>

<!-- js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>