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