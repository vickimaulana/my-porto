<?php
// Ambil ID jika ada (edit / delete)
$id        = $_GET['edit'] ?? '';
$judulPage = $id ? "Edit Service" : "Tambah Service";

// Jika edit → ambil data lama
$rowEdit = [];
if ($id) {
    $query   = mysqli_query($koneksi, "SELECT * FROM services WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
}

// Jika delete → hapus data
if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $delete   = mysqli_query($koneksi, "DELETE FROM services WHERE id='$idDelete'");
    if ($delete) {
        header("location:?page=service&hapus=berhasil");
        exit;
    }
}

// Jika simpan (insert / update)
if (isset($_POST['simpan'])) {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $link        = $_POST['link'];

    // default icon pakai data lama kalau edit
    $icon = $rowEdit['icon'] ?? '';

    // jika ada upload file baru
    if (!empty($_FILES['icon_file']['name'])) {
        $uploadDir = "uploads/services/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "-" . basename($_FILES['icon_file']['name']);
        $target   = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['icon_file']['tmp_name'], $target)) {
            // hapus file lama kalau ada dan berbeda
            if (!empty($rowEdit['icon']) && file_exists($uploadDir . $rowEdit['icon'])) {
                unlink($uploadDir . $rowEdit['icon']);
            }
            $icon = $fileName;
        }
    }

    if ($id) {
        // Update data
        $update = mysqli_query($koneksi, "
            UPDATE services SET 
                title='$title',
                icon='$icon',
                description='$description',
                link='$link'
            WHERE id='$id'
        ");
        if ($update) {
            header("location:?page=service&ubah=berhasil");
            exit;
        }
    } else {
        // Insert data baru
        $insert = mysqli_query($koneksi, "
            INSERT INTO services (title, icon, description, link) 
            VALUES ('$title', '$icon', '$description', '$link')
        ");
        if ($insert) {
            header("location:?page=service&tambah=berhasil");
            exit;
        }
    }
}
?>

<div class="pagetitle">
    <h1><?= $judulPage ?></h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $judulPage ?></h5>

                    <!-- form perlu enctype multipart -->
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Judul Service</label>
                            <input type="text" class="form-control" name="title" required 
                                   value="<?= $rowEdit['title'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label>Icon (Upload Gambar)</label>
                            <input type="file" class="form-control" name="icon_file" accept="image/*">
                            <?php if (!empty($rowEdit['icon'])): ?>
                                <div class="mt-2">
                                    <img src="uploads/services/<?= $rowEdit['icon'] ?>" alt="icon" width="80">
                                </div>
                            <?php endif; ?>
                            <small class="text-muted">Format: JPG, PNG, SVG. Ukuran disarankan kecil (max 2MB).</small>
                        </div>

                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="description" id="summernote" rows="5" class="form-control"><?= $rowEdit['description'] ?? '' ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Link (Opsional)</label>
                            <input type="text" class="form-control" name="link" 
                                   value="<?= $rowEdit['link'] ?? '' ?>" 
                                   placeholder="https://contoh.com">
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=service" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
