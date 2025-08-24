<?php
include 'koneksi.php';

// Cek mode edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM Portofolios WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $editData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// Proses simpan/update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $link = $_POST['link'];

    // Upload gambar
    $fileName = $editData['image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . "/../uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $target = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // hapus gambar lama
            if ($id > 0 && !empty($editData['image']) && file_exists($uploadDir . $editData['image'])) {
                unlink($uploadDir . $editData['image']);
            }
        }
    }

    if ($id > 0) {
        // update
        $stmt = mysqli_prepare($koneksi, "UPDATE Portofolios SET title=?, description=?, category=?, tags=?, link=?, image=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $title, $description, $category, $tags, $link, $fileName, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: ?page=portofolio&msg=updated");
        exit;
    } else {
        // insert
        $stmt = mysqli_prepare($koneksi, "INSERT INTO Portofolios (title, description, category, tags, link, image) VALUES (?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $title, $description, $category, $tags, $link, $fileName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: ?page=portofolio&msg=added");
        exit;
    }
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title><?= $editData ? "Edit" : "Tambah" ?> Portofolio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4"><?= $editData ? "✏ Edit" : "+ Tambah" ?> Portofolio</h1>

        <form method="post" enctype="multipart/form-data" class="card p-3 shadow-sm">
            <?php if ($editData): ?>
                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="title" class="form-control" required
                    value="<?= htmlspecialchars($editData['title'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control"
                    required><?= htmlspecialchars($editData['description'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="web" <?= ($editData['category'] ?? '') === 'web' ? 'selected' : '' ?>>Web</option>
                    <option value="bisnis" <?= ($editData['category'] ?? '') === 'bisnis' ? 'selected' : '' ?>>Bisnis</option>
                    <option value="design" <?= ($editData['category'] ?? '') === 'design' ? 'selected' : '' ?>>Design</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Tags (pisahkan dengan koma)</label>
                <input type="text" name="tags" class="form-control" value="<?= htmlspecialchars($editData['tags'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label>Link</label>
                <input type="url" name="link" class="form-control" value="<?= htmlspecialchars($editData['link'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label>Gambar</label>
                <?php if (!empty($editData['image'])): ?>
                    <div class="mb-2">
                        <img src="uploads/<?= htmlspecialchars($editData['image']) ?>" style="height:60px">
                    </div>
                <?php endif; ?>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary"><?= $editData ? "Update" : "Simpan" ?></button>
            <a href="?page=portofolio" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>