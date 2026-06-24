<?php
// Membuat koneksi ke database smart_campus
$conn = mysqli_connect("localhost", "root", "", "smart_campus");

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

// Menjalankan session dengan aman agar tidak bentrok atau ganda
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>