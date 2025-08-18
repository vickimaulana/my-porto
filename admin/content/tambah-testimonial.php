<?php
// Ambil ID jika ada (edit / delete)
$id        = $_GET['edit'] ?? '';
$judulPage = $id ? "Edit Testimonial" : "Tambah Testimonial";

// Jika edit → ambil data lama
$rowEdit = [];
if ($id) {
    $query   = mysqli_query($koneksi, "SELECT * FROM testimonials WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
}

// Jika delete → hapus data + gambar
if (isset($_GET['delete'])) {
    $idDelete   = $_GET['delete'];
    $queryGambar = mysqli_query($koneksi, "SELECT image FROM testimonials WHERE id='$idDelete'");
    $rowGambar   = mysqli_fetch_assoc($queryGambar);

    if (!empty($rowGambar['image']) && file_exists("uploads/" . $rowGambar['image'])) {
        unlink("uploads/" . $rowGambar['image']);
    }

    $delete = mysqli_query($koneksi, "DELETE FROM testimonials WHERE id='$idDelete'");
    if ($delete) {
        header("location:?page=testimonial&hapus=berhasil");
        exit;
    }
}

// Jika simpan (insert / update)
if (isset($_POST['simpan'])) {
    $name         = $_POST['name'];
    $position     = $_POST['position'];
    $rating       = $_POST['rating'];
    $message      = $_POST['message'];
    $image_name   = $rowEdit['image'] ?? '';

    // Upload gambar jika ada file baru
    if (!empty($_FILES['image']['name'])) {
        $image      = $_FILES['image']['name'];
        $tmp_name   = $_FILES['image']['tmp_name'];
        $type_mime  = mime_content_type($tmp_name);
        $ext_allowed = ["image/png", "image/jpg", "image/jpeg"];

        if (in_array($type_mime, $ext_allowed)) {
            $path = "uploads/";
            if (!is_dir($path)) mkdir($path);

            $image_name  = time() . "-" . basename($image);
            $target_file = $path . $image_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                // Hapus gambar lama (jika ada)
                if (!empty($rowEdit['image']) && file_exists($path . $rowEdit['image'])) {
                    unlink($path . $rowEdit['image']);
                }
            }
        } else {
            die("File tidak valid. Hanya JPG, JPEG, PNG yang diperbolehkan.");
        }
    }

    if ($id) {
        // Update data
        $update = mysqli_query($koneksi, "
            UPDATE testimonials SET 
                name='$name', 
                position='$position', 
                rating='$rating', 
                message='$message',   
                image='$image_name' 
            WHERE id='$id'
        ");
        if ($update) {
            header("location:?page=testimonial&ubah=berhasil");
            exit;
        }
    } else {
        // Insert data baru
        $insert = mysqli_query($koneksi, "
            INSERT INTO testimonials 
                (name, position, rating, message, image) 
            VALUES 
                ('$name', '$position', '$rating', '$message', '$image_name')
        ");
        if ($insert) {
            header("location:?page=testimonial&tambah=berhasil");
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

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" required value="<?= $rowEdit['name'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label>Position</label>
                            <input type="text" class="form-control" name="position" required value="<?= $rowEdit['position'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label>Image</label>
                            <input type="file" name="image" <?= $id ? '' : 'required' ?>>
                            <small class="text-muted">* Size : 1920 * 1088</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rating</label><br>
                            <?php
                            $currentRating = $rowEdit['rating'] ?? 0;
                            for ($i = 1; $i <= 5; $i++): ?>
                                <input type="radio" name="rating" value="<?= $i ?>"
                                    <?= ($currentRating == $i) ? 'checked' : '' ?> required>
                                ★
                            <?php endfor; ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" id="summernote" rows="5"
                                class="form-control"><?php echo $id ? htmlspecialchars($rowEdit['message']) : ''; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=testimonial" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>