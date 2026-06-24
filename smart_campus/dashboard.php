<?php
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card shadow dashboard-card">
                    <div class="card-body text-center">
                        <h3>Mahasiswa</h3>
                        <h1>150</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow dashboard-card">
                    <div class="card-body text-center">
                        <h3>Dosen</h3>
                        <h1>35</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow dashboard-card">
                    <div class="card-body text-center">
                        <h3>Mata Kuliah</h3>
                        <h1>25</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>