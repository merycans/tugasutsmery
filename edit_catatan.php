<?php
session_start();
include 'config/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: catatan.php");
    exit;
}

$id = (int)$_GET['id'];

// Ambil data lama
$result = $conn->query("SELECT * FROM catatan WHERE id = $id");
$data = $result->fetch_assoc();

if (!$data) {
    $_SESSION['pesan'] = "Data tidak ditemukan";
    header("Location: catatan.php");
    exit;
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = trim($_POST['tanggal']);
    $subuh = trim($_POST['subuh']);
    $dzuhur = trim($_POST['dzuhur']);
    $ashar = trim($_POST['ashar']);
    $maghrib = trim($_POST['maghrib']);
    $isya = trim($_POST['isya']);
    $keterangan = trim($_POST['keterangan']);

    if ($tanggal && $subuh && $dzuhur && $ashar && $maghrib && $isya && $keterangan) {
        $stmt = $conn->prepare("UPDATE catatan SET tanggal=?, subuh=?, dzuhur=?, ashar=?, maghrib=?, isya=?, keterangan=? WHERE id=?");
        $stmt->bind_param("sssssssi", $tanggal, $subuh, $dzuhur, $ashar, $maghrib, $isya, $keterangan, $id);
        $stmt->execute();

        $_SESSION['pesan'] = "Data berhasil diperbarui";
        header("Location: catatan.php");
        exit;
    } else {
        $error = "Semua field harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Catatan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
  <h2>Edit Catatan Ibadah</h2>

  <?php if (!empty($error)) : ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '<?= $error ?>'
      });
    </script>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label for="tanggal" class="form-label">Tanggal</label>
      <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= htmlspecialchars($data['tanggal']) ?>">
    </div>
    <div class="mb-3">
      <label for="subuh" class="form-label">Waktu Subuh</label>
      <input type="time" class="form-control" id="subuh" name="subuh" value="<?= htmlspecialchars($data['subuh']) ?>">
    </div>
    <div class="mb-3">
      <label for="dzuhur" class="form-label">Waktu Dzuhur</label>
      <input type="time" class="form-control" id="dzuhur" name="dzuhur" value="<?= htmlspecialchars($data['dzuhur']) ?>">
    </div>
    <div class="mb-3">
      <label for="ashar" class="form-label">Waktu Ashar</label>
      <input type="time" class="form-control" id="ashar" name="ashar" value="<?= htmlspecialchars($data['ashar']) ?>">
    </div>
    <div class="mb-3">
      <label for="maghrib" class="form-label">Waktu Maghrib</label>
      <input type="time" class="form-control" id="maghrib" name="maghrib" value="<?= htmlspecialchars($data['maghrib']) ?>">
    </div>
    <div class="mb-3">
      <label for="isya" class="form-label">Waktu Isya</label>
      <input type="time" class="form-control" id="isya" name="isya" value="<?= htmlspecialchars($data['isya']) ?>">
    </div>
    <div class="mb-3">
      <label for="keterangan" class="form-label">Keterangan</label>
      <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= htmlspecialchars($data['keterangan']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="catatan.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
</body>
</html>
