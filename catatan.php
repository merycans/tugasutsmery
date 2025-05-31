<?php 
session_start();
include 'config/koneksi.php';

$keyword = isset($_GET['keyword']) ? $conn->real_escape_string($_GET['keyword']) : '';

$sql = "SELECT * FROM catatan";
if ($keyword !== '') {
    $sql .= " WHERE 
        tanggal LIKE '%$keyword%' OR
        subuh LIKE '%$keyword%' OR
        dzuhur LIKE '%$keyword%' OR
        ashar LIKE '%$keyword%' OR
        maghrib LIKE '%$keyword%' OR
        isya LIKE '%$keyword%' OR
        keterangan LIKE '%$keyword%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Catatan Ibadah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background: #f4f6fb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
    }

    h2 {
      color: #4b3f72;
      font-weight: 600;
      margin-bottom: 20px;
      text-align: center;
    }

    .navbar {
      background: linear-gradient(90deg, #3b2c85, #6f42c1);
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 1.4rem;
    }

    .btn-success {
      background-color: #6f42c1;
      border: none;
    }

    .btn-success:hover {
      background-color: #5b33a3;
    }

    .btn-warning {
      background-color: #ffc107;
      border: none;
    }

    .btn-warning:hover {
      background-color: #e0a800;
    }

    .btn-danger {
      background-color: #dc3545;
      border: none;
    }

    .btn-danger:hover {
      background-color: #b02a37;
    }

    .btn-outline-light {
      border-color: #fff;
      color: #fff;
    }

    .btn-outline-light:hover {
      background-color: #fff;
      color: #3b2c85;
    }

    .btn-outline-warning:hover {
      background-color: #ffc107;
      color: #000;
    }

    .table thead {
      background-color: #3b2c85;
      color: #fff;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: #f9f9fb;
    }

    .table-striped tbody tr:hover {
      background-color: #e9e6f0;
    }

    .form-control:focus {
      border-color: #6f42c1;
      box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
    }

    .container {
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Waktu Shalat</a>
    <form class="d-flex ms-auto" method="GET" action="catatan.php">
      <input class="form-control me-2" type="search" name="keyword" placeholder="Cari catatan" aria-label="Search" value="<?= htmlspecialchars($keyword) ?>">
      <button class="btn btn-outline-light me-2" type="submit">Cari</button>
      <?php if ($keyword !== ''): ?>
        <a href="catatan.php" class="btn btn-outline-warning">Reset</a>
      <?php endif; ?>
    </form>
  </div>
</nav>

<?php if (isset($_SESSION['pesan'])): ?>
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '<?= $_SESSION['pesan'] ?>',
    showConfirmButton: false,
    timer: 2000
  });
</script>
<?php unset($_SESSION['pesan']); ?>
<?php endif; ?>

<div class="container mt-4">
  <h2>Catatan Ibadah Harian</h2>
  <a href="tambah_catatan.php" class="btn btn-success mb-3">+ Tambah Catatan</a>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Subuh</th>
        <th>Dzuhur</th>
        <th>Ashar</th>
        <th>Maghrib</th>
        <th>Isya</th>
        <th>Keterangan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result && $result->num_rows > 0) {
          $no = 1;
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                <td>" . $no++ . "</td>
                <td>" . htmlspecialchars($row['tanggal']) . "</td>
                <td>" . htmlspecialchars($row['subuh']) . "</td>
                <td>" . htmlspecialchars($row['dzuhur']) . "</td>
                <td>" . htmlspecialchars($row['ashar']) . "</td>
                <td>" . htmlspecialchars($row['maghrib']) . "</td>
                <td>" . htmlspecialchars($row['isya']) . "</td>
                <td>" . htmlspecialchars($row['keterangan']) . "</td>
                <td>
                  <a href='edit_catatan.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                  <button onclick='hapusData(" . $row['id'] . ")' class='btn btn-danger btn-sm'>Hapus</button>
                </td>
              </tr>";
          }
      } else {
          echo "<tr><td colspan='9' class='text-center text-muted'>Data tidak ditemukan</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<script>
function hapusData(id) {
  Swal.fire({
    title: 'Yakin ingin menghapus data?',
    text: "Data yang sudah dihapus tidak bisa dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'hapus_catatan.php?id=' + id;
    }
  });
}

// Tampilkan alert jika status ada di URL (opsional tambahan jika tidak pakai session)
document.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');

  if (status === 'success') {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: 'Catatan berhasil disimpan',
      timer: 1500,
      showConfirmButton: false
    });
  } else if (status === 'error') {
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: 'Terjadi kesalahan saat menyimpan data',
    });
  }
});
</script>
</body>
</html>
