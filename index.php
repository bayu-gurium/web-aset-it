<!-- Logic -->

<?php

require 'vendor/autoload.php'; // Penting!
require './modul/database.php';

use PHPMailer\PHPMailer\PHPMailer;

session_start();
require './modul/fuctions.php';
// cek session
if (isset($_SESSION['login'])) {
    header("Location: dashboard.php"); // Tendang balik ke login kalau belum masuk
    exit;
}

// cek jika tombol login ditekan
if (isset($_POST['login'])) {

    // ambil username dan password
    $username = mysqli_real_escape_string($db_connect, $_POST['username']);
    $password = $_POST['password'];

    // query cek data ke tabel user
    $query = mysqli_query($db_connect, "SELECT * FROM user WHERE username = '$username'");
    // cek apakah usernamenya sesuai datau tidak
    if (mysqli_num_rows($query) > 0) {

        // cek ketersediaan data user
        $user = mysqli_fetch_assoc($query);

        // cek apakah passwordnya sesuai atau tidak
        if (password_verify($password, $user['password'])) {

            // set session dan arahkan ke halaman dashbaord jika username dan password benar
            $_SESSION['login'] = true;
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            header('location: dashboard.php');
        } else {
            // jika password tidak sesuai
            $password_eror = true;
        }
    } else {
        // jika username tidak sesuai
        $username_eror = true;
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Aset IT</title>
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
                            <form class="mx-4" action="" method="post">
                                <!-- alert -->
                                <?php if (isset($username_eror) || isset($password_eror)) : ?>
                                    <div class="alert alert-danger p-2 px-2">Username / Password tidak sesuai !!</div>
                                <?php endif ?>

                                <div class="mb-4">
                                    <!-- <label for="username" class="form-label">Username</label> -->
                                    <input type="text" name="username" class="form-control p-2 px-3" id="username" placeholder="Username" required>
                                </div>
                                <div class="mb-4">
                                    <!-- <label for="password" class="form-label">Password</label> -->
                                    <input type="password" name="password" class="form-control p-2 px-3" id="password" placeholder="Password" required>
                                </div>
                                <button type="submit" name="login" class="btn btn-primary p-3 w-100 fw-bold" style="background-color: #3A4CCB; margin-top: 12px;">LOGIN</button>
                            </form>
                            <div class="form-group text-center mt-3">
                                <a href="lupa-password.php" class="text-muted">Lupa Password?</a>
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