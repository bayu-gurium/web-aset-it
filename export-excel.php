<?php
// Koneksi ke database ente
require './modul/fuctions.php';
// Ambil data aset (Query yang sama dengan di halaman laporan)
$data_aset = allData("SELECT * FROM aset JOIN kategori ON aset.id_kategori = kategori.id_kategori JOIN lokasi ON aset.id_lokasi = lokasi.id_lokasi ORDER BY id_aset ASC");


// Perintah Header untuk 'menipu' browser agar mendownload sebagai Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Aset_IT_" . date('d-m-Y') . ".xls");
?>

<center>
    <h2>LAPORAN DATA ASET IT</h2>
    <hr>
</center>
<table border="1">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>No</th>
            <th>Kode Aset</th>
            <th>Nama Aset</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Lokasi</th>
            <th>Kondisi</th>
            <th>Tgl Perolehan</th>
            <th>Spesifikasi</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($data_aset as $aset) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $aset['kode_aset'] ?></td>
                <td><?= $aset['nama_aset'] ?></td>
                <td><?= $aset['nama_kategori'] ?></td>
                <td><?= $aset['status'] ?></td>
                <td><?= $aset['nama_lokasi'] ?></td>
                <td><?= $aset['kondisi'] ?></td>
                <td><?= $aset['tgl_perolehan'] ?></td>
                <td><?= $aset['spesifikasi'] ?></td>
                <td><?= $aset['keterangan'] ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>