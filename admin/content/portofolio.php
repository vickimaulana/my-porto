<?php
// Koneksi
include 'koneksi.php';

// Hapus data portofolio
if (isset($_GET['del'])) {
    $id = intval($_GET['del']);

    // Ambil data gambar
    $stmt = mysqli_prepare($koneksi, "SELECT image FROM portofolios WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $filePath = __DIR__ . "/../uploads/" . $row['image'];
        if (!empty($row['image']) && file_exists($filePath)) {
            unlink($filePath);
        }
    }
    mysqli_stmt_close($stmt);

    // Hapus data portofolio
    $stmt = mysqli_prepare($koneksi, "DELETE FROM portofolios WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: ?page=portofolio&msg=deleted");
    exit;
}

// Ambil semua data
$portofolios = mysqli_query($koneksi, "SELECT * FROM portofolios ORDER BY id DESC");

// Kalau query gagal → tampilkan pesan error
if (!$portofolios) {
    die("Query error: " . mysqli_error($koneksi));
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Manajemen Portofolio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4"> Manajemen portofolio</h1>

        <!-- Notifikasi -->
        <?php if (!empty($_GET['msg'])): ?>
            <?php if ($_GET['msg'] === 'deleted'): ?>
                <div class="alert alert-success">✅ Data berhasil dihapus!</div>
            <?php elseif ($_GET['msg'] === 'added'): ?>
                <div class="alert alert-success">✅ Data berhasil ditambahkan!</div>
            <?php elseif ($_GET['msg'] === 'updated'): ?>
                <div class="alert alert-info">✏ Data berhasil diupdate!</div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Tombol tambah -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="?page=tambah-portofolio" class="btn btn-primary">+ Tambah Portofolio</a>
        </div>

        <!-- Tabel portofolio -->
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Tags</th>
                        <th>Link</th>
                        <th style="width:200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    if (mysqli_num_rows($portofolios) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($portofolios)): ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <td class="text-center">
                                    <?php if (!empty($row['image']) && file_exists(__DIR__ . "/../uploads/" . $row['image'])): ?>
                                        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="img-thumbnail" style="height:50px">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td class="text-capitalize"><?= htmlspecialchars($row['category']) ?></td>
                                <td>
                                    <?php if (!empty($row['tags'])): ?>
                                        <?php foreach (explode(',', $row['tags']) as $tag): ?>
                                            <span class="badge bg-info text-dark"><?= htmlspecialchars(trim($tag)) ?></span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($row['link'])): ?>
                                        <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">🔗 Lihat</a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="?page=tambah-portofolio&edit=<?= intval($row['id']) ?>" class="btn btn-success btn-sm">✏ Edit</a>
                                    <a href="?page=portofolio&del=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">🗑 Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data portofolio</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>