<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Waktu Shalat Hari Ini</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Waktu Shalat</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link active" href="index.php">Beranda</a></li>
      <li class="nav-item"><a class="nav-link" href="catatan.php">Catatan Ibadah</a></li>
    </ul>
  </div>
</nav>

<div class="container mt-5">
  <div class="card p-4 shadow rounded">
    <h3 class="mb-4 text-center">Waktu Shalat Hari Ini</h3>
    <table class="table table-striped">
      <tr><th>Subuh</th><td>04:32</td></tr>
      <tr><th>Dzuhur</th><td>12:03</td></tr>
      <tr><th>Ashar</th><td>15:23</td></tr>
      <tr><th>Maghrib</th><td>17:52</td></tr>
      <tr><th>Isya</th><td>19:02</td></tr>
    </table>
  </div>
</div>
</body>
</html>
