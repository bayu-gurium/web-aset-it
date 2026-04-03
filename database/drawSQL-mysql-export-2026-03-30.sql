CREATE TABLE `user`(
    `id_user` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `nama_lengkap` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'staff') NOT NULL
);
CREATE TABLE `kategori`(
    `id_kategori` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nama_kategori` VARCHAR(255) NOT NULL
);
CREATE TABLE `lokasi`(
    `id_lokasi` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nama_lokasi` BIGINT NOT NULL
);
CREATE TABLE `aset`(
    `id_aset` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `kode_aset` VARCHAR(255) NOT NULL,
    `nama_aset` VARCHAR(255) NOT NULL,
    `id_kategori` INT NOT NULL,
    `spesifikasi` TEXT NOT NULL,
    `id_lokasi` INT NOT NULL,
    `kondisi` ENUM(
        'bagus',
        'rusak ringan',
        'rusak berat'
    ) NOT NULL,
    `status` ENUM('aktif', 'cadangan', 'dihapuskan') NOT NULL,
    `tgl_perolehan` DATE NOT NULL,
    `keterangan` TEXT NOT NULL,
    `foto_aset` VARCHAR(255) NOT NULL
);
ALTER TABLE
    `aset` ADD UNIQUE `aset_id_kategori_unique`(`id_kategori`);
ALTER TABLE
    `aset` ADD UNIQUE `aset_id_lokasi_unique`(`id_lokasi`);