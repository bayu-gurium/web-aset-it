<?php


require './modul/fuctions.php';
// query JOIN Data Kategori dan Lokasi dengan data Aset
$data_aset = allData("SELECT * FROM aset JOIN kategori ON aset.id_kategori = kategori.id_kategori JOIN lokasi ON aset.id_lokasi = lokasi.id_lokasi ORDER BY id_aset ASC");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Aset</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        /* Settingan Kertas Landscape saat Print */
        @media print {
            @page {
                size: landscape;
                margin: 1cm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="text-center">
        <h2>LAPORAN INVENTARIS ASET IT</h2>
        <p>Dicetak pada: <?= date('d F Y') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
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
            <?php $no = 1;
            foreach ($data_aset as $aset) : ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $aset['kode_aset'] ?></td>
                    <td><strong><?= $aset['nama_aset'] ?></strong></td>
                    <td><?= $aset['nama_kategori'] ?></td>
                    <td><?= $aset['status'] ?></td>
                    <td><?= $aset['nama_lokasi'] ?></td>
                    <td><?= $aset['kondisi'] ?></td>
                    <td><?= date('d-m-Y', strtotime($aset['tgl_perolehan'])) ?></td>
                    <td><small><?= $aset['spesifikasi'] ?></small></td>
                    <td><small><?= $aset['keterangan'] ?></small></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div class="no-print" style="margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px;">Cetak Ulang</button>
        <button onclick="window.close()" style="padding: 10px;">Tutup Halaman</button>
    </div>

</body>

</html>