<?php

require 'database.php';

// tampilkan semu data]
function allData($query)
{
    global $db_connect;

    $result = mysqli_query($db_connect, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {

        $rows[] = $row;
    }
    return $rows;
}

// Tambah Lokasi
function tambahLokasi($data)
{
    global $db_connect;
    // get data nama lokasi
    $nama_lokasi = htmlspecialchars($data['nama_lokasi']);
    // query tambahkan ke tabel lokasi
    mysqli_query($db_connect, "INSERT INTO lokasi VALUES('', '$nama_lokasi')");
    mysqli_affected_rows($db_connect);
}
// Ubah LOkasi
function ubahLokasi($data)
{
    global $db_connect;
    // get data nama lokasi
    $nama_lokasi = htmlspecialchars($data['nama_lokasi']);
    $id_lokasi = $data['id_lokasi'];
    // query tambahkan ke tabel lokasi
    mysqli_query($db_connect, "UPDATE lokasi SET nama_lokasi = '$nama_lokasi' WHERE id_lokasi = $id_lokasi ");
    mysqli_affected_rows($db_connect);
}
// Hapus lokasi
function hapusLokasi($id_lokasi)
{

    global $db_connect;

    // query hapus data lokasi
    mysqli_query($db_connect, "DELETE FROM lokasi WHERE id_lokasi = $id_lokasi");

    return mysqli_affected_rows($db_connect);
}
// -----------------------------------

// Tambah Kategori
function tambahKategori($data)
{
    global $db_connect;
    // get data nama kategori
    $nama_kategori = htmlspecialchars($data['nama_kategori']);
    // queri insert/tambahkan ke tabel kategori
    mysqli_query($db_connect, "INSERT INTO kategori VALUES('', '$nama_kategori')");
    return mysqli_affected_rows($db_connect);
}
// Ubah Kategori
function ubahKategori($data)
{
    global $db_connect;
    // get data nama lokasi
    $nama_kategori = htmlspecialchars($data['nama_kategori']);
    $id_kategori = $data['id_kategori'];
    // query tambahkan ke tabel kategori
    mysqli_query($db_connect, "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id_kategori = $id_kategori ");
    mysqli_affected_rows($db_connect);
}
// Hapus Kategori
function hapusKategori($id_kategori)
{

    global $db_connect;

    // query hapus data kategori
    mysqli_query($db_connect, "DELETE FROM kategori WHERE id_kategori = $id_kategori");

    return mysqli_affected_rows($db_connect);
}
// -----------------------------------

// Tambah PENDATAAN
function tambahDataPendataan($data)
{

    global $db_connect;

    // get data form
    $kode_aset = htmlspecialchars($data['kode_aset']);
    $nama_aset = htmlspecialchars($data['nama_aset']);
    $id_kategori = $data['id_kategori'];
    $spesifikasi = htmlspecialchars($data['spesifikasi']);
    $id_lokasi = $data['id_lokasi'];
    $kondisi = $data['kondisi'];
    $status = $data['status'];
    $tgl_perolehan = $data['tgl_perolehan'];
    $keterangan = htmlspecialchars($data['keterangan']);

    $foto_aset = uploadFotoAset();
    if (!$foto_aset) {
        return false;
    }

    $query_data =  "INSERT INTO aset VALUES ('', '$kode_aset', '$nama_aset', '$id_kategori', '$spesifikasi', '$id_lokasi','$kondisi', '$status', '$tgl_perolehan', '$keterangan', '$foto_aset')";
    mysqli_query($db_connect, $query_data);

    return mysqli_affected_rows($db_connect);
}
// Fungsi Upload Foto Aset
function uploadFotoAset()
{

    // properti files
    $name = $_FILES['foto_aset']['name'];
    $ukuran = $_FILES['foto_aset']['size'];
    $error = $_FILES['foto_aset']['error'];
    $folder = $_FILES['foto_aset']['tmp_name'];

    // Cek jika tidak ada gambar yang diupload
    if ($error === 4) {
        // echo "<script>
        //         alert('Silahkan Upload Foto Aset !')
        //       </script>";
        return 'default.jpg';
    }

    // cek Ekstensi gambar

    $ekstensiSistem = ['png', 'jpg', 'jpeg'];
    $ekstensiGambar = explode('.', $name);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    // validasi ekstensi gambar yang diupload
    if (!in_array($ekstensiGambar, $ekstensiSistem)) {
        echo "<script>
                alert('Ekstensi Gambar yang disarankan (JPG, JPEG, PNG)')
              </script>";
        return false;
    }

    // Cek ukuran gambar yang diupload
    if ($ukuran > 5000000) { // 5MB
        echo "<script>
                alert('Ukuran Gambar terlalu besar - Max: (5MB)')
              </script>";
        return false;
    }

    // Berikan nama file yang unik
    $namaBaru = uniqid() . '.' . $ekstensiGambar;

    // Simpan gambar ke folder tujuan
    if (move_uploaded_file($folder, './assets/img/foto-aset/' . $namaBaru)) {
        return $namaBaru;
    } else {
        echo "<script>
                alert('Gagal mengupload gambar')
              </script>";
        return false;
    }
}

// Fungsi Edit/Update Data Aset
function updateDaatAset($data)
{
    global $db_connect;

    // get data form
    $kode_aset = htmlspecialchars($data['kode_aset']);
    $nama_aset = htmlspecialchars($data['nama_aset']);
    $id_kategori = $data['id_kategori'];
    $spesifikasi = htmlspecialchars($data['spesifikasi']);
    $id_lokasi = $data['id_lokasi'];
    $kondisi = $data['kondisi'];
    $status = $data['status'];
    $tgl_perolehan = $data['tgl_perolehan'];
    $keterangan = htmlspecialchars($data['keterangan']);
    $id_aset = $data['id_aset'];
    $old_foto = $data['old_foto'];

    if ($_FILES['foto_aset']['error'] == 4) {
        $foto_aset = $old_foto;
    } else {
        // cek nama foto yang ada di dalam folder 
        if (file_exists("./assets/img/foto-aset/" . $old_foto)) {
            // hapus foto yang lama
            unlink("./assets/img/foto-aset/" . $old_foto);
        }

        $foto_aset = uploadFotoAset();
    }

    $query_data =  "UPDATE aset SET
                                    kode_aset = '$kode_aset',
                                    nama_aset = '$nama_aset',
                                    id_kategori = '$id_kategori',
                                    spesifikasi = '$spesifikasi',
                                    id_lokasi = '$id_lokasi',
                                    kondisi = '$kondisi',
                                    status = '$status',
                                    tgl_perolehan = '$tgl_perolehan',
                                    keterangan = '$keterangan',
                                    foto_aset = '$foto_aset' WHERE id_aset = $id_aset";
    mysqli_query($db_connect, $query_data);

    return mysqli_affected_rows($db_connect);
}

// Fungsi Hapus Data Aset
function hapusAset($id_aset)
{

    global $db_connect;

    // Ambi Nama FILE
    $query_data = mysqli_query($db_connect, "SELECT foto_aset FROM aset WHERE id_aset = $id_aset");
    $data = mysqli_fetch_array($query_data);
    $nama_foto = $data['foto_aset'];

    // 2. CEK & HAPUS FILE: Jangan hapus kalau itu 'default.jpg'!
    if ($nama_foto != 'default.jpg') {
        $path = "./assets/img/foto-aset/" . $nama_foto;

        // Cek apakah file beneran ada di folder sebelum di-unlink
        if (file_exists($path)) {
            unlink($path); // Ini eksekusi "buang sampah"-nya, Bray!
        }
    }

    mysqli_query($db_connect, "DELETE FROM aset WHERE id_aset = $id_aset");
    return mysqli_affected_rows($db_connect);
}
// -----------------------------------