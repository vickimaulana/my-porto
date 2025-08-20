<?php
// Ambil ID jika ada (edit / delete)
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$judulPage = $id ? "Edit Tentang Kami" : "Tambah Tentang Kami";

// Jika edit → ambil data lama
$rowEdit = [];
if ($id) {
    $query = mysqli_query($koneksi, "SELECT * FROM about WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
}

// Jika delete → hapus data + gambar
if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $queryGambar = mysqli_query($koneksi, "SELECT image FROM about WHERE id='$idDelete'");
    $rowGambar = mysqli_fetch_assoc($queryGambar);

    if (!empty($rowGambar['image']) && file_exists("uploads/" . $rowGambar['image'])) {
        unlink("uploads/" . $rowGambar['image']);
    }

    $delete = mysqli_query($koneksi, "DELETE FROM about WHERE id='$idDelete'");
    if ($delete) {
        header("location:?page=about&hapus=berhasil");
        exit;
    }
}

// Jika simpan (insert / update)
if (isset($_POST['simpan'])) {
    $name            = $_POST['name'];
    $title           = $_POST['title'];
    $description     = $_POST['description'];
    $birthday        = $_POST['birthday'];
    $website         = $_POST['website'];
    $phone           = $_POST['phone'];
    $city            = $_POST['city'];
    $age             = $_POST['age'];
    $degree          = $_POST['degree'];
    $email           = $_POST['email'];
    $freelanceStatus = $_POST['freelance_status'];

    $image_name = $rowEdit['image'] ?? '';

    // Upload gambar jika ada file baru
    if (!empty($_FILES['image']['name'])) {
        $image       = $_FILES['image']['name'];
        $tmp_name    = $_FILES['image']['tmp_name'];
        $type_mime   = mime_content_type($tmp_name);
        $ext_allowed = ["image/png", "image/jpg", "image/jpeg"];

        if (in_array($type_mime, $ext_allowed)) {
            $path = "uploads/";
            if (!is_dir($path)) mkdir($path);

            $image_name = time() . "-" . basename($image);
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
            UPDATE about SET 
                name='$name', 
                title='$title', 
                description='$description', 
                birthday='$birthday',
                website='$website', 
                phone='$phone', 
                image='$image_name', 
                city='$city', 
                age='$age', 
                degree='$degree', 
                email='$email', 
                freelance_status='$freelanceStatus'
            WHERE id='$id'
        ");
        if ($update) {
            header("location:?page=about&ubah=berhasil");
            exit;
        }
    } else {
        // Insert data baru
        $insert = mysqli_query($koneksi, "
            INSERT INTO about 
                (name, title, description, birthday, website, phone, image, city, age, degree, email, freelance_status)
            VALUES
                ('$name', '$title', '$description', '$birthday', '$website', '$phone', '$image_name', '$city', '$age', '$degree', '$email', '$freelanceStatus')
        ");
        if ($insert) {
            header("location:?page=about&tambah=berhasil");
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
                            <label>Gambar</label>
                            <input type="file" name="image" <?= $id ? '' : 'required' ?>>
                            <small class="text-muted">* Size : 1920 * 1088</small>
                        </div>
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="name" required
                                value="<?= $id ? $rowEdit['name'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label>Judul</label>
                            <input type="text" class="form-control" name="title" required
                                value="<?= $id ? $rowEdit['title'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label>Tentang Diri</label>
                            <textarea name="description" id="summernote" rows="5"
                                class="form-control"><?php echo $id ? htmlspecialchars($rowEdit['description']) : ''; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" class="form-control" name="birthday" required
                                value="<?= $id ? $rowEdit['birthday'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label>Website</label>
                            <input type="text" class="form-control" name="website" required
                                value="<?= $id ? $rowEdit['website'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" required
                                value="<?= $id ? $rowEdit['phone'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <input type="text" class="form-control" name="city" required
                                value="<?= $id ? $rowEdit['city'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label>Umur</label>
                            <input type="text" class="form-control" name="age" required
                                value="<?= $id ? $rowEdit['age'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label>Pendidikan Terakhir</label>
                            <input type="text" class="form-control" name="degree" required
                                value="<?= $id ? $rowEdit['degree'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" required
                                value="<?= $id ? $rowEdit['email'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label>Status Pekerjaan</label>
                            <input type="text" class="form-control" name="freelance_status" required
                                value="<?= $id ? $rowEdit['freelance_status'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=about" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>
