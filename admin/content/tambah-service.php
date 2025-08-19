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
    $icon        = $_POST['icon'];
    $description = $_POST['description'];
    $link        = $_POST['link'];

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

                    <form action="" method="post">
                        <div class="mb-3">
                            <label>Judul Service</label>
                            <input type="text" class="form-control" name="title" required value="<?= $rowEdit['title'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label>Icon + Warna</label>
                            <div class="input-group">
                                <!-- Input icon -->
                                <input type="text" class="form-control" name="icon"
                                    placeholder="contoh: bi-code-slash"
                                    required value="<?= $rowEdit['icon'] ?? '' ?>">

                                <!-- Input warna -->
                                <input type="color" class="form-control form-control-color"
                                    name="icon_color"
                                    value="<?= $rowEdit['icon_color'] ?? '#000000' ?>"
                                    title="Pilih Warna">
                            </div>
                            <small class="text-muted">Gunakan class icon Bootstrap/FontAwesome, lalu pilih warna.</small>
                        </div>


                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="description" id="summernote" rows="5" class="form-control"><?php echo $id ? htmlspecialchars($rowEdit['description']) : ''; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Link (Opsional)</label>
                            <input type="text" class="form-control" name="link" value="<?= $rowEdit['link'] ?? '' ?>" placeholder="https://contoh.com">
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