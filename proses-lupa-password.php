<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'modul/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($db_connect, $_POST['email']);

    // 1. Cek apakah email ada
    $query = "SELECT id_user FROM user WHERE email = '$email'";
    $result = mysqli_query($db_connect, $query);

    if (mysqli_num_rows($result) > 0) {
        // 2. Generate token
        $token = bin2hex(random_bytes(32));

        // 3. Simpan ke tabel password_resets
        // Pakai query INSERT sederhana
        $insert = "INSERT INTO password_resets (email, token) VALUES ('$email', '$token')";
        mysqli_query($db_connect, $insert);

        // 4. Kirim Email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth   = true;
            $mail->Username   = '18829c17b005ba';
            $mail->Password   = '728eeab6bc3b1a';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 2525;

            $mail->setFrom('it-support@bank-aset.com', 'Admin IT Aset');
            $mail->addAddress($email);
            $mail->Subject = 'Reset Password Aset IT';

            // SESUAIKAN URL INI DENGAN PATH PROYEK LU!
            $link = "http://localhost/aset_it/proses-reset-password.php?token=" . $token;
            $mail->Body    = "Klik link ini untuk reset password: " . $link;

            $mail->send();

            $_SESSION['flash_message'] = "Link reset telah dikirim ke email Anda.";
            header("Location: info-reset-password.php");
            exit;
        } catch (Exception $e) {
            echo "Gagal kirim: {$mail->ErrorInfo}";
        }
    } else {
        echo "Jika email terdaftar, link sudah dikirim.";
    }
}
