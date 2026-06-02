<!-- Logic -->

<?php

require 'vendor/autoload.php'; // Penting!
require 'modul/database.php';

use PHPMailer\PHPMailer\PHPMailer;


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- link css -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="login-body">
    <div class=" container">
        <!-- main code -->
        <div class="row justify-content-center align-items-center" style="height: 85vh;">
            <div class="col-lg-9">
                <div class="card border-0 m-4 m-lg-0 shadow-sm" style="background-color: #E4E5EA;">
                    <div class="row align-items-center">
                        <div class="col-lg-6 p-5">
                            <div class="container">
                                <div class="alert alert-warning fw-bold">Cek Email Anda untuk tautan reset password.</div>
                                <small>Kami telah mengirimkan tautan untuk mereset password Anda.</small>
                                <small>Jika tidak menerima email, silakan periksa folder spam atau pastikan email yang dimasukkan benar.</small>
                                <br>
                                <a href="index.php" name="login" class="btn btn-primary  w-100 fw-bold" style="background-color: #3A4CCB; margin-top: 12px;">Kembali Ke Halaman Login</a>
                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-block p-0">
                            <div class="login-image"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end main code -->

        <!-- footer -->

        <footer class="text-center text-secondary">
            <small>&copy; Copy Right 2025.</small>
            <p>Website Created with ⚡ by <a href="">Afi</a></p>
        </footer>
        <!-- end footer -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
<!--  -->