<?php
include "koneksi.php"; // Memanggil koneksi dan session di paling atas

$error_message = "";

if (isset($_POST['login'])) {
    // Menggunakan huruf kecil dan mengamankan string input
    $u = mysqli_real_escape_string($conn, $_POST['Username']);
    $p = mysqli_real_escape_string($conn, $_POST['Password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE Username='$u' AND Password='$p'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $_SESSION['login'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Login Gagal! Username atau Password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Smart Campus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card shadow-lg p-4 login-box">
                    <h2 class="text-center mb-4">SMART CAMPUS</h2>
                    <form method="post">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="Username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="Password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
                    </form>

                    <?php if (!empty($error_message)): ?>
                        <div class='alert alert-danger mt-3'><?php echo $error_message; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>