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

// cek tombol update  Simpan ditekan
if (isset($_POST['update_pendataan'])) {

    if (updateDaatAset($_POST) > 0) {
        $sukses_update = true;
    } else {
        echo mysqli_error($db_connect);
    }
}

// query JOIN Data Kategori dan Lokasi dengan data Aset
$data_aset = allData("SELECT * FROM aset JOIN kategori ON aset.id_kategori = kategori.id_kategori JOIN lokasi ON aset.id_lokasi = lokasi.id_lokasi ORDER BY id_aset DESC");


// 1. Cari kode aset terakhir
$query = mysqli_query($db_connect, "SELECT max(kode_aset) as kodeTerbesar FROM aset");
$data = mysqli_fetch_array($query);
$kodeAset = $data['kodeTerbesar'];

// 2. Mengambil angka dari kode aset, misal AST-001 ambil 001-nya
// Kita asumsikan formatnya AST-XXX (angka mulai dari karakter ke-4)
$urutan = (int) substr($kodeAset, 4, 3);

// 3. Bilangan ditambah 1
$urutan++;

// 4. Membentuk kode aset baru
// sprintf("%03s", $urutan) fungsinya biar angkanya jadi 001, 002, dst (3 digit)
$huruf = "AST-";
$kodeOtomatis = $huruf . sprintf("%03s", $urutan);


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

<script>
    function previewImage() {
        const image = document.querySelector('#foto-aset');
        const imgPreview = document.querySelector('#img-preview');
        const textPreview = document.querySelector('#text-preview');

        // Munculkan tag gambar, sembunyikan teks placeholder
        imgPreview.style.display = 'block';
        textPreview.style.display = 'none';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }

    // function previewImage2() {
    //     const image = document.querySelector('#foto-aset2');
    //     const imgPreview = document.querySelector('#img-preview2');
    //     const textPreview = document.querySelector('#text-preview2');

    //     // Munculkan tag gambar, sembunyikan teks placeholder
    //     imgPreview.style.display = 'block';
    //     textPreview.style.display = 'none';

    //     const oFReader = new FileReader();
    //     oFReader.readAsDataURL(image.files[0]);

    //     oFReader.onload = function(oFREvent) {
    //         imgPreview.src = oFREvent.target.result;
    //     }
    // }

    function previewUbah(id) {
        // Ambil elemen berdasarkan ID unik tadi
        const file = document.querySelector('#foto-aset2' + id);
        const img = document.querySelector('#img-preview2' + id);
        const text = document.querySelector('#text-preview2' + id);

        if (file.files && file.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                img.style.display = 'block'; // Tampilkan gambar
                img.src = e.target.result; // Isi gambar dengan file baru
                if (text) {
                    text.style.display = 'none'; // Sembunyikan tulisan "Preview"
                }
            }

            reader.readAsDataURL(file.files[0]);
        }
    }
</script>


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
            <div class="col-lg-10">
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
            <div class="col-lg-10">
                <div class="row my-1">
                    <div class="col-lg text-end fw-lighter">
                        <button class="btn btn-sm text-light mb-2" style="background-color: #3a4ccb;" type="button" data-bs-toggle="modal" data-bs-target="#modalTambahAset"> <i class="bi bi-plus-circle"></i> Tambah Aset</button>

                        <!-- Modal Tambah Pendataan Aset -->
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
                                                            <div class="mb-2 mt-2">
                                                                <label for="nama-aset" class="">Kode Aset</label>
                                                                <input type="text" class="form-control fw-semibold form-control m-0 bg-secondary-subtle" readonly value="<?= $kodeOtomatis ?>
                                                                " name="kode_aset">
                                                            </div>
                                                            <div class="mb-3 mt-3">
                                                                <label for="nama-aset" class="form-label">Nama Aset</label>
                                                                <input type="text" class="form-control" name="nama_aset" id="nama-aset" placeholder="Masukkan Nama Aset" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="lokasi" class="form-label">Lokasi</label>
                                                                <select class="form-select form-select mb-3" name="id_lokasi" required>
                                                                    <option class="fw-light"> Pilih Lokasi </option>
                                                                    <?php foreach ($data_lokasi as $lokasi) : ?>
                                                                        <option value=" <?= $lokasi['id_lokasi'] ?> "><?= $lokasi['nama_lokasi'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="kondisi" class="form-label">Kondisi</label>
                                                                <select class="form-select mb-3" required name="kondisi">
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
                                                                <select class="form-select mb-3" name="id_kategori">
                                                                    <option class="fw-light"> Pilih Kategori </option>
                                                                    <?php foreach ($data_kategori as $kategori) : ?>
                                                                        <option value="<?= $kategori['id_kategori'] ?>"><?= $kategori['nama_kategori']  ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tgl" class="form-label">Tanggal Perolehan</label>
                                                                <input type="date" class="form-control" id="tgl" name="tgl_perolehan" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-select form-select mb-3" name="status" required>
                                                                    <option value="Aktif">Aktif</option>
                                                                    <option value="Cadangan">Cadangan</option>
                                                                    <option value="Dihapuskan">Dihapuskan</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                                                <textarea class="form-control" name="spesifikasi" required id="spesifikasi" placeholder="Spesifikasi Aset"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-sm-center">
                                                        <div class="col-md-10">
                                                            <div class="mb-3">
                                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                                <textarea class="form-control" name="keterangan" required id="keterangan" placeholder="Keterangan Aset"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- col 2 -->

                                                <div class="col-md-4 pe-5">
                                                    <div class="row justify-content-center mt-4">
                                                        <div class="preview rounded my-3 bg-secondary-subtle d-flex align-items-center justify-content-center overflow-hidden" style="width: 80%; height: 300px; border: 2px dashed #ccc;">
                                                            <img src="" id="img-preview" class="img-fluid" style="display: none; object-fit:cover; width: 100%; height: 100%;">
                                                            <small id="text-preview" class="text-muted">Preview Foto</small>
                                                        </div>
                                                        <div class="field ">
                                                            <div class="row px-2">
                                                                <div class="col-md px-4">
                                                                    <input type="file" class="form-control form-control" aria-describedby="ket" name="foto_aset" id="foto-aset" onchange="previewImage()">
                                                                    <div class="form-text" id="ket">* Ukuran Foto Max 2MB</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer text-center">
                                                        <button type="submit" class="btn text-light" name="simpan_pendataan" style="background-color: #14Ae5c;"><i class="bi bi-floppy me-2"></i> Simpan</button>
                                                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal Tambah Data Aset end -->

                        <!-- Modal Ubah Pendataan Aset -->
                        <?php foreach ($data_aset as $aset) : ?>
                            <div class="modal fade text-start fw-normal" id="modalUbahAset<?= $aset['id_aset'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalUbahAsetLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <!-- foto lama -->
                                        <input type="hidden" name="old_foto" value="<?= $aset['foto_aset'] ?>">
                                        <input type="hidden" name="id_aset" value="<?= $aset['id_aset'] ?>">

                                        <div class="modal-content border-0">
                                            <div class="modal-header px-5 text-light" style="background-color: #3a4ccb;">
                                                <h1 class="modal-title fs-5 mx-4" id="modalTambahAsetLabel">Edit / Update Data Aset</h1>
                                                <button type="button" class="btn ms-auto border-0 fs-5" data-bs-dismiss="modal" aria-label="close"><i class="bi bi-x-lg text-light"></i></button>
                                            </div>
                                            <div class="modal-body fw-light">
                                                <div class="row justify-content-center">
                                                    <!-- col 1 -->
                                                    <div class="col-md-8">
                                                        <div class="row justify-content-center">
                                                            <!-- col-1 -->
                                                            <div class="col-md-5">
                                                                <div class="mb-2 mt-2">
                                                                    <label for="nama-aset" class="">Kode Aset</label>
                                                                    <input type="text" class="form-control fw-semibold form-control m-0 bg-secondary-subtle" readonly value="<?= $aset['kode_aset'] ?>" name="kode_aset">
                                                                </div>
                                                                <div class="mb-3 mt-3">
                                                                    <label for="nama-aset" class="form-label">Nama Aset</label>
                                                                    <input type="text" class="form-control fw-semibold" name="nama_aset" id="nama-aset" placeholder="Masukkan Nama Aset" value="<?= $aset['nama_aset'] ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="lokasi" class="form-label">Lokasi</label>
                                                                    <select class="form-select form-select fw-semibold mb-3" name="id_lokasi" required>
                                                                        <option class="fw-light"> Pilih Lokasi </option>
                                                                        <?php foreach ($data_lokasi as $lokasi) : ?>
                                                                            <option value="<?= $lokasi['id_lokasi'] ?>" <?= ($aset['id_lokasi'] == $lokasi['id_lokasi']) ? 'selected' : '' ?>>
                                                                                <?= $lokasi['nama_lokasi'] ?>
                                                                            </option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="kondisi" class="form-label">Kondisi</label>
                                                                    <select class="form-select mb-3 fw-semibold" name="kondisi">
                                                                        <option value="Baik" <?= ($aset['kondisi'] == 'Baik') ? 'selected' : '' ?>>
                                                                            Baik
                                                                        </option>
                                                                        <option value="Rusak Ringan" <?= ($aset['kondisi'] == 'Rusak Ringan') ? 'selected' : '' ?>>
                                                                            Rusak Ringan
                                                                        </option>
                                                                        <option value="Rusak Berat" <?= ($aset['kondisi'] == 'Rusak Berat') ? 'selected' : '' ?>>
                                                                            Rusak Berat
                                                                        </option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- col-2 -->
                                                            <div class="col-md-5">
                                                                <div class="mb-3">
                                                                    <label for="katgory" class="form-label">Kategori Aset</label>
                                                                    <select class="form-select mb-3 fw-semibold" name="id_kategori">
                                                                        <option class="fw-light"> Pilih Kategori </option>
                                                                        <?php foreach ($data_kategori as $kategori) : ?>
                                                                            <option value="<?= $kategori['id_kategori'] ?>" <?= ($aset['id_kategori'] == $kategori['id_kategori']) ? 'selected' : '' ?>>
                                                                                <?= $kategori['nama_kategori'] ?>
                                                                            </option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="tgl" class="form-label">Tanggal Perolehan</label>
                                                                    <input type="date" class="form-control fw-semibold" id="tgl" name="tgl_perolehan" value="<?= $aset['tgl_perolehan'] ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select class="form-select form-select fw-semibold mb-3" name="status" required>

                                                                        <option value="Aktif"
                                                                            <?= ($aset['status'] === 'Aktif') ? 'selected' : '' ?>>
                                                                            Aktif
                                                                        </option>

                                                                        <option value="Cadangan" <?= ($aset['status'] === 'Cadangan') ? 'selected' : '' ?>>
                                                                            Cadangan
                                                                        </option>

                                                                        <option value="Dihapuskan" <?= ($aset['status'] === 'Dihapuskan') ? 'selected' : '' ?>>
                                                                            Dihapuskan
                                                                        </option>

                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                                                    <textarea class="form-control fw-semibold" name="spesifikasi" required id="spesifikasi" placeholder="Spesifikasi Aset"><?= $aset['spesifikasi'] ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-sm-center">
                                                            <div class="col-md-10">
                                                                <div class="mb-3">
                                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                                    <textarea class="form-control fw-semibold" name="keterangan" required id="keterangan" placeholder="Keterangan Aset"><?= $aset['keterangan'] ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- col 2 -->

                                                    <div class="col-md-4 pe-5">
                                                        <div class="row justify-content-center mt-4">
                                                            <div class="preview rounded-1 my-3  d-flex align-items-center justify-content-center" style="width: 100%; height: 250px; border: 2px dashed #ccc;">
                                                                <img src="assets/img/foto-aset/<?= $aset['foto_aset'] ?>" id="img-preview2<?= $aset['id_aset'] ?>" class="img-fluid" style="display:<?= !empty($aset['foto_aset']) ? 'block' : 'none' ?>; width: 100%; height: 100%;">

                                                                <small id="text-preview2<?= $aset['id_aset'] ?>" class="text-muted" style="display: <?= !empty($aset['foto_aset']) ? 'none' : 'block' ?>;">Preview Foto</small>
                                                            </div>

                                                            <div class="field ">
                                                                <div class="row px-2">
                                                                    <div class="col-md px-4">
                                                                        <input type="file" class="form-control form-control" aria-describedby="ket" name="foto_aset" id="foto-aset2<?= $aset['id_aset'] ?>" onchange="previewUbah(<?= $aset['id_aset'] ?>)">
                                                                        <div class="form-text" id="ket">* Ukuran Foto Max 2MB</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer text-center">
                                                            <button type="submit" class="btn text-light" name="update_pendataan" style="background-color: #14Ae5c;"><i class="bi bi-floppy me-2"></i> Update & Simpan</button>
                                                            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- Modal Ubah Data  Aset end -->

                        <!-- Modal Detail Pendataan Aset -->
                        <?php foreach ($data_aset as $aset) : ?>
                            <div class="modal fade text-start fw-normal" id="modalDetailAset<?= $aset['id_aset'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDetailAsetLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="modal-content border-0">
                                            <div class="modal-header px-5 p-2 text-light" style="background-color: #3a4ccb;">
                                                <h1 class="modal-title fs-5 mx-2" id="modalTambahAsetLabel">Detail Data Aset <?= $aset['kode_aset'] ?> - <?= $aset['nama_aset'] ?> </h1>
                                                <button type="button" class="btn ms-auto border-0 fs-5 text-light" data-bs-dismiss="modal" aria-label="close"><i class="bi bi-x-lg"></i></button>
                                            </div>
                                            <div class="modal-body fw-light">
                                                <div class="row">
                                                    <div class="col-md-5 mb-3">
                                                        <div class="card border-0 shadow-sm">
                                                            <img src="assets/img/foto-aset/<?= $aset['foto_aset'] ?>" class="img-fluid rounded" style="width: 100%; height: 450px; object-fit: cover;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 pe-5">
                                                        <h4 class="fw-bold"><?= $aset['nama_aset'] ?></h4>
                                                        <hr>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                                <span>
                                                                    <i class="bi bi-tag-fill text-muted me-2"></i>
                                                                    <span class="text-muted">Kategori</span>
                                                                </span>
                                                                <span class="fw-semibold"><?= $aset['nama_kategori'] ?></span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                                <span>
                                                                    <i class="bi bi-calendar3 text-muted me-2"></i>
                                                                    <span class="text-muted">Tanggal Perolehan</span>
                                                                </span>
                                                                <span class="fw-semibold"><?= date('d M Y', strtotime($aset['tgl_perolehan'])) ?></span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                                <span>
                                                                    <i class="bi bi-geo-alt-fill text-muted me-2"></i>
                                                                    <span class="text-muted">Lokasi Penempatan</span>
                                                                </span>
                                                                <span class="fw-semibold"><?= $aset['nama_lokasi'] ?></span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                                <span>
                                                                    <i class="bi bi-activity text-muted me-2"></i>
                                                                    <span class="text-muted">Kondisi Saat Ini</span>
                                                                </span>
                                                                <span class="badge rounded bg-<?= ($aset['kondisi'] == 'Baik') ? 'success' : 'warning' ?>">
                                                                    <?= $aset['kondisi'] ?>
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                                <span>
                                                                    <i class="bi bi-info-circle-fill text-muted me-2"></i>
                                                                    <span class="text-muted">Status Operasional</span>
                                                                </span>
                                                                <span class="fw-semibold text-<?= ($aset['status'] == 'Aktif') ? 'success' : 'warning' ?> "><?= $aset['status'] ?></span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                            </li>
                                                        </ul>
                                                        <div class="row mt-4">
                                                            <div class="col-12">
                                                                <div class="p-3 bg-light rounded-1 border-start border-info border-2">
                                                                    <h6 class="fw-bold">Spesifikasi Teknik:</h6>
                                                                    <p class="mb-0 text-secondary small"><?= nl2br($aset['spesifikasi']) ?></p>
                                                                </div>
                                                                <div class="mt-3 p-2 bg-light rounded-1 border-start border-secondary border-2">
                                                                    <h6 class="fw-bold">Keterangan Tambahan:</h6>
                                                                    <p class="text-muted small"><?= !empty($aset['keterangan']) ? nl2br($aset['keterangan']) : '-' ?></p>
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
                        <?php endforeach; ?>
                        <!-- Modal Detail Data  Aset end -->
                    </div>
                </div>
                <?php if (isset($sukses)) : ?>
                    <div class="alert alert-success p-2 border-0 alert-dismissible d-flex justify-content-between align-items-center px-3" role="alert">
                        <div>
                            <strong>Berhasil !</strong> Data Aset Baru Berhasil Ditambahkan.
                        </div>
                        <a href="" class="text-decoration-none text-success" data-bs-dismiss="alert" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                <?php endif ?>
                <?php if (isset($sukses_update)) : ?>
                    <div class="alert alert-success p-2 border-0 alert-dismissible d-flex justify-content-between align-items-center px-3" role="alert">
                        <div>
                            <strong>Berhasil !</strong> Data Aset telah Diupdate.
                        </div>
                        <a href="" class="text-decoration-none text-success" data-bs-dismiss="alert" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                <?php endif ?>
                <!-- table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped fw-light">
                        <thead class=" border-bottom border-top">
                            <tr>
                                <th class="fs-6">NO</th>
                                <th class="fs-6">KODE ASET</th>
                                <th class="fs-6">NAMA ASET</th>
                                <th class="fs-6">KATEGORI</th>
                                <th class="fs-6">LOKASI</th>
                                <th class="fs-6 text-center">KONDISI</th>
                                <th class="fs-6 text-center"><i class="bi bi-pencil-square"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no_tabel = 1;
                            foreach ($data_aset as $aset) : ?>
                                <tr>
                                    <td class=""><?= $no_tabel++ ?>
                                    </td>
                                    <td class=""><?= $aset['kode_aset'] ?>
                                    </td>
                                    <td class=""><?= $aset['nama_aset'] ?>
                                    </td>
                                    <td class=""><?= $aset['nama_kategori'] ?>
                                    </td>
                                    <td class=""><?= $aset['nama_lokasi'] ?>
                                    </td>
                                    <td class="text-center"><?= $aset['kondisi'] ?>
                                    </td>
                                    <td class="text-end">
                                        <!-- Ubah Data -->
                                        <a href="" style="color: #14Ae5c;" data-bs-toggle="modal" class="text-decoration-none" data-bs-target="#modalUbahAset<?= $aset['id_aset'] ?>">
                                            <i class="bi bi-pencil-fill me-3"></i>
                                        </a>

                                        <!-- Detail -->
                                        <a href="" style="color: #2b32b2;" data-bs-toggle="modal" data-bs-target="#modalDetailAset<?= $aset['id_aset'] ?>" class="text-decoration-none">
                                            <i class="bi bi-eye me-3"></i>
                                        </a>

                                        <!-- Hapus -->
                                        <a href="hapus-aset.php?id=<?= $aset['id_aset'] ?>" class="text-decoration-none" style="color: #f24822;" onclick="return confirm('Yakin mau hapus aset ini ?')">
                                            <i class="bi bi-trash3 me-3"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

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