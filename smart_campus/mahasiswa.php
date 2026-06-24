<?php
include "koneksi.php";

// Proteksi halaman: Jika belum login, kembali ke login
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

$pesan = "";

// 1. PROSES FITUR HAPUS DATA
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $id_hapus = mysqli_real_escape_string($conn, $_GET['id']);
    $delete = mysqli_query($conn, "DELETE FROM mahasiswa WHERE id='$id_hapus'");
    if ($delete) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='mahasiswa.php';</script>";
        exit();
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal menghapus data: " . mysqli_error($conn) . "</div>";
    }
}

// 2. PROSES FITUR TAMBAH DATA (INPUT)
if (isset($_POST['simpan'])) {
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $angkatan = mysqli_real_escape_string($conn, $_POST['angkatan']);

    $cek_nim = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim'");
    if (mysqli_num_rows($cek_nim) > 0) {
        $pesan = "<div class='alert alert-danger'>Gagal: NIM sudah terdaftar!</div>";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO mahasiswa (nim, nama, jurusan, angkatan) VALUES ('$nim', '$nama', '$jurusan', '$angkatan')");
        if ($insert) {
            // Menggunakan JavaScript redirect agar halaman refresh otomatis dan tabel langsung ter-update
            echo "<script>alert('Data mahasiswa berhasil ditambahkan!'); window.location.href='mahasiswa.php';</script>";
            exit();
        } else {
            $pesan = "<div class='alert alert-danger'>Gagal menyimpan data: " . mysqli_error($conn) . "</div>";
        }
    }
}

// 3. PROSES FITUR UBAH DATA (UPDATE)
if (isset($_POST['update'])) {
    $id_update = mysqli_real_escape_string($conn, $_POST['id']);
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $angkatan = mysqli_real_escape_string($conn, $_POST['angkatan']);

    $update = mysqli_query($conn, "UPDATE mahasiswa SET nim='$nim', nama='$nama', jurusan='$jurusan', angkatan='$angkatan' WHERE id='$id_update'");
    if ($update) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='mahasiswa.php';</script>";
        exit();
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal memperbarui data: " . mysqli_error($conn) . "</div>";
    }
}

// AMBIL DATA MAHASISWA UNTUK ISI FORM EDIT (Jika user klik tombol Edit)
$is_edit = false;
$data_edit = ['id' => '', 'nim' => '', 'nama' => '', 'jurusan' => '', 'angkatan' => ''];
if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit' && isset($_GET['id'])) {
    $id_edit = mysqli_real_escape_string($conn, $_GET['id']);
    $query_edit = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id='$id_edit'");
    if (mysqli_num_rows($query_edit) > 0) {
        $data_edit = mysqli_fetch_assoc($query_edit);
        $is_edit = true;
    }
}

// Ambil semua data mahasiswa untuk ditampilkan di tabel
$query_tampil = mysqli_query($conn, "SELECT * FROM mahasiswa");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Data Mahasiswa</title>
</head>
<body>
    <?php include "navbar.php"; ?>
    
    <div class="container mt-5 mb-5">
        <?php echo $pesan; ?>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow p-4">
                    <h4 class="mb-3"><?php echo $is_edit ? "Edit Mahasiswa" : "Input Mahasiswa"; ?></h4>
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $data_edit['id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" name="nim" class="form-control" value="<?php echo $data_edit['nim']; ?>" placeholder="Masukkan NIM" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo $data_edit['nama']; ?>" placeholder="Masukkan Nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" value="<?php echo $data_edit['jurusan']; ?>" placeholder="Masukkan Jurusan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Angkatan</label>
                            <input type="number" name="angkatan" class="form-control" value="<?php echo $data_edit['angkatan']; ?>" placeholder="Contoh: 2024" required>
                        </div>
                        
                        <?php if ($is_edit): ?>
                            <div class="d-flex gap-2">
                                <a href="mahasiswa.php" class="btn btn-secondary w-50">Batal</a>
                                <button type="submit" name="update" class="btn btn-warning w-50">Update Data</button>
                            </div>
                        <?php else: ?>
                            <button type="submit" name="simpan" class="w-100 btn btn-success">Simpan Data</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow p-4">
                    <h4 class="mb-3">Daftar Mahasiswa</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover border">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Jurusan</th>
                                    <th>Angkatan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                if(mysqli_num_rows($query_tampil) > 0) {
                                    while($data = mysqli_fetch_assoc($query_tampil)) {
                                        echo "<tr>";
                                        echo "<td>".$no++."</td>";
                                        // Dipastikan memanggil dengan huruf kecil sesuai field database kamu
                                        echo "<td>".$data['nim']."</td>";
                                        echo "<td>".$data['nama']."</td>";
                                        echo "<td>".$data['jurusan']."</td>";
                                        echo "<td>".$data['angkatan']."</td>";
                                        echo "<td class='text-center'>
                                                <a href='mahasiswa.php?aksi=edit&id=".$data['id']."' class='btn btn-warning btn-sm me-1'>Edit</a>
                                                <a href='mahasiswa.php?aksi=hapus&id=".$data['id']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>Belum ada data mahasiswa.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>