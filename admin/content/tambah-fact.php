<?php
// Ambil ID jika ada (edit / delete)
$id        = $_GET['edit'] ?? '';
$judulPage = $id ? "Edit Skill" : "Tambah Skill";

// Jika edit → ambil data lama
$rowEdit = [];
if ($id) {
    $query   = mysqli_query($koneksi, "SELECT * FROM facts WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
}

// Jika delete → hapus data + gambar
if (isset($_GET['delete'])) {
    $idDelete   = $_GET['delete'];
    $queryGambar = mysqli_query($koneksi, "SELECT image FROM facts WHERE id='$idDelete'");
    $rowGambar   = mysqli_fetch_assoc($queryGambar);


    $delete = mysqli_query($koneksi, "DELETE FROM fatcs WHERE id='$idDelete'");
    if ($delete) {
        header("location:?page=fact&hapus=berhasil");
        exit;
    }
}

// Jika simpan (insert / update)
if (isset($_POST['simpan'])) {
    $stat_name       = $_POST['stat_name'];
    $stat_value = $_POST['stat_value'];

    if ($id) {
        // Update data
        $update = mysqli_query($koneksi, "
            UPDATE facts SET 
                stat_name='$stat_name', 
                stat_value='$stat_value' 
                WHERE id='$id'
        ");
        if ($update) {
            header("location:?page=fact&ubah=berhasil");
            exit;
        }
    } else {
        // Insert data baru
        $insert = mysqli_query($koneksi, "
            INSERT INTO facts 
                (stat_name,stat_value) 
            VALUES 
                ('$stat_name', '$stat_value')
        ");
        if ($insert) {
            header("location:?page=fact&tambah=berhasil");
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
                            <label>Nama</label>
                            <input type="text" class="form-control" name="stat_name" required value="<?= $rowEdit['stat_name'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label>Value</label>
                            <input type="text" class="form-control" name="stat_value" required value="<?= $rowEdit['stat_value'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=fact" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>