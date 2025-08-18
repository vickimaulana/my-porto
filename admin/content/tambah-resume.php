<?php
// Ambil ID jika ada (edit / delete)
$id        = $_GET['edit'] ?? '';
$judulPage = $id ? "Edit Resume" : "Tambah Resume";

// Jika edit → ambil data lama
$rowEdit = [];
if ($id) {
    $query   = mysqli_query($koneksi, "SELECT * FROM resumes WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
}

// Jika delete → hapus data
if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $delete   = mysqli_query($koneksi, "DELETE FROM resumes WHERE id='$idDelete'");
    if ($delete) {
        header("location:?page=resume&hapus=berhasil");
        exit;
    }
}

// Jika simpan (insert / update)
if (isset($_POST['simpan'])) {
    $id_user       = $_SESSION['ID_USER'];
    $type          = $_POST['type'];
    $title         = $_POST['title'];
    $subtitle      = $_POST['subtitle'];
    $institution   = $_POST['institution'];
    $start_year    = $_POST['start_year'];
    $end_year      = $_POST['end_year'] ?: NULL;
    $description   = $_POST['description'];
    $credential    = $_POST['link'];

    if ($id) {
        // Update data
        $update = mysqli_query($koneksi, "
            UPDATE resumes SET 
                type='$type',
                title='$title',
                subtitle='$subtitle',
                institution='$institution',
                start_year='$start_year',
                end_year=" . ($end_year ? "'$end_year'" : "NULL") . ",
                description='$description',
                link='$credential'
            WHERE id='$id'
        ");
        if ($update) {
            header("location:?page=resume&ubah=berhasil");
            exit;
        }
    } else {
        // Insert data baru
        $insert = mysqli_query($koneksi, "
            INSERT INTO resumes (type, title, subtitle, institution, start_year, end_year, description, link) 
            VALUES ('$type', '$title', '$subtitle', '$institution', '$start_year', " . ($end_year ? "'$end_year'" : "NULL") . ", '$description', '$link')
        ");
        if ($insert) {
            header("location:?page=resume&tambah=berhasil");
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
                            <label>Type</label>
                            <select name="type" class="form-control" required>
                                <option value="">-- Pilih Type --</option>
                                <option value="experience" <?= ($rowEdit['type'] ?? '') == 'experience' ? 'selected' : '' ?>>Experience</option>
                                <option value="education" <?= ($rowEdit['type'] ?? '') == 'education' ? 'selected' : '' ?>>Education</option>
                                <option value="nonformal" <?= ($rowEdit['type'] ?? '') == 'nonformal' ? 'selected' : '' ?>>Non Formal</option>
                                <option value="certification" <?= ($rowEdit['type'] ?? '') == 'certification' ? 'selected' : '' ?>>Certification</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" required
                                value="<?= $rowEdit['title'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label>Subtitle</label>
                            <input type="text" class="form-control" name="subtitle"
                                value="<?= $rowEdit['subtitle'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label>Institution</label>
                            <input type="text" class="form-control" name="institution"
                                value="<?= $rowEdit['institution'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label>Start Year</label>
                            <input type="number" class="form-control" name="start_year" min="1900" max="<?= date('Y') ?>"
                                value="<?= $rowEdit['start_year'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label>End Year</label>
                            <input type="number" class="form-control" name="end_year" min="1900" max="<?= date('Y') ?>"
                                value="<?= $rowEdit['end_year'] ?? '' ?>">
                            <small class="text-muted">Kosongkan jika masih berlangsung</small>
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea class="form-control" name="description" rows="3"><?= $rowEdit['description'] ?? '' ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Credential URL</label>
                            <input type="url" class="form-control" name="link"
                                value="<?= $rowEdit['link'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=resume" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>