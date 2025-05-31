<?php
include 'config/koneksi.php';  // Sesuaikan path dengan file koneksi.php

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $sql = "DELETE FROM catatan WHERE id=$id";
    $success = $conn->query($sql);

} else {
    header("Location: catatan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Hapus Data</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if ($success): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil dihapus',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = 'catatan.php';
        });
    <?php else: ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Terjadi kesalahan saat menghapus data'
        }).then(() => {
            window.location.href = 'catatan.php';
        });
    <?php endif; ?>
});
</script>

</body>
</html>
