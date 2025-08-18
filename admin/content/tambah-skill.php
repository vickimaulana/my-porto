<?php
// Ambil ID jika ada (edit / delete)
$id        = $_GET['edit'] ?? '';
$judulPage = $id ? "Edit Skill" : "Tambah Skill";

// Jika edit → ambil data lama
$rowEdit = [];
if ($id) {
    $query   = mysqli_query($koneksi, "SELECT * FROM skills WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
}

// Jika delete → hapus data
if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $delete   = mysqli_query($koneksi, "DELETE FROM skills WHERE id='$idDelete'");
    if ($delete) {
        header("location:?page=skill&hapus=berhasil");
        exit;
    }
}

// Jika simpan (insert / update)
if (isset($_POST['simpan'])) {
    $id_user    = $_SESSION['ID_USER'];
    $name       = $_POST['name'];
    $persentase = $_POST['persentase'];

    if ($id) {
        // Update data
        $update = mysqli_query($koneksi, "
            UPDATE skills SET 
                name='$name', 
                persentase='$persentase',
                id_user='$id_user' 
            WHERE id='$id'
        ");
        if ($update) {
            header("location:?page=skill&ubah=berhasil");
            exit;
        }
    } else {
        // Insert data baru
        $insert = mysqli_query($koneksi, "
            INSERT INTO skills (name, persentase, id_user) 
            VALUES ('$name', '$persentase', '$id_user')
        ");
        if ($insert) {
            header("location:?page=skill&tambah=berhasil");
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
                            <label>Nama</label>
                            <input type="text" class="form-control" name="name" required
                                value="<?= $rowEdit['name'] ?? '' ?>">
                        </div>

                        <div class="mb-3">
                            <label>Persentase</label><br>
                            <input type="range" name="persentase" min="0" max="100" step="1"
                                value="<?= $rowEdit['persentase'] ?? 0 ?>"
                                oninput="this.nextElementSibling.value = this.value">
                            <output><?= $rowEdit['persentase'] ?? 0 ?></output> %
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=skill" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>