<?php
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = trim($_POST['tanggal']);
    $subuh = trim($_POST['subuh']);
    $dzuhur = trim($_POST['dzuhur']);
    $ashar = trim($_POST['ashar']);
    $maghrib = trim($_POST['maghrib']);
    $isya = trim($_POST['isya']);
    $keterangan = trim($_POST['keterangan']);

    if ($tanggal && $subuh && $dzuhur && $ashar && $maghrib && $isya && $keterangan) {
        $stmt = $conn->prepare("INSERT INTO catatan (tanggal, subuh, dzuhur, ashar, maghrib, isya, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $tanggal, $subuh, $dzuhur, $ashar, $maghrib, $isya, $keterangan);

        if ($stmt->execute()) {
            // Redirect ke halaman catatan dengan status success
            header("Location: catatan.php?status=success");
            exit;
        } else {
            // Redirect ke halaman tambah_catatan dengan status error
            header("Location: tambah_catatan.php?status=error");
            exit;
        }
    } else {
        // Redirect ke halaman tambah_catatan dengan status empty (data kosong)
        header("Location: tambah_catatan.php?status=empty");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Tambah Catatan Ibadah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f1f4ff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h2 {
      color: #3b4cca;
      font-weight: 700;
    }
    .container {
      max-width: 600px;
      background: #fff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(59, 76, 202, 0.2);
      margin-top: 50px;
    }
    label {
      color: #2c3a99;
      font-weight: 600;
    }
    .form-control:focus {
      border-color: #3b4cca;
      box-shadow: 0 0 0 0.2rem rgba(59, 76, 202, 0.3);
    }
    .btn-primary {
      background-color: #3b4cca;
      border-color: #3b4cca;
      font-weight: 600;
    }
    .btn-primary:hover {
      background-color: #2a36a0;
      border-color: #2a36a0;
    }
    .btn-secondary {
      background-color: #6c757d;
      border-color: #6c757d;
      font-weight: 600;
    }
    .btn-secondary:hover {
      background-color: #5a6268;
      border-color: #545b62;
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <h2>Tambah Catatan Ibadah</h2>
  <a href="catatan.php" class="btn btn-secondary mb-3">← Kembali ke Catatan</a>

  <form id="formTambah" method="POST" action="tambah_catatan.php" onsubmit="return validasiForm()">
    <div class="mb-3">
      <label for="tanggal" class="form-label">Tanggal</label>
      <input type="date" class="form-control" id="tanggal" name="tanggal" />
    </div>
    <div class="mb-3">
      <label for="subuh" class="form-label">Waktu Subuh</label>
      <input type="time" class="form-control" id="subuh" name="subuh" />
    </div>
    <div class="mb-3">
      <label for="dzuhur" class="form-label">Waktu Dzuhur</label>
      <input type="time" class="form-control" id="dzuhur" name="dzuhur" />
    </div>
    <div class="mb-3">
      <label for="ashar" class="form-label">Waktu Ashar</label>
      <input type="time" class="form-control" id="ashar" name="ashar" />
    </div>
    <div class="mb-3">
      <label for="maghrib" class="form-label">Waktu Maghrib</label>
      <input type="time" class="form-control" id="maghrib" name="maghrib" />
    </div>
    <div class="mb-3">
      <label for="isya" class="form-label">Waktu Isya</label>
      <input type="time" class="form-control" id="isya" name="isya" />
    </div>
    <div class="mb-3">
      <label for="keterangan" class="form-label">Keterangan</label>
      <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="catatan.php" class="btn btn-secondary">Batal</a>
  </form>
</div>

<script>
function validasiForm() {
  const fields = ['tanggal', 'subuh', 'dzuhur', 'ashar', 'maghrib', 'isya', 'keterangan'];
  for (let field of fields) {
    let val = document.getElementById(field).value.trim();
    if (!val) {
      Swal.fire({
        icon: 'error',
        title: 'Form Tidak Lengkap',
        text: `Field ${field.charAt(0).toUpperCase() + field.slice(1)} harus diisi!`
      });
      return false;
    }
  }
  return true;
}

// Cek parameter status untuk alert
document.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  if (status === 'empty') {
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: 'Semua field harus diisi!'
    });
  } else if (status === 'error') {
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: 'Terjadi kesalahan saat menyimpan data!'
    });
  }
});
</script>

</body>
</html>
