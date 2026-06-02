<?php
require 'modul/database.php'; // Koneksi database lu

// Ambil token dari URL
$token = isset($_GET['token']) ? mysqli_real_escape_string($db_connect, $_GET['token']) : '';

// 1. Cek apakah token ada di database dan belum kadaluwarsa (opsional)
$query = "SELECT email FROM password_resets WHERE token = '$token'";
$result = mysqli_query($db_connect, $query);

if (mysqli_num_rows($result) === 0) {
    // Jika token tidak ditemukan
    die("Token tidak valid atau sudah kadaluwarsa. Silakan minta reset password kembali.");
}

// 2. Jika form ganti password disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password_baru = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi sederhana: apakah password cocok?
    if ($password_baru !== $confirm_password) {
        $error = "Password tidak sama!";
    } else {
        // Hash password
        $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
        $data = mysqli_fetch_assoc($result);
        $email = $data['email'];

        // Update password user
        mysqli_query($db_connect, "UPDATE user SET password = '$hashed_password' WHERE email = '$email'");

        // Hapus token supaya tidak bisa dipakai lagi (One-time use)
        mysqli_query($db_connect, "DELETE FROM password_resets WHERE token = '$token'");

        echo "<script>alert('Password berhasil diubah! Silakan login.'); window.location='index.php';</script>";
        exit;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Password</title>
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
                            <form method="POST">
                                <h3>Reset Password</h3>
                                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                                <div class="mb-4">
                                    <input type="password" name="password" required class="form-control mt-3 py-2 px-3" id="password" placeholder="Masukkan Password Baru" required>
                                </div>
                                <div class="mb-4">
                                    <input type="password" name="confirm_password" required class="form-control mt-3 py-2 px-3" id="confirm_password" placeholder="Konfirmasi Password Baru" required>
                                </div>
                                <button type="submit" name="login" class="btn btn-primary py-3 w-100 fw-bold" style="background-color: #3A4CCB; margin-top: 12px;">Update Password</button>
                            </form>
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